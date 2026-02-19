<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo 'PHP default timezone: ' . date_default_timezone_get() . PHP_EOL;
echo 'config app.timezone: ' . config('app.timezone') . PHP_EOL;
$now = now();
echo 'Now (server): ' . $now->toDateTimeString() . ' ' . $now->getTimezone()->getName() . PHP_EOL;

$g = \App\Models\Game::orderBy('id')->first();
if ($g) {
    echo 'id:' . $g->id . '|game_time:' . $g->game_time->toDateTimeString() . '|tz:' . $g->game_time->getTimezone()->getName() . PHP_EOL;
} else {
    echo "no game found" . PHP_EOL;
}
