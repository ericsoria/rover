<?php

namespace App\Rover;

use DateTime;

class RoverLog
{
    public array $log;

    public function __construct()
    {
        $this->log = [];
    }

    public function addLine($line) : void
    {
        $dateTime = new DateTime();
        $this->log[] = "{$dateTime->format('Ymd h:n:s')} - {$line}";
    }

    public function log(): array
    {
        return $this->log;
    }

}
