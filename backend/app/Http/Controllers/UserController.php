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
        $user = User::where('username', $username)->with(['journeys' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])->first();

        if (!$user) {
            return response()->json([
                'tag' => 'user_tidak_ditemukan',
                'pesan' => trans('user.tidak_ada'),
            ], 404);
        }

        return $user;
    }




    /**
     * Check Method
     *
     * Untuk cek apakah user sudah mengirim formulir sebelumnya.
     *
     */
    public function search()
    {
        $search = $this->request->input('q');
        $users = User::select();
        if (!$search || $search == ' ') {
            // return response()->json([
            //     'tag' => 'parameter.invalid',
            //     'pesan' => "Parameter tidak valid.",
            // ], 400);
            $users->where('name', 'like', '%' . '  ' . '%');
            $users->orWhere('username', 'like', '%' . '  ' . '%');
        } else {
            $users->where('name', 'like', '%' . $search . '%');
            $users->orWhere('username', 'like', '%' . $search . '%');
        }


        $users = $users->orderBy('created_at', 'desc')->paginate(10);

        try {
        } catch (\Exception $ex) {
            // Kirim respon [200] 'submitted'.
            return response()->json([
                'tag' => 'parameter.invalid',
                'pesan' => "Parameter tidak valid.",
            ], 400);
        }

        return $users;
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
            'bio' => 'min:0|max:55',
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
