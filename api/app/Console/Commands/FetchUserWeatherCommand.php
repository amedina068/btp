<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use App\Jobs\FetchUserWeatherJob;

class FetchUserWeatherCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather-app:fetch-user-weather';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch the weather data for all users.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        User::cursor()
            ->each(fn (User $user) => FetchUserWeatherJob::dispatch($user));
    }
}
