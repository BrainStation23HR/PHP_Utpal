<?php

namespace Database\Seeders;

use App\Models\Device;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the number of devices you want to create
        $numberOfDevices = 10;

        for ($i = 0; $i < $numberOfDevices; $i++) {
            Device::create([
                'name' => 'Device ' . Str::random(5), // Generates a unique name like 'Device aBcDe'
                'location' => fake()->city(), // Uses Faker to generate a fake city name
                'api_key' => Str::random(60), // Generates a random string for the API key
            ]);
        }
    }
}
