<?php

namespace Database\Factories;

use App\Models\RawClient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RawClient>
 */
class RawClientFactory extends Factory
{
    protected $model = RawClient::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'uuid' => $this->faker->uuid(),
            'fullname' => $this->faker->name(),
            'mail' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
            'register_as' => $this->faker->randomElement(['student', 'parent', 'teacher_counsellor']),
            'role' => $this->faker->randomElement(['student', 'parent', 'teacher_counselor']),
            'relation_key' => null,
            'school_uuid' => $this->faker->randomElement(['rs', 'vs']) . '-' . $this->faker->uuid(),
            'interest_countries' => $this->faker->randomElement(['US', 'UK', 'Canada', 'Asia']),
            'lead_id' => $this->faker->randomElement(['LS001', 'LS004', 'LS005', 'LS008']),
            'graduation_year' => null,
        ];
    }
}