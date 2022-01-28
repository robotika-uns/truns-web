<?php

/**
 * -----------------------------------------------------------------------------
 * Auth Controller
 * -----------------------------------------------------------------------------
 * 
 * Kontroler yang memproses semua route Authentication.
 * 
 */




namespace App\Http\Controllers;

use App\User;
use App\Session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Mailjet\Resources;
use Illuminate\Support\Facades\Crypt;
use Laravel\Lumen\Routing\Controller as BaseController;




class AuthController extends BaseController
{

	/**
	 * Constructor Injection
	 * 
	 */

	protected $request;
	protected $user;
	protected $jwt_key;

	public function __construct(Request $request, User $user)
	{
		$this->request = $request;
		$this->user = $user;
		$this->jwt_key = env("JWT_SECRET");
	}




	/**
	 * Authenticate Method
	 * 
	 * Untuk mengotentikasi user.
	 * 
	 */
	public function authenticate()
	{

		// Mengambil request input.
		$email = $this->request->input('email');
		$password = $this->request->input('password');

		// Validasi input.
		$this->validate($this->request, [
			'email'     => 'required|email',
			'password'  => 'required'
		]);

		// Cari user dengan email.
		$this->user = User::where('email', $email)->first();

		// Jika user dengan email input tidak ditemukan.
		if (!$this->user) {

			// Kirim respon [400] 'login_failed'.
			return response()->json([
				'tag' => 'login_failed',
				'message' => trans('auth.login_failed')
			], 400);
		}

		// Verifikasi password dan jika password salah.
		if (!Hash::check($password, $this->user->password)) {

			// Kirim respon [400] 'login_wrong'.
			return response()->json([
				'tag' => 'login_wrong',
				'message' => trans('auth.login_wrong')
			], 400);
		}

		// Buat session baru dan ambil nilai session id.
		$token = $this->createSession();

		// Kirim respon [200] 'login_success'.
		return response()->json([
			'tag' => 'login_success',
			'message' => trans('auth.login_success'),
			'token' => $token
		], 200);
	}




	/**
	 * Register Method
	 * 
	 * Untuk membuat user baru.
	 * 
	 */
	public function register()
	{

		// Validasi input.
		$this->validate($this->request, [
			'name'      => 'required',
			'email'     => 'required|email',
			'password'  => 'required|min:6'
		]);

		// Mengambil request input.
		$name = $this->request->input('name');
		$email = $this->request->input('email');
		$password = Hash::make($this->request->input('password'));

		// Jika user dengan email input sudah ada,
		$this->user = User::where('email', $email)->first();
		if ($this->user) {

			// Kirim respon [400] 'register_failed'.
			return response()->json([
				'tag' => 'register_failed',
				'message' => trans('auth.register_failed')
			], 400);
		}

		// Membuat user baru.
		$this->user = new User;
		$this->user->name = $name;
		$this->user->email = $email;
		$this->user->password = $password;
		$this->user->role = "member";
		$this->user->email_verified = 0;
		$this->user->save();
		$this->request->auth = $this->user;

		// Mengotentikasi user.
		$authenticate_response = $this->authenticate();

		// Mengirim email verifikasi.
		$resend_response = $this->resend();

		return $authenticate_response;
	}




	/**
	 * Verify Method
	 * 
	 * Untuk memverifikasi email.
	 * 
	 */

	public function verify()
	{

		$token = $this->request->input('token');

		/**
		 * Mencoba mendekrip token.
		 * 
		 * Jika token expired, kirim respon [401] 'token_expired'.
		 * Jika token salah, kirim repon [400] 'token_invalid'
		 */
		try {
			$decoded_token = JWT::decode(
				$token,
				new Key($this->jwt_key, 'HS256')
			);
			$decoded_array = (array) $decoded_token;
		} catch (\Firebase\JWT\ExpiredException $th) {
			// Kirim respon [403] 'verify_expired'.
			return response()->json([
				'tag' => 'verify_expired',
				'message' => trans('auth.verify_expired')
			], 403);
		} catch (\UnexpectedValueException $th) {
			// Kirim respon [400] 'verify_invalid'.
			return response()->json([
				'tag' => 'verify_invalid',
				'message' => trans('auth.verify_invalid')
			], 400);
		}

		// Jika token valid, cari user.
		$this->user = User::find($decoded_array['sub']);

		// Jika user tidak ditemukan.
		if (!$this->user) {
			return response()->json([
				'tag' => 'verify_invalid',
				'message' => trans('auth.verify_invalid')
			], 400);
		}

		// Jika email sudah terverifikasi.
		if ($this->user->email_verified == 'verified') {

			// Kirim respon [403] 'verify_failed'.
			return response()->json([
				'tag' => 'verify_failed',
				'message' => trans('auth.verify_failed')
			], 403);
		}

		// Ubah status email menjadi terverifikasi.
		$this->user->email_verified = 'verified';
		$this->user->save();

		// Kirim respon [200] 'verify_success'.
		return response()->json([
			'tag' => 'verify_success',
			'message' => trans('auth.verify_success')
		], 200);
	}




	/**
	 * Resend Method
	 * 
	 * Untuk mengirim ulang email verifikasi.
	 * 
	 */

	public function resend()
	{

		// Jika percobaan mengirim email lebih dari 5x.
		$email_verified = $this->request->auth->email_verified;
		if ($email_verified >= config('auth.resend_limit')) {

			// Kirim respon [403] 'resend_limit'.
			return response()->json([
				'tag' => 'resend_limit',
				'message' => trans('auth.resend_limit')
			], 403);
		}

		// Jika mencoba mengirim email dalam masa cooldown.
		$last_updated = new Carbon($this->request->auth->updated_at);
		$difference = $last_updated->diffInSeconds(Carbon::now());
		$abs_difference = abs($difference - config('auth.resend_cooldown'));

		if (
			$difference < config('auth.resend_cooldown')
			&& !$email_verified == 0
		) {

			// Kirim respon [403] 'resend_cooldown'.
			return response()->json([
				'tag' => 'resend_cooldown',
				'cooldown' => $abs_difference,
				'message' => trans(
					'auth.resend_cooldown',
					['waktu' => $abs_difference]
				)
			], 403);
		}

		// Increment +1 percobaan kirim ulang email.
		$this->request->auth->email_verified += 1;
		$this->request->auth->save();

		$user_created_at = new Carbon($this->request->auth->created_at);

		/**
		 * Buat JWT token untuk verifikasi email.
		 * 
		 * iss: Issuer server.
		 * for: Keperluan token.
		 * sub: User ID.
		 * iat: Issued at (Waktu dibuat).
		 * exp: Expired (Waktu kadaluarsa).
		 * 
		 */
		$payload = array(
			'iss' => env('BASE_API_URL'),
			'for' => 'email_verification',
			'sub' => $this->request->auth->id,
			'iat' => time(),
			'exp' => $user_created_at->addSeconds(config('auth.verify_expired'))
				->timestamp
		);
		$token = JWT::encode($payload, $this->jwt_key, 'HS256');

		// Mengirim email verifikasi.
		$this->sendVerificationEmail($token);

		// Kirim respon [200] 'resend_success'.
		return response()->json([
			'tag' => 'resend_success',
			'message' => trans('auth.resend_success')
		], 200);
	}




	/**
	 * Logout Method
	 * 
	 * Untuk logout dan menghapus session.
	 * 
	 */

	public function logout()
	{

		// Delete session saat ini dari database.
		Session::destroy($this->request->sessions->id);

		// Kirim respon [200] 'logout_success'.
		return response()->json([
			'tag' => 'logout_success',
			'message' => trans('auth.logout_success')
		], 200);
	}




	/**
	 * -------------------------------------------------------------------------
	 * Function Helpers
	 * -------------------------------------------------------------------------
	 * 
	 * Kumpulan function pembantu method function utama.
	 * 
	 */


	/**
	 * Create Session Method
	 * 
	 * Untuk membuat session baru.
	 * 
	 */
	public function createSession()
	{

		// Buat akses token berdasarkan microtime().
		$token = Hash::make(microtime());

		// Buat objek agent.
		$agent = new Agent();
		$agent->setUserAgent($this->request->userAgent());

		// Catat IP Address.
		$ip_address = $this->request->ip();

		// Catat device yang digunakan user.
		$device = $agent->device();

		// Catat platform yang digunakan user.
		$platform_version = $agent->version($agent->platform());
		$platform = $agent->platform() . ' ' . $platform_version;

		// Cata browser yang digunakan user.
		$browser_version = $agent->version($agent->browser());
		$browser = $agent->browser() . ' ' . $browser_version;

		// Buat session baru.
		$sessions = Session::create([
			'id' => $token,
			'user_id' => $this->user->id,
			'ip' => $ip_address,
			'device' => $device,
			'platform' => $platform,
			'browser' => $browser,
		]);

		// Taruh user dan session ke dalam request.
		$this->request->auth = $this->user;
		$this->request->sessions = $sessions;

		// Mengenkripsi akses token.
		$encrypted_token = Crypt::encrypt($token);

		return $encrypted_token;
	}




	/**
	 * Send Verification Email Method
	 * 
	 * Untuk mengirim email verifikasi.
	 * 
	 */
	public function sendVerificationEmail($token)
	{
		$verify_link = env('BASE_API_URL') . '/auth/verify?token=' . $token;
		$mj = new \Mailjet\Client(
			env("MAILJET_APIKEY_PUBLIC"),
			env("MAILJET_APIKEY_PRIVATE"),
			true,
			['version' => 'v3.1']
		);
		$body = [
			'Messages' => [
				[
					'From' => [
						'Email' => "robotika@mail.uns.ac.id",
						'Name' => "UKM Robotika UNS"
					],
					'To' => [
						[
							'Email' => $this->request->auth->email,
							'Name' => $this->request->auth->name
						]
					],
					'TemplateID' => 3516106,
					'TemplateLanguage' => true,
					'Subject' => "Verifikasi Email Akun Robotika UNS",
					'Variables' => json_decode('{
		    "name": "' . $this->request->auth->name . '",
		    "link": "' . $verify_link . '"
		  }', true)
				]
			]
		];
		$response = $mj->post(Resources::$Email, ['body' => $body]);
		$response->success();
	}
}
