<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\PetStateHistory;
use App\Observers\PetStateHistoryObserver;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        PetStateHistory::observe(PetStateHistoryObserver::class);
    }
}