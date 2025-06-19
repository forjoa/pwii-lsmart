<?php

namespace App\Libraries;

class RecaptchaService
{
    protected $secret;
    protected $siteVerifyUrl = 'https://www.google.com/recaptcha/api/siteverify';

    public function __construct()
    {
        $this->secret = config('Recaptcha')->secret;
    }

    public function verify($response, $remoteIp = null)
    {
        $data = [
            'secret' => $this->secret,
            'response' => $response
        ];

        if ($remoteIp) {
            $data['remoteip'] = $remoteIp;
        }

        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            ]
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($this->siteVerifyUrl, false, $context);

        return json_decode($result);
    }
}