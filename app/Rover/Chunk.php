<?php


namespace App\Rover;

use Illuminate\Database\Eloquent\Model;

class Chunk extends Model
{
    protected $casts = [
        'chunk' => 'array',
    ];

    public static function create(?int $size, ?int $y, ?int $x, ?string $direction) : self
    {
        $chunk = new Chunk();

        $chunk->size = is_null($size) ? 25 : $size;
        $chunk->y = is_null($y) ? 1 : $y;
        $chunk->x = is_null($x) ? 2 : $x;
        $chunk->direction = is_null($direction) ? 'n' : $direction;

        $json = [];

        for ($y = 1; $chunk->size >= $y; $y++) {
            for ($x = 1; $chunk->size >= $x; $x++) {
                $json[$y][$x] = !random_int(0, 10) < 8 ? '1' : '0';
            }
        }

        if (isset($json[$chunk->y][$chunk->x])) {
            $json[$chunk->y][$chunk->x] = 'X';
        }

        $chunk->chunk = $json;

        return $chunk;
    }

    public function setChunkAttribute(array $chunk)
    {
        $this->attributes['chunk'] = json_encode($chunk);
    }

    public function getChunkAttribute()
    {
        return json_decode($this->attributes['chunk'], true);
    }

    public function html() : string
    {
        $chunk = $this->getAttribute('chunk');
        $html = '<table><tbody>';
        foreach ($chunk as $col => $rows) {
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
        return $this->getAttribute('chunk');
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
        $chunk = $this->getAttribute('chunk');

        if (! isset($chunk[$this->y+1][$this->x])) return false;

        if (! $chunk[$this->y+1][$this->x]) return false;

        $chunk[$this->y][$this->x] = '1';
        $this->y = $this->y+1;
        $chunk[$this->y][$this->x] = 'X';

        $this->chunk = $chunk;

        return true;
    }

    public function incrementX()
    {
        $chunk = $this->getAttribute('chunk');

        if (! isset($chunk[$this->y][$this->x+1])) return false;

        if (! $chunk[$this->y][$this->x+1]) return false;

        $chunk[$this->y][$this->x] = '1';
        $this->x = $this->x+1;
        $chunk[$this->y][$this->x] = 'X';

        $this->chunk = $chunk;

        return true;
    }

    public function decrementY()
    {
        $chunk = $this->getAttribute('chunk');

        if (! isset($chunk[$this->y-1][$this->x])) return false;

        if (! $chunk[$this->y-1][$this->x]) return false;

        $chunk[$this->y][$this->x] = '1';
        $this->y = $this->y-1;
        $chunk[$this->y][$this->x] = 'X';

        $this->chunk = $chunk;

        return true;
    }

    public function decrementX()
    {
        $chunk = $this->getAttribute('chunk');

        if (! isset($chunk[$this->y][$this->x-1])) return false;

        if (! $chunk[$this->y][$this->x-1]) return false;

        $chunk[$this->y][$this->x] = '1';
        $this->x = $this->x-1;
        $chunk[$this->y][$this->x] = 'X';

        $this->chunk = $chunk;

        return true;
    }

    public function d(): string
    {
        return $this->direction;
    }
}
