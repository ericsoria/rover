<?php

namespace App\Http\Controllers;

use App\Rover\Chunk;
use App\Rover\Rover;
use App\Rover\RoverLog;
use App\Rover\Sequence;
use Illuminate\Http\Request;

class RoverController extends Controller
{
    public function __invoke(Request $request)
    {
        $chunk = $this->getChunk($request);
        $commands = $request->sequence;
        $log = new RoverLog();

        if (! is_null($commands)) {
            (new Rover(
                $chunk,
                new Sequence($commands),
                $log
            ))->run();
        }

        $chunk->save();

        return view('rover', [
            'chunk' => $chunk,
            'log' => $log->log()
        ]);
    }

    private function getChunk($request) : Chunk
    {
        $chunk = is_null(Chunk::first())
            ? Chunk::create($request->size, $request->y, $request->x, $request->d)
            : Chunk::first();

        if ($chunk->size() != $request->size
            || $chunk->y() != $request->y
            || $chunk->x() != $request->x
            || $chunk->d() != $request->d
        )
        {
            $chunk->delete();
            $chunk = Chunk::create($request->size, $request->y, $request->x, $request->d);
        }

        return $chunk;
    }
}
