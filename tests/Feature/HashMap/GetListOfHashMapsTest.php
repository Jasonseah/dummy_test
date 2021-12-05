<?php

namespace Feature\HashMap;

use Tests\TestCase;
use App\Models\HashMap;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetListOfHashMapsTest extends TestCase
{
    use RefreshDatabase;

    public function test_getting_a_list_of_empty_hash_map()
    {
        $response = $this->get('/api/object/get_all_records');

        $response->assertStatus(200)
            ->assertJson([
                'data' => [],
            ]);
    }


    public function test_getting_a_list_of_hash_map_if_there_is_data()
    {
        $hashFactoryData = HashMap::factory(10)->create();

        $response = $this->get('/api/object/get_all_records');

        $response->assertStatus(200)
            ->assertJson([
                'data' => $hashFactoryData->map(function ($data) {
                    return [
                        'key'   => $data->key,
                        'value' => json_decode($data->value)
                    ];
                })->toArray()
            ]);
    }

}
