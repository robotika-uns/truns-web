<?php

namespace App\Helpers;

class KirimEmail
{

    public static function kirim($data)
    {
        $mj = new \Mailjet\Client(
            env("MAILJET_APIKEY_PUBLIC"),
            env("MAILJET_APIKEY_PRIVATE"),
            true,
            ['version' => 'v3.1']
        );

        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "robotika@mail.uns.ac.id",
                        'Name' => "UKM Robotika UNS",
                    ],
                    'To' => [
                        $data['penerima'],
                    ],
                    'TemplateID' => $data['template'],
                    'TemplateLanguage' => true,
                    'Subject' => $data['judul'],
                    'Variables' => $data['variables'],
                ],
            ],
        ];
        $response = $mj->post(\Mailjet\Resources::$Email, ['body' => $body]);
    }
}
