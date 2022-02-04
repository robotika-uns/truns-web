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
use App\Recruit;
use App\Session;
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




class RecruitController extends BaseController
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
     * Create Method
     * 
     * Untuk membuat recruit baru.
     * 
     */
    public function create()
    {

        $tim = implode(',', ['sambergeni', 'maladi', 'werkudara', 'sriwedari', 'dewisri', 'jaladara']);
        $divisi = implode(',', ['programmer', 'elektro', 'mekanik', 'sekretaris', 'bendahara', 'internal', 'media']);


        // Validasi input.
        $this->validate($this->request, [
            'nim'               => 'required',
            'prodi'             => 'required',
            'fakultas'          => 'required',
            'tempat_lahir'      => 'required',
            'tanggal_lahir'     => 'required|date',
            'alamat'            => 'required',
            'kos'               => '',
            'no_wa'             => 'required|integer',
            'sosmed'            => 'required',
            'kegiatan'          => 'required',
            'keahlian'          => 'required',
            'tim_prioritas'     => "required|in:{$tim}",
            'divisi_prioritas'  => "required|in:{$divisi}",
            'tim_alternatif'    => "required|in:{$tim}",
            'divisi_alternatif' => "required|in:{$divisi}",
            'alasan'            => 'required',
            'essay'             => '',
            'pas_photo'         => '',
            'karmas'            => '',
            'krs'               => '',
        ]);

        // Cari recruit berdasarkan user_id dan masih berstatus proses.
        $recruit = Recruit::where('user_id', $this->request->auth->id)
            ->where('status', 'diproses')
            ->first();

        // Jika user sudah mengirim formulir sebelumnya.
        if ($recruit) {
            // Kirim respon [400] 'recruit_sudah_submit'.
            return response()->json([
                'tag' => 'recruit_sudah_submit',
                'pesan' => trans('recruit.sudah_submit')
            ], 400);
        }

        // Buat recruit baru.
        $recruit = new Recruit;
        $recruit->user_id = $this->request->auth->id;
        $recruit->status = 'diproses';
        $recruit->fill($this->request->all());
        $recruit->save();

        Notification::send($this->request->auth, new RecruitNotification($recruit, ['tim' => 'sambergeni']));

        // Kirim respon [200] 'formulir_terkirim'.
        return response()->json([
            'tag' => 'formulir_terkirim',
            'pesan' => trans('recruit.formulir_terkirim'),
        ], 200);
    }




    /**
     * Check Method
     * 
     * Untuk cek apakah user sudah mengirim formulir sebelumnya.
     * 
     */
    public function check()
    {
        // Cari recruit berdasarkan user_id dan masih berstatus proses.
        $recruit = Recruit::where('user_id', $this->request->auth->id)
            ->where('status', 'diproses')
            ->first();

        // Jika user sudah mengirim formulir sebelumnya.
        if ($recruit) {
            // Kirim respon [403] 'recruit_sudah_submit'.
            return response()->json([
                'tag' => 'recruit_sudah_submit',
                'pesan' => trans('recruit.sudah_submit')
            ], 403);
        }

        // Cari recruit berdasarkan user_id dan statusnya sudah diterima.
        $recruit = Recruit::where('user_id', $this->request->auth->id)
            ->where('status', 'diterima')
            ->first();

        // Jika user sudah mengirim formulir sebelumnya.
        if ($recruit) {
            // Kirim respon [403] 'recruit_sudah_diterima'.
            return response()->json([
                'tag' => 'recruit_sudah_diterima',
                'pesan' => trans('recruit.sudah_diterima')
            ], 403);
        }

        // Kirim respon [200] 'recruit_belum_submit'.
        return response()->json([
            'tag' => 'recruit_belum_submit',
            'pesan' => trans('recruit.belum_submit')
        ], 200);
    }
}
