<?php

namespace Database\Factories;

use App\Models\HashMap;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

class HashMapFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = HashMap::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'key'   => Str::random(10),
            'value' => Str::random(10),
        ];
    }
}
