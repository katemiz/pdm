<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\CRequest;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CRequestFactory extends Factory
{

    protected $model = CRequest::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' =>1,
            'topic' => $this->faker->sentence(2),
            'is_for_ecn' => $this->faker->boolean(10),
            'description' => $this->faker->sentence(50)
        ];
    }
}


