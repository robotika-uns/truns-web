<?php

/**
 * -----------------------------------------------------------------------------
 * Journey Controller
 * -----------------------------------------------------------------------------
 * 
 * Kontroler yang memproses semua route Journey.
 * 
 */




namespace App\Http\Controllers;

use App\User;
use App\Journey;
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




class JourneyController extends BaseController
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
     * Untuk membuat journey baru pada user.
     * 
     */
    public function create()
    {
        //     $notifications = $this->request->auth->notifications;

        // Buat journey baru.
        // $journey = new Journey;
        // $journey->fill($this->request->all());
        // $journey->save();
        $journey = Journey::create($this->request->all());

        // $lastLoggedActivity->created_at = $this->request->created_at;
        // $lastLoggedActivity->save();
        //     if ($notifications == '[]') {

        //         // Kirim respon [200] 'notifikasi_kosong'.
        //         return response()->json([
        //             'tag'   => 'notifikasi_kosong',
        //             'pesan' => trans('recruit.belum_submit')
        //         ], 200);
        //     }

        //     foreach ($notifications as $notification) {
        //         // $pesan = $notification->data['pesan'];
        //         $notification->data = array_merge($notification->data, [
        //             "pesan" => trans("notification.{$notification->data['pesan']}", $notification->data['slug'])
        //         ]);
        //     }

        //     // Kirim respon [200] 'notifikasi_ada'.
        //     return response()->json([
        //         'tag'   => 'notifikasi_ada',
        //         'pesan' => trans('recruit.belum_submit'),
        //         'data'  => $notifications
        //     ], 200);
    }




    /**
     * Get Journey By User Method
     * 
     * Untuk mengambil journey berdasrkan user.
     * 
     */
    public function getJourneyByUser($user_id)
    {
    }
}
