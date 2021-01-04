<?php


namespace App\Rover;


class Sequence
{
    private const ALLOWED_COMMANDS = ['F', 'L', 'R'] ;
    private array $sequence = [];

    public function __construct(string $sequence)
    {
        $this->check($sequence);
    }

    private function check($sequence)
    {

        if (empty($sequence)) {
            throw new \Exception('Sequence can not be empty');
        }
        $length = strlen($sequence);

        for ($i = 0; $length > $i; $i++) {
            if (! in_array($sequence[$i], self::ALLOWED_COMMANDS)) {
                throw new \Exception('Commands sequence is not valid; must be "F", "L", "R"');
            }

            $this->sequence[] = $sequence[$i];
        }
    }

    public function commands(): array
    {
        return $this->sequence;
    }
}
