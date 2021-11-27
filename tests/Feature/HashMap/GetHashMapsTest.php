<?php

namespace Feature\HashMap;

use Carbon\Carbon;
use Str;
use Tests\TestCase;
use App\Models\HashMap;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetHashMapsTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_hash_map_by_key()
    {
        $hashFactoryData = HashMap::factory()->create();
        $key = $hashFactoryData->key;
        $response = $this->get("/api/hash/$key");

        $response->assertStatus(200)
            ->assertJson([
                'data' => $hashFactoryData->only('key', 'value'),
            ]);
    }


    public function test_get_hash_map_by_key_and_timestamp()
    {
        $hashFactoryData = HashMap::factory()->create();
        $key = $hashFactoryData->key;
        $timestamp = (new Carbon($hashFactoryData->created_at))->timestamp;

        $response = $this->get("/api/hash/$key?timestamp=$timestamp");

        $response->assertStatus(200)
            ->assertJson([
                'data' => $hashFactoryData->only('key', 'value'),
            ]);
    }


    public function test_unable_to_get_hash_map_by_key_when_timestamp_is_incorrect()
    {
        $hashFactoryData = HashMap::factory()->create();
        $key = $hashFactoryData->key;
        $timestamp = (new Carbon($hashFactoryData->created_at))->addHour()->timestamp;

        $response = $this->get("/api/hash/$key?timestamp=$timestamp");

        $response->assertStatus(200)
            ->assertJson([
                'data' => []
            ]);
    }

    public function test_unable_to_get_hash_map_by_timestamp_when_key_is_incorrect()
    {
        $hashFactoryData = HashMap::factory()->create();
        $key = Str::Random(10);
        $timestamp = (new Carbon($hashFactoryData->created_at))->addHour()->timestamp;

        $response = $this->get("/api/hash/$key?timestamp=$timestamp");

        $response->assertStatus(200)
            ->assertJson([
                'data' => []
            ]);
    }

}
