<?php


namespace App\Rover;


class Rover
{
    private Chunk $chunk;
    private Sequence $sequence;

    public function __construct(Chunk $chunk, Sequence $sequence)
    {
        $this->chunk = $chunk;
        $this->sequence = $sequence;
    }

    public function run()
    {
        if ($this->chunk->d() == 'n') $this->runToNorth();
    }

    private function runToNorth() : void
    {
        foreach ($this->sequence->commands() as $command) {
            if (strtolower($command) == 'f') $this->chunk->decrementY();
            if (strtolower($command) == 'r') $this->chunk->incrementX();
            if (strtolower($command) == 'l') $this->chunk->decrementX();
        }
    }
}
