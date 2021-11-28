<?php

namespace Feature\HashMap;

use StdClass;
use Str;
use Tests\TestCase;
use App\Models\HashMap;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateAndUpdateHashMapsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @param null $prefixKey
     * @return StdClass
     */
    public function makeMockInput($prefixKey = null): StdClass
    {
        $mockHashMap = HashMap::factory()->make();

        $key = $mockHashMap->key;
        if ($prefixKey) {
            $key = $prefixKey;
        }

        $mockData = new StdClass();
        $mockData->{$key} = $mockHashMap->value;

        return $mockData;
    }

    public function test_create_hash_map()
    {
        $mockInput = $this->makeMockInput();

        $response = $this->post('/api/hash', [
            "data" => json_encode($mockInput)
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('hash_map', [
            'key'   => key($mockInput),
            'value' => $mockInput->{key($mockInput)},
        ]);
    }

    public function test_update_hash_map()
    {
        $existingHashMap = HashMap::factory()->create();
        $mockInput = $this->makeMockInput($existingHashMap->key);

        $response = $this->post('/api/hash', [
            "data" => json_encode($mockInput)
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('hash_map', [
            'key'   => $existingHashMap->key,
            'value' => $mockInput->{$existingHashMap->key},
        ]);
    }


    public function test_create_hash_map_with_an_object_value()
    {
        $existingHashMap = HashMap::factory()->create();
        $mockInput = $this->makeMockInput($existingHashMap->key);

        $valueObject = new StdClass();
        $valueObject->{'123'} = Str::random(20);
        $mockInput->{$existingHashMap->key} = json_encode($valueObject);

        $response = $this->post('/api/hash', [
            "data" => json_encode($mockInput)
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('hash_map', [
            'key'   => $existingHashMap->key,
            'value' => $mockInput->{$existingHashMap->key},
        ]);
    }

    public function test_create_fail_if_there_is_no_data()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('/api/hash', [
            "data" => null
        ]);

        $response->assertStatus(422);
        $this->assertDatabaseCount('hash_map', 0);
    }

    public function test_create_fail_if_the_data_is_not_a_hash_map()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('/api/hash', [
            "data" => Str::random(10)
        ]);

        $response->assertStatus(422);
        $this->assertDatabaseCount('hash_map', 0);
    }

}
