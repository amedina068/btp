<?php

namespace App\Models;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getCurrentWeatherAttribute()
    {
        return Cache::remember(
            "weather_user_{$this->id}",
            3600,
            fn () => $this->retrieveWeather()
        );
    }

    public function retrieveWeather()
    {
        $response = Http::get(config('services.weather.api_url'), [
            'lat' => $this->latitude,
            'lon' => $this->longitude,
            'appid' => config('services.weather.key'),
            'units' => 'imperial',
        ]);

        return [
            'last_time_fetched' => now()->format('Y-m-d H:i:s T'),
            'data' => $response->json()
        ];
    }
}
