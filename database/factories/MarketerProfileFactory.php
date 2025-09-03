<?php

namespace Database\Factories;

use App\Models\MarketerProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

class MarketerProfileFactory extends Factory
{
    protected $model = MarketerProfile::class;

    public function definition(): array
    {
        return [
            'user_id'       => null, // will be filled automatically via `hasMarketerProfile()`
            'business_name' => $this->faker->company(),
            'whatsapp'      => $this->faker->numerify('080########'),
            'instagram'     => $this->faker->userName(),
        ];
    }
}
