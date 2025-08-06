<?php

namespace Database\Factories;

use App\Models\DeviceData;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Device;

class DeviceDataFactory extends Factory
{
    protected $model = DeviceData::class;

    public function definition(): array
    {
        return [
            'device_id' => Device::factory(),
            'temperature' => fake()->randomFloat(2, -20, 50),
            'humidity' => fake()->randomFloat(2, 0, 100),
            'status' => fake()->randomElement(['normal', 'warning', 'critical']),
            'event_timestamp' => fake()->dateTimeBetween('-1 month', 'now'),
        ];
    }
}