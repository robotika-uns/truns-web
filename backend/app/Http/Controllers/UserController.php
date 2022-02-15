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
use App\Log;
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
     * Search Method
     *
     * untuk mencari user.
     *
     */
    public function search()
    {
        $search = $this->request->input('q');
        $users = User::select();
        if (!$search || $search == ' ') {
            $users->where('name', 'like', '%' . '  ' . '%');
            $users->orWhere('username', 'like', '%' . '  ' . '%');
        } else {
            $users->where('name', 'like', '%' . $search . '%');
            $users->orWhere('username', 'like', '%' . $search . '%');
        }

        $users = $users->orderBy('created_at', 'desc')->paginate(10);

        return $users;
    }




    /**
     * All Method
     *
     * Ambil semua data user.
     *
     */
    public function all()
    {
        $search = $this->request->input('q');
        $users = User::select();

        $conditions = $this->request->except(['page', 'q']);

        foreach ($conditions as $column => $value) {
            $array_value = explode(",", $value);
            if ($value != '') {
                $users->whereIn($column, $array_value);
            }
        }

        $users->where(function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%');
            $query->orWhere('username', 'like', '%' . $search . '%');
        });

        $users->with(['journeys' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }]);

        $users = $users->orderBy('created_at', 'desc')->paginate(10);

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




    /**
     * Change Role Method
     *
     * Untuk mengganti role user.
     *
     */
    public function changeRole()
    {
        $roles = implode(',', ['administrator', 'moderator', 'member']);

        $this->validate($this->request, [
            'role' => "required|in:{$roles}",
        ]);

        $user = User::find($this->request->input('user_id'));
        if (count($user) == 0) {
            return response()->json([
                'tag' => 'user.notfound',
                'pesan' => trans('user.notfound'),
            ], 400);
        }

        $user->role = $this->request->input('role');
        $user->save();

        Log::create([
            'user_id' => $this->request->auth->id,
            'type' => 'user',
            'data' => [
                'pesan' => "log.user.role_changed",
                'slug'  => [
                    'causer'    => $this->request->auth->username,
                    'user'      => $user->username,
                    'role'      => $user->role,
                ],
            ],
        ]);

        return response()->json([
            'tag' => 'user.role_changed',
            'pesan' => trans('user.role_changed'),
        ], 200);
    }




    /**
     * Change Tipe Method
     *
     * Untuk mengganti tipe user.
     *
     */
    public function changeTipe()
    {
        $tipe = implode(',', ['outsider', 'anggota', 'alumni']);

        $this->validate($this->request, [
            'tipe' => "required|in:{$tipe}",
        ]);

        $user = User::find($this->request->input('user_id'));
        if (count($user) == 0) {
            return response()->json([
                'tag' => 'user.notfound',
                'pesan' => trans('user.notfound'),
            ], 400);
        }

        $user->tipe = $this->request->input('tipe');
        $user->save();

        Log::create([
            'user_id' => $this->request->auth->id,
            'type' => 'user',
            'data' => [
                'pesan' => "log.user.tipe_changed",
                'slug'  => [
                    'causer'    => $this->request->auth->username,
                    'user'      => $user->username,
                    'tipe'      => $user->tipe,
                ],
            ],
        ]);

        return response()->json([
            'tag' => 'user.tipe_changed',
            'pesan' => trans('user.tipe_changed'),
        ], 200);
    }
}
