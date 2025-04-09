<?php

namespace Mudtec\Ezimeeting\Database\Factories\Corporation;


use Illuminate\Database\Eloquent\Factories\Factory;
use Mudtec\Ezimeeting\Models\Corporation;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Universal\BioPortal\Models\User>
 */
class CorporationFailFactory extends Factory
{
    protected $model = Corporation::class;
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'description' => fake()->text(200),
            'text' => fake()->paragraph,
            'website' => fake()->url,
            'logo' => fake()->randomElement(['logo1.png', 'logo2.png', 'logo3.png']),
        ];
    }
}
