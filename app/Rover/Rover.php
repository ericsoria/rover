<?php

namespace App\Rover;

class Rover
{
    private Chunk $chunk;
    private Sequence $sequence;
    private RoverLog $log;

    public function __construct(Chunk $chunk, Sequence $sequence, RoverLog $log)
    {
        $this->chunk = $chunk;
        $this->sequence = $sequence;
        $this->log = $log;
    }

    public function run()
    {
        if ($this->chunk->d() == 'n') $this->runToNorth();
        if ($this->chunk->d() == 's') $this->runToSouth();
        if ($this->chunk->d() == 'e') $this->runToEast();
        if ($this->chunk->d() == 'w') $this->runToWest();
    }

    private function runToNorth() : void
    {
        $control = true;
        foreach ($this->sequence->commands() as $command) {
            if (strtolower($command) == 'f') $control = $this->chunk->decrementY();
            if (strtolower($command) == 'r') $control = $this->chunk->incrementX();
            if (strtolower($command) == 'l') $control = $this->chunk->decrementX();

            $this->writeLog($control, $command);
            if (!$control) break;
        }
    }
    private function runToSouth() : void
    {
        $control = true;
        foreach ($this->sequence->commands() as $command) {
            if (strtolower($command) == 'f') $control = $this->chunk->incrementY();
            if (strtolower($command) == 'l') $control = $this->chunk->incrementX();
            if (strtolower($command) == 'r') $control = $this->chunk->decrementX();

            $this->writeLog($control, $command);
            if (!$control) break;
        }
    }
    private function runToEast() : void
    {
        $control = true;
        foreach ($this->sequence->commands() as $command) {
            if (strtolower($command) == 'f') $control = $this->chunk->incrementX();
            if (strtolower($command) == 'l') $control = $this->chunk->decrementY();
            if (strtolower($command) == 'r') $control = $this->chunk->incrementY();

            $this->writeLog($control, $command);
            if (!$control) break;
        }
    }

    private function runToWest() : void
    {
        $control = true;
        foreach ($this->sequence->commands() as $command) {
            if (strtolower($command) == 'f') $control = $this->chunk->decrementX();
            if (strtolower($command) == 'l') $control = $this->chunk->incrementY();
            if (strtolower($command) == 'r') $control = $this->chunk->decrementY();

            $this->writeLog($control, $command);
            if (!$control) break;
        }
    }

    private function writeLog(bool $control, string $command)
    {
        $this->log->addLine('[Running] ['.$this->chunk->d().'] - Rover trying to move '.strtoupper($command));
        if ($control) {
            $this->log->addLine('[Success] ['.$this->chunk->d().'] - Rover moved to '.strtoupper($command));
        }else {
            $this->log->addLine('[FAIL] ['.$this->chunk->d().']    - Rover cannot advance, there is an obstacle');
            $this->log->addLine('[Success] ['.$this->chunk->d().'] - The rover returns to the last coordinate ');
        }
    }
}
