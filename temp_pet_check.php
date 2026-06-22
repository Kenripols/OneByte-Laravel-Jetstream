<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$pet = App\Models\Pet::where('name','Jamaica')->first();
if (!$pet) {
    echo "no pet\n";
    exit(0);
}
echo "id={$pet->id}\n";
echo "photo={$pet->photo}\n";
echo "url={$pet->photo_url}\n";
