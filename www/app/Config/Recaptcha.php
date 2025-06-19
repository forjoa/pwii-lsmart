<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Recaptcha extends BaseConfig
{
    public $key = '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI';
    public $secret = '6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe';
    public $expectedHostname = 'localhost';
    public $scoreThreshold = 0.5;
    public $version = 'v2';
}