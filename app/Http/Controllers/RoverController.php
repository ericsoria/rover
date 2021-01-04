<?php

namespace App\Http\Controllers;

use App\Rover\Chunk;
use App\Rover\Rover;
use App\Rover\Sequence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RoverController extends Controller
{
    public function index(Request $request)
    {
        $request->session()->start();

        $chunk = $request->session()->get('chunk');

        if (is_null($chunk)) {
            $chunk = new Chunk($request->size, $request->y, $request->x, $request->d);
            $chunk->create();
        }

        $sequence = null;
        if (! is_null($request->sequence)) {
            $sequence = new Sequence($request->sequence);

            $rover = new Rover($chunk, $sequence);
            $rover->run();
        }


        $request->session()->put('chunk', $chunk);
        $request->session()->save();
        $request->session();

        return view('rover', [
            'chunk' => $chunk,
            'sequence' => ! is_null($sequence) ? implode('', $sequence->commands()) : '',
        ]);
    }
}
