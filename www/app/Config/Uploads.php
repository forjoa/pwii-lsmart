<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Uploads extends BaseConfig
{
    public $profileUploadPath = WRITEPATH . 'uploads/profiles';
    public $profileAllowedTypes = 'jpg,jpeg,png';
    public $profileMaxSize = 2048; 
}