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

use App\Helpers\KirimEmail;
use App\Session;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Jenssegers\Agent\Agent;
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
            'email' => 'required',
            'password' => 'required',
        ]);

        // Cari user dengan email.
        $this->user = User::where('email', $email)->first();

        // Jika tidak ada, cari user dengan username.
        if (!$this->user) {
            $this->user = User::where('username', $email)->first();
        }

        // Jika user dengan email input tidak ditemukan.
        if (!$this->user) {
            // Kirim respon [400] 'login_gagal'.
            return response()->json([
                'tag' => 'login_gagal',
                'pesan' => trans('auth.login_gagal'),
            ], 400);
        }

        // Verifikasi password dan jika password salah.
        if (!Hash::check($password, $this->user->password)) {

            // Kirim respon [400] 'login_salah'.
            return response()->json([
                'tag' => 'login_salah',
                'pesan' => trans('auth.login_salah'),
            ], 400);
        }

        // Buat session baru dan ambil nilai session id.
        $token = $this->createSession();

        // Kirim respon [200] 'login_sukses'.
        return response()->json([
            'tag' => 'login_sukses',
            'pesan' => trans('auth.login_sukses'),
            'token' => $token,
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
            'name' => 'required|regex:/^[a-zA-Z0-9\s]+$/',
            'username' => 'required|alpha_dash|min:8|max:25|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|max:64',
        ]);

        // Mengambil request input.
        $name = trim($this->request->input('name'));
        $username = $this->request->input('username');
        $email = $this->request->input('email');
        $password = Hash::make($this->request->input('password'));

        // Membuat user baru.
        $this->user = new User;
        $this->user->name = $name;
        $this->user->username = $username;
        $this->user->email = $email;
        $this->user->password = $password;
        $this->user->role = "member";
        $this->user->tipe = "outsider";
        $this->user->email_verified = 0;
        $this->user->save();
        $this->request->auth = $this->user;

        // Mengotentikasi user.
        $authenticate_response = $this->authenticate();

        // Mengirim email verifikasi.
        $resend_response = $this->resend();

        // Kirim respon [200] 'register_sukses'.
        return response()->json([
            'tag' => 'register_sukses',
            'pesan' => trans('auth.register_sukses'),
            'token' => $authenticate_response->original['token'],
        ], 200);
    }

    /**
     * Verify Method
     *
     * Untuk memverifikasi email.
     *
     */

    public function verify()
    {

        $verification_code = $this->request->input('verification_code');

        $last_updated = new Carbon($this->request->auth->updated_at);
        $difference = $last_updated->diffInSeconds(Carbon::now());
        $abs_difference = abs(
            $difference - config('auth.verify_kadaluarsa')
        );

        // Jika kode verifikasi sudah kadaluarsa
        if ($difference > config('auth.verify_kadaluarsa')) {

            // Kirim respon [403] 'verify_kadaluarsa'.
            return response()->json([
                'tag' => 'verify_kadaluarsa',
                'pesan' => trans(
                    'auth.verify_kadaluarsa'
                ),
            ], 403);
        }

        // Jika kode verifikasi salah
        if (!($verification_code == $this->request->auth->email_verified)) {
            // Kirim respon [400] 'verify_salah'.
            return response()->json([
                'tag' => 'verify_salah',
                'pesan' => trans('auth.verify_salah'),
            ], 400);
        }

        // Ubah status email menjadi terverifikasi.
        $this->request->auth->email_verified = 'verified';
        $this->request->auth->save();

        // Kirim respon [200] 'verify_sukses'.
        return response()->json([
            'tag' => 'verify_sukses',
            'pesan' => trans('auth.verify_sukses'),
        ], 200);
    }

    /**
     * Resend Method
     *
     * Untuk mengirim ulang email kode verifikasi.
     *
     */

    public function resend()
    {

        // Jika mencoba mengirim email dalam masa cooldown.
        $last_updated = new Carbon($this->request->auth->updated_at);
        $difference = $last_updated->diffInSeconds(Carbon::now());
        $abs_difference = abs($difference - config('auth.resend_cooldown'));

        if (
            $difference < config('auth.resend_cooldown')
            && !$this->request->auth->email_verified == 0
        ) {

            // Kirim respon [403] 'resend_cooldown'.
            return response()->json([
                'tag' => 'resend_cooldown',
                'cooldown' => $abs_difference,
                'pesan' => trans(
                    'auth.resend_cooldown',
                    ['waktu' => $abs_difference]
                ),
            ], 403);
        }

        $verification_code = random_int(100000, 999999);
        $this->request->auth->email_verified = $verification_code;
        $this->request->auth->save();

        // Mengirim email verifikasi.
        $this->sendVerificationEmail($verification_code);

        // Kirim respon [200] 'resend_sukses'.
        return response()->json([
            'tag' => 'resend_sukses',
            'pesan' => trans('auth.resend_sukses'),
        ], 200);
    }

    /**
     * Resend Get Cooldown Method
     *
     * Untuk mengirim ulang email verifikasi.
     *
     */

    public function resendGetCooldown()
    {

        // Jika mencoba mengirim email dalam masa cooldown.
        $last_updated = new Carbon($this->request->auth->updated_at);
        $difference = $last_updated->diffInSeconds(Carbon::now());
        $abs_difference = abs($difference - config('auth.resend_cooldown'));

        if (
            $difference < config('auth.resend_cooldown')
            && !$this->request->auth->email_verified == 0
        ) {

            // Kirim respon [403] 'resend_cooldown'.
            return response()->json([
                'tag' => 'resend_cooldown',
                'cooldown' => $abs_difference,
                'pesan' => trans(
                    'auth.resend_cooldown',
                    ['waktu' => $abs_difference]
                ),
            ], 200);
        }
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

        // Kirim respon [200] 'logout_sukses'.
        return response()->json([
            'tag' => 'logout_sukses',
            'pesan' => trans('auth.logout_sukses'),
        ], 200);
    }

    /**
     * Whoami Method
     *
     * Untuk mengetahui siapa user yang sedang login.
     *
     */

    public function whoami()
    {

        $session = Session::find($this->request->sessions->id)
            ->with('user')
            ->first();

        // Kirim respon [200] 'whoami_sukses'.
        return response()->json([
            'tag' => 'whoami_sukses',
            'data' => $session,
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
     * Untuk mengirim email kode verifikasi.
     *
     */
    public function sendVerificationEmail($verification_code)
    {

        $penerima = [
            'Email' => $this->request->auth->email,
            'Name' => $this->request->auth->name,
        ];

        $variables = [
            'name' => explode(' ', trim($this->request->auth->name))[0],
            'verification_code' => $verification_code,
        ];

        KirimEmail::kirim([
            'penerima' => $penerima,
            'template' => 3516106,
            'judul' => 'Verifikasi Email Akun Robotika UNS',
            'variables' => $variables,

        ]);
    }
}
