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
use App\Log;
use Illuminate\Http\Request;
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

        $this->validate($this->request, [
            'user_id'           => 'required',
            'tim'               => 'required',
            'struktur'          => '',
            'divisi'            => 'required',
            'tanggal_gabung'    => 'required|date',
        ]);

        // Buat journey baru.
        $journey = Journey::create($this->request->all());

        Log::create([
            'user_id' => $this->request->auth->id,
            'type' => 'journey',
            'data' => [
                'pesan' => "log.journey.created",
                'slug'  => [
                    'causer'    => $this->request->auth->username,
                    'user'      => User::find($this->request->user_id)->username,
                    'tim'       => $journey->tim,
                    'divisi'    => $journey->divisi,
                ],
            ],
        ]);

        $journeys = User::select();
        $journeys->where('id', $journey->user_id);
        $journeys->with(['journeys' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }]);

        $journeys = $journeys->first();
        $journeys = $journeys['journeys'];
        return $journeys;
    }




    /**
     * Delete Method
     * 
     * Untuk menghapus journey pada user.
     * 
     */
    public function delete()
    {

        $this->validate($this->request, [
            'id'    => 'required',
        ]);

        $journey = Journey::find($this->request->id);
        $user_id = $journey->user_id;

        if (!$journey) {
            return response()->json([
                'tag' => 'journey.notfound',
                'pesan' => trans('journey.notfound')
            ], 404);
        }

        Log::create([
            'user_id' => $this->request->auth->id,
            'type' => 'journey',
            'data' => [
                'pesan' => "log.journey.deleted",
                'slug'  => [
                    'causer'    => $this->request->auth->username,
                    'user'      => User::find($user_id)->username,
                    'tim'       => $journey->tim,
                    'divisi'    => $journey->divisi,
                ],
            ],
        ]);

        $journey->delete();

        $journeys = User::select();
        $journeys->where('id', $user_id);
        $journeys->with(['journeys' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }]);

        $journeys = $journeys->first();
        $journeys = $journeys['journeys'];
        return $journeys;
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
