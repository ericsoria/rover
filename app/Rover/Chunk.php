<?php


namespace App\Rover;


class Chunk
{
    private array $chunk = [];
    private int $size;
    private int $y;
    private int $x;
    private string $direction;

    public function __construct(?int $size, ?int $y, ?int $x, ?string $direction)
    {
        $this->size = is_null($size) ? 25 : $size;
        $this->y = is_null($y) ? 1 : $y;
        $this->x = is_null($x) ? 2 : $x;
        $this->direction = is_null($direction) ? 'n' : $direction;
    }

    public function create() : void
    {
        for ($y = 1; $this->size >= $y; $y++) {
            for ($x = 1; $this->size >= $x; $x++) {
                $this->chunk[$y][$x] = !random_int(0, 10) < 8 ? '1' : '0';
                //$this->chunk[$y][$x] = 1;
            }
        }

        if (isset($this->chunk[$this->y][$this->x])) {
            $this->chunk[$this->y][$this->x] = 'X';
        }
    }

    public function html() : string
    {
        $html = '<table><tbody>';
        foreach ($this->chunk as $col => $rows) {
            $html .= '<tr>';
            foreach ($rows as $row) {
                $class = 'green';
                if ($row === '0') $class = 'black';
                if ($row === 'X') {
                    $class = 'red';
                    $class .= match (strtolower($this->direction)) {
                        'n' => ' up',
                        's' => ' down',
                        'e' => ' right',
                        'w' => ' left',
                        default => ' up'
                    };

                }

                $html .= '<td class="'.$class.'">';
                $html .= '</td>';
            }
            $html .= '</tr>';
        }
        $html .= '</tbody></table>';


        return $html;
    }

    public function chunk(): array
    {
        return $this->chunk;
    }

    public function size(): int
    {
        return $this->size;
    }

    public function y(): int
    {
        return $this->y;
    }

    public function x(): int
    {
        return $this->x;
    }

    public function incrementY() : bool
    {
        if (! isset($this->chunk[$this->y+1][$this->x])) return false;
        if (! $this->chunk[$this->y+1][$this->x]) return false;

        $this->y = $this->y+1;
        $this->chunk[$this->y][$this->x] = 'X';

        return true;
    }

    public function incrementX()
    {
        if (! isset($this->chunk[$this->y][$this->x+1])) return false;
        if (! $this->chunk[$this->y][$this->x+1]) return false;

        $this->x = $this->x+1;
        $this->chunk[$this->y][$this->x] = 'X';

        return true;
    }

    public function decrementY()
    {
        if (! isset($this->chunk[$this->y-1][$this->x])) return false;
        if (! $this->chunk[$this->y-1][$this->x]) return false;

        $this->y = $this->y-1;
        $this->chunk[$this->y][$this->x] = 'X';

        return true;
    }

    public function decrementX()
    {
        if (! isset($this->chunk[$this->y][$this->x-1])) return false;
        if (! $this->chunk[$this->y][$this->x-1]) return false;

        $this->x = $this->x-1;
        $this->chunk[$this->y][$this->x] = 'X';
        return true;
    }

    public function d(): string
    {
        return $this->direction;
    }
}
