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
use App\Recruit;
use App\Setting;
use App\Journey;
use App\User;
use App\Notifications\RecruitNotification;
use Illuminate\Http\Request;
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

        $check_response = $this->check();
        $status = collect($check_response)['original']['tag'];
        if ($status != 'recruit.buka') {
            return $check_response;
        }

        $tim = implode(',', ['sambergeni', 'maladi', 'werkudara', 'sriwedari', 'dewisri', 'jaladara']);
        $divisi = implode(',', ['programmer', 'elektro', 'mekanik', 'sekretaris', 'bendahara', 'internal', 'media']);

        // Validasi input.
        $this->validate($this->request, [
            'nim' => 'required',
            'prodi' => 'required',
            'fakultas' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required',
            'kos' => '',
            'no_wa' => 'required|integer',
            'sosmed' => 'required',
            'kegiatan' => 'required',
            'keahlian' => 'required',
            'tim_prioritas' => "required|in:{$tim}",
            'divisi_prioritas' => "required|in:{$divisi}",
            'tim_alternatif' => "required|in:{$tim}",
            'divisi_alternatif' => "required|in:{$divisi}",
            'alasan' => 'required',
            'essay' => '',
            'pas_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'karmas' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'krs' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);




        $pas_photo = UploadGambar::upload($this->request->file('pas_photo'));
        $karmas = UploadGambar::upload($this->request->file('karmas'));
        $krs = UploadGambar::upload($this->request->file('krs'));

        // Buat recruit baru.
        $recruit = new Recruit;
        $recruit->user_id = $this->request->auth->id;
        $recruit->status = 'diproses';
        $recruit->batch = Setting::get('recruit.batch');
        $recruit->pas_photo = $pas_photo;
        $recruit->karmas = $karmas;
        $recruit->krs = $krs;
        $recruit->fill($this->request->except(['krs', 'karmas', 'pas_photo']));
        $recruit->save();

        // Notification::send(
        //     $this->request->auth,
        //     new RecruitNotification($recruit, [
        //         'tim'       => $recruit->tim_prioritas,
        //         'divisi'    => $recruit->divisi_prioritas,
        //         'status'    => 'diproses',
        //     ])
        // );

        // Kirim respon [200] 'submitted'.
        return response()->json([
            'tag' => 'submitted',
            'pesan' => trans('recruit.submitted'),
        ], 200);
    }




    /**
     * Read Method
     *
     * Untuk mengambil semua data recruit.
     *
     */
    public function read()
    {
        $recruit = Recruit::with('user')->paginate(10);

        return $recruit;
    }




    /**
     * Check Method
     *
     * Untuk cek apakah user sudah mengirim formulir sebelumnya.
     *
     */
    public function check()
    {
        $status = Setting::get('recruit.status');

        if ($status == 0) {
            return response()->json([
                'tag' => 'recruit.tutup',
                'pesan' => trans('recruit.tutup'),
            ], 403);
        }

        // Cari recruit berdasarkan user_id.
        $recruit = Recruit::where('user_id', $this->request->auth->id)
            ->first();

        if ($recruit) {
            // Jika recruit sudah mengirim formulir sebelumnya.
            if ($recruit->status == 'diproses') {
                return response()->json([
                    'tag' => 'recruit.process',
                    'pesan' => trans('recruit.process'),
                ], 403);
            }

            // Jika recruit sudah diterima.
            if ($recruit->status == 'diterima') {
                return response()->json([
                    'tag' => 'recruit.accept',
                    'pesan' => trans('recruit.accept'),
                ], 403);
            }
        }

        // Selain itu semua diatas,
        return response()->json([
            'tag' => 'recruit.buka',
            'pesan' => trans('recruit.buka'),
        ], 200);
    }




    /**
     * Terima Method
     *
     * Untuk menerima recruit.
     *
     */
    public function terima()
    {

        // Ambil inputan id.
        $id = $this->request->input('id');

        // Cari recruit berdasarkan id.
        $recruit = Recruit::find($id);

        // Jika recruit sudah diterima.
        if ($recruit->status == 'diterima') {
            return response()->json([
                'tag' => 'recruit_accept',
                'pesan' => trans('recruit.accept'),
            ], 403);
        }

        $recruit->tim_diterima = $this->request->input('tim');
        $recruit->divisi_diterima = $this->request->input('divisi');
        $recruit->status = 'diterima';
        $recruit->save();

        // $journey = Journey::create($this->request->all());
        // $journey->tanggal_gabung = $journey->created_at;
        // $journey->save();

        // $user = User::find($recruit->user_id);
        // $user->tipe = "anggota";
        // $user->save();

        // Notification::send(
        //     $this->request->auth,
        //     new RecruitNotification($recruit, [
        //         'tim'       => $journey->tim,
        //         'divisi'    => $journey->divisi,
        //         'status'    => 'diterima',
        //     ])
        // );

        return response()->json([
            'tag' => 'recruit_berhasil_diterima',
            'pesan' => trans('recruit.berhasil_diterima'),
        ], 200);
    }

    /**
     * Terima Method
     *
     * Untuk menerima recruit.
     *
     */
    public function tolak()
    {

        // Ambil inputan id.
        $id = $this->request->input('id');

        // Cari recruit berdasarkan user_id.
        $recruit = Recruit::find($id);

        // Jika recruit sudah ditolak.
        if ($recruit->status == 'ditolak') {
            return response()->json([
                'tag' => 'recruit_sudah_ditolak',
                'pesan' => trans('recruit.sudah_ditolak'),
            ], 403);
        }

        $recruit->status = 'ditolak';
        $recruit->tim_diterima = null;
        $recruit->divisi_diterima = null;
        $recruit->save();

        // Notification::send(
        //     $this->request->auth,
        //     new RecruitNotification($recruit, [
        //         'status'    => 'ditolak',
        //     ])
        // );

        return response()->json([
            'tag' => 'recruit_berhasil_ditolak',
            'pesan' => trans('recruit.berhasil_ditolak'),
        ], 200);
    }
}
