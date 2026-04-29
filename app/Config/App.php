<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class App extends BaseConfig
{
    public string $baseURL = 'http://192.168.3.198/';
    
    public $defaultLocale = 'en';  
    public $supportedLocales = [ 'en','vi', 'ko'];
    public $negotiateLocale = false;

    public array $allowedHostnames = [];

    public string $indexPage = '';

    public string $uriProtocol = 'REQUEST_URI';

    public string $permittedURIChars = 'a-z 0-9~%.:_\-';

    public string $appTimezone = 'UTC';
    
    public string $timezone = 'Asia/Ho_Chi_Minh';

    public string $charset = 'UTF-8';

    public bool $forceGlobalSecureRequests = false;

    public array $proxyIPs = [];

    public bool $CSPEnabled = false;
}
