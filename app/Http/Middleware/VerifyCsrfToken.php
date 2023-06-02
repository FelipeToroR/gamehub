<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'http://gamehub.localhost/game-instances/data/load',
        'http://gamehub.localhost/game-instances/data/save',
        'https://testing.gamehub.localhost/game-instances/data/save',
        'http://localhost/game-instances/data/load',
        'http://localhost/game-instances/data/save',
        'https://testing.localhost/game-instances/data/save',
        'http://gamehub.informaticapucv.cl/game-instances/data/load',
        'https://gamehub.informaticapucv.cl/game-instances/data/load',
        'https://testing.gamehub.informaticapucv.cl/game-instances/data/load',
        'http://gamehub.informaticapucv.cl/game-instances/data/save',
        'https://gamehub.informaticapucv.cl/game-instances/data/save',
        'https://testing.gamehub.informaticapucv.cl/game-instances/data/save',
        'http://gamehub.localhost/game-instances/shop/buy',
        'https://gamehub.informaticapucv.cl/game-instances/shop/buy',
        'https://testing.gamehub.informaticapucv.cl/game-instances/shop/buy'
    ];
}
