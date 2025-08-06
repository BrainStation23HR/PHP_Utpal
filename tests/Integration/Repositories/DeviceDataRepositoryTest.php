<?php
namespace Tests\Integration\Repositories;


use App\Http\Repositories\DeviceDataRepository;
use App\Models\Device;
use App\Models\DeviceData;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

class DeviceDataRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private DeviceDataRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        // Instantiate the repository with a real model, as this is an integration test.
        $this->repository = new DeviceDataRepository(new DeviceData());
    }

    public function test_can_create_a_device_data_record()
    {
        // Arrange
        $device = Device::factory()->create();
        $data = DeviceData::factory()->make([
            'device_id' => $device->id,
            'temperature' => 25.5,
            'status' => 'normal',
        ])->toArray();

        // Act
        $createdRecord = $this->repository->create($data);

        // Assert
        $this->assertNotNull($createdRecord->id);
        $this->assertEquals($data['temperature'], $createdRecord->temperature);
        $this->assertEquals($data['status'], $createdRecord->status);
        $this->assertDatabaseHas('device_data', ['id' => $createdRecord->id]);
    }

    public function test_can_retrieve_the_latest_status_for_a_device()
    {
        // Arrange
        $device = Device::factory()->create();
        
        // Create an older record
        DeviceData::factory()->create([
            'device_id' => $device->id,
            'event_timestamp' => Carbon::now()->subDay(),
            'status' => 'normal',
        ]);
        
        // Create the latest record
        $latestRecord = DeviceData::factory()->create([
            'device_id' => $device->id,
            'event_timestamp' => Carbon::now(),
            'status' => 'critical',
        ]);

        // Act
        $fetchedRecord = $this->repository->latestStatus($device->id);

        // Assert
        $this->assertNotNull($fetchedRecord);
        $this->assertEquals($latestRecord->id, $fetchedRecord->id);
        $this->assertEquals($latestRecord->status, $fetchedRecord->status);
    }
    
    public function test_returns_null_when_no_latest_status_exists()
    {
        // Arrange
        $device = Device::factory()->create();
        
        // No records are created for this device

        // Act
        $fetchedRecord = $this->repository->latestStatus($device->id);

        // Assert
        $this->assertNull($fetchedRecord);
    }

    public function test_can_retrieve_historical_data_within_a_date_range()
    {
        // Arrange
        $device = Device::factory()->create();
        
        $startDate = Carbon::now()->subWeek();
        $endDate = Carbon::now();
        
        // Create 3 records within the date range
        DeviceData::factory()->count(3)->create([
            'device_id' => $device->id,
            'event_timestamp' => fake()->dateTimeBetween($startDate, $endDate),
        ]);
        
        // Create a record outside the date range (should be ignored)
        DeviceData::factory()->create([
            'device_id' => $device->id,
            'event_timestamp' => Carbon::now()->subMonth(),
        ]);

        // Act
        $history = $this->repository->getHistory($device->id, $startDate->toDateTimeString(), $endDate->toDateTimeString());

        // Assert
        $this->assertCount(3, $history);
        $this->assertTrue($history->every(fn($item) => $item->event_timestamp >= $startDate && $item->event_timestamp <= $endDate));
    }
}