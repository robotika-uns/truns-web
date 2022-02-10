<?php

namespace App\Helpers;

use GuzzleHttp\Client as GuzzleClient;

class UploadGambar
{

    public static function upload($file)
    {
        $client = new GuzzleClient();
        $res = $client->request('POST', "https://api.imgbb.com/1/upload", [
            'verify' => env('APP_ENV') == 'local' ? '../cacert.pem' : '/home/robotika/cacert.pem',
            'multipart' => [
                [
                    'name' => 'key',
                    'contents' => env('IMGBB_API_KEY'),
                ],
                [
                    'name' => 'image',
                    'contents' => base64_encode(file_get_contents(
                        $file
                    )),
                ],
            ],
        ]);

        $data = json_decode($res->getBody())->data;
        $full = $data->image->url;

        return $full;
    }
}
