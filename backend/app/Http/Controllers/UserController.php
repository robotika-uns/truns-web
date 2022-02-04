<?php

/**
 * -----------------------------------------------------------------------------
 * Recruit Controller
 * -----------------------------------------------------------------------------
 * 
 * Kontroler yang memproses semua route Recruitment.
 * 
 */




namespace App\Http\Controllers;

use App\User;
use App\Journey;
use App\Notifications\RecruitNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Mailjet\Resources;
use Illuminate\Support\Facades\Notification;
use Laravel\Lumen\Routing\Controller as BaseController;




class UserController extends BaseController
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
     * Check Method
     * 
     * Untuk cek apakah user sudah mengirim formulir sebelumnya.
     * 
     */
    public function getUserByUsername($username)
    {
        // Cari recruit berdasarkan user_username dan masih berstatus proses.
        $user = User::where('username', $username)
            ->first();


        // Jika user sudah mengirim formulir sebelumnya.
        if (!$user) {
            // Kirim respon [403] 'recruit_sudah_submit'.
            return response()->json([
                'tag' => 'user_tidak_ditemukan',
                'pesan' => trans('user.tidak_ada')
            ], 404);
        }

        $journey = Journey::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        $user->journey = $journey;

        // Kirim respon [200] 'recruit_belum_submit'.
        return response()->json([
            'tag'   => 'user_ditemukan',
            'pesan' => trans('recruit.belum_submit'),
            'data'  => $user
        ], 200);
    }




    /**
     * Update Method
     * 
     * Untuk mengupdate profil.
     * 
     */
    public function update()
    {
        // Validasi input.
        $this->validate($this->request, [
            'name'   => 'required',
        ]);

        $this->request->auth->update($this->request->all());
    }
}
