<?php

namespace Tests\Feature;

use App\Models\Floor;
use App\Models\Property;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FloorManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_property_can_have_floors(): void
    {
        $user = User::factory()->create();
        $property = Property::create([
            'user_id' => $user->id,
            'name' => 'Grand Hotel',
        ]);

        $floor = $property->floors()->create([
            'name' => 'First Floor',
            'level' => 1,
        ]);

        $this->assertDatabaseHas('floors', [
            'property_id' => $property->id,
            'name' => 'First Floor',
        ]);

        $this->assertEquals(1, $property->floors()->count());
    }

    public function test_floor_can_have_rooms(): void
    {
        $user = User::factory()->create();
        $property = Property::create([
            'user_id' => $user->id,
            'name' => 'Grand Hotel',
        ]);

        $floor = $property->floors()->create([
            'name' => 'First Floor',
            'level' => 1,
        ]);

        $room = $floor->rooms()->create([
            'property_id' => $property->id,
            'room_name' => '101',
        ]);

        $this->assertDatabaseHas('rooms', [
            'floor_id' => $floor->id,
            'room_name' => '101',
        ]);

        $this->assertEquals(1, $floor->rooms()->count());
        $this->assertEquals($floor->id, $room->floor->id);
    }
}
