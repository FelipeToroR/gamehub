<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GameCatalogController extends Controller
{
    
    public function index()
    {
        return view('game_catalogs.index');
    }

    public function details()
    {
        return view('game_catalogs.details');
    }

    public function play()
    {
        return view('game_catalogs.play');
    }

    public function test()
    {
        return view('game_catalogs.play');
    }

    public function url(Request $request)
    {

        return response()->json([
            'u' => [
                'name' => 'Felipe',
                'fullname' => 'Felipe Diaz',
                'username' => 'pepex',
                'max_score' => 4000,
                'time_left' => 600
            ],
            'p' => [
                'param1' => 'asdf',
                'debug' => 2,
                'param3' => '34243',
                'minSUMANDO' => '234'
            ]
        ]);

        /* return response()->json([
            'name' => 'Abigail',
            'path' => $request->path(),
            'url' => $request->url(),
            'fullurl' => $request->fullurl(),
            'juego' => $request->query('gameid'),
            'referrer' =>  url()->previous(),
            'url_composition' => explode('/', $request->path()),
            'url1' => 'test',
            'url2' => 'test2'
        ]); */
    }

}
