<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <title>Rover</title>
</head>
<body>

<div class="container">
    <form action="/" method="get">
        <div class="row">
            <div class="col-6">
                {!! $chunk->html() !!}
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="size">Size</label>
                    <input type="number" class="form-control" id="size" name="size" value="{{ $chunk->size() }}">
                    <small class="form-text text-muted"></small>
                </div>
                <div class="form-group">
                    <label for="y">Y</label>
                    <input type="number" class="form-control" id="y" name="y" value="{{ $chunk->y() }}">
                    <small class="form-text text-muted">Vertical axis, starts on 1</small>
                </div>
                <div class="form-group">
                    <label for="x">X</label>
                    <input type="number" class="form-control" id="x" name="x" value="{{ $chunk->x() }}">
                    <small class="form-text text-muted">Horizontal axis, start on 1</small>
                </div>
                <div class="form-group">
                    <label for="direction">Direction</label>
                    <select class="form-control" id="direction" name="d">
                        <option value="n" <?php echo strtolower($chunk->d()) == 'n' ? 'selected' : ''?>> N (UP)</option>
                        <option value="s" <?php echo strtolower($chunk->d()) == 's' ? 'selected' : ''?>> S (DOWN)
                        </option>
                        <option value="e" <?php echo strtolower($chunk->d()) == 'e' ? 'selected' : ''?>> E (RIGHT)
                        </option>
                        <option value="w" <?php echo strtolower($chunk->d()) == 'w' ? 'selected' : ''?>> W (LEFT)
                        </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 10px">
            <div class="col-12">
                <div class="form-group">
                    <label for="direction">Sequence</label>
                    <textarea class="form-control" id="sequence" name="sequence"></textarea>
                    <small class="form-text text-muted">Only is valid 'F', forward; 'L', left and 'R', right</small>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <button type="submit" class="btn btn-primary" style="width: 100%">
                    <i class="fas fa-rocket"></i>
                    Launch!
                </button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-12">
            @empty(!$log)
            <div class="log">
                @foreach($log as $l)
                    <p>{{ $l }}</p>
                @endforeach
            </div>
            @endempty
        </div>
    </div>
</div>

</body>
<style>
    table, td {
        border: 1px solid #dedede;
    }

    .log {
        margin-top: 10px;
        background-color: #1a202c;
        color: #f7fafc;
        width: 100%;
        padding: 10px;
    }

    td {
        width: 20px;
        height: 20px;
    }

    td.green {
        background-color: greenyellow;
    }

    td.black {
        background-color: black;
    }

    td.red {
        background-color: red;
    }

    .container {
        margin-top: 5rem;
    }
</style>
</html>
