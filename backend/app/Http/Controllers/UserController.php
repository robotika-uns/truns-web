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

use App\Helpers\UploadGambar;
use App\Journey;
use App\User;
use Illuminate\Http\Request;
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

        if (!$user) {
            return response()->json([
                'tag' => 'user_tidak_ditemukan',
                'pesan' => trans('user.tidak_ada'),
            ], 404);
        }

        $journey = Journey::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        $user->journey = $journey;

        return response()->json([
            'tag' => 'user_ditemukan',
            'pesan' => trans('recruit.belum_submit'),
            'data' => $user,
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
            'name' => 'required|regex:/^[a-zA-Z0-9\s]+$/',
        ]);

        $input = array_map('trim', $this->request->all());

        $this->request->auth->update($input);
    }

    /**
     * Upload Photo Method
     *
     * Untuk mengupdate foto profil.
     *
     */
    public function photo()
    {
        // Validasi input.
        $this->validate($this->request, [
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $photo = UploadGambar::upload($this->request->file('photo'));

        $this->request->auth->update(["photo" => $photo]);

        return response()->json([
            'tag' => 'upload_sukses',
            'pesan' => 'Foto berhasil diganti.',
            'photo' => $photo,
        ], 200);
    }
}
