<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     *
     * @var array<int, string>|string|null
     */
    protected $proxies = '*'; // Mengizinkan semua proxy
    // Anda juga bisa mengganti '*' dengan array IP tertentu jika diperlukan
    // protected $proxies = ['192.168.1.1', '192.168.1.2'];

    /**
     * The headers that should be used to detect proxies.
     *
     * @var int
     */
    protected $headers =
        Request::HEADER_X_FORWARDED_FOR |
        Request::HEADER_X_FORWARDED_HOST |
        Request::HEADER_X_FORWARDED_PORT |
        Request::HEADER_X_FORWARDED_PROTO |
        Request::HEADER_X_FORWARDED_AWS_ELB;

    // Anda juga bisa mengganti ini dengan Request::HEADER_X_FORWARDED_ALL jika ingin menggunakan semua header
    // protected $headers = Request::HEADER_X_FORWARDED_ALL;
}