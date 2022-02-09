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

use App\Setting;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class SettingController extends BaseController
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




    public function get()
    {
        $input = $this->request->name;
        $exploded = explode(",", $input);
        $setting = [];
        foreach ($exploded as $x) {
            $setting2 = Setting::get($x);
            if ($setting2 == 'setting.invalid') {
                return response()->json([
                    'tag' => 'setting.invalid',
                    'pesan' => "Setting ${x} tidak valid."
                ], 404);
            }
            $setting[$x] = $setting2;
        }

        return $setting;
    }




    public function set()
    {
        $input = $this->request->all();
        $setting = Setting::get($input['name']);

        if ($setting == 'setting.invalid') {
            return response()->json([
                'tag' => 'setting.invalid',
                'pesan' => "Setting ${input['name']} tidak valid."
            ], 404);
        }

        $settings = Setting::where('name', $input['name'])->first();
        $granted = false;

        foreach ($settings->roles as $role) {
            if ($this->request->auth->role == $role) {
                $granted = true;
            }
        }

        if (!$granted) {
            return response()->json([
                'tag' => 'forbidden',
                'pesan' => 'Kamu tidak diizinkan mengakses ini.'
            ], 401);
        }

        Setting::set($input['name'], $input['value']);

        return response()->json([
            'tag' => 'setting.changed',
            'pesan' => "Setting ${input['name']} berhasil diubah."
        ], 200);
    }
}
