<?php

/**
 * -----------------------------------------------------------------------------
 * Log Controller
 * -----------------------------------------------------------------------------
 * 
 * Kontroler yang memproses semua route Log.
 * 
 */




namespace App\Http\Controllers;

use App\Log;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;




class LogController extends BaseController
{

    /**
     * Constructor Injection
     * 
     */

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }




    /**
     * Read Method
     * 
     * Untuk mengambil semua log.
     * 
     */
    public function read()
    {
        $logs = Log::orderBy('created_at', 'desc')->paginate(10);
        foreach ($logs as $log) {
            $pesan = $log->data['pesan'];
            $log->data = array_merge($log->data, [
                "pesan" => trans($log->data['pesan'], $log->data['slug'])
            ]);
        }
        return $logs;
    }
}
