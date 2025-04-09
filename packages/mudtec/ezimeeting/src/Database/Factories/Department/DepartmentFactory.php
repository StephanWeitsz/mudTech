<?php

namespace Mudtec\Ezimeeting\Database\Factories\Department;


use Illuminate\Database\Eloquent\Factories\Factory;
use Mudtec\Ezimeeting\Models\Department;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Universal\BioPortal\Models\User>
 */
class DepartmentFactory extends Factory
{
    protected $model = Department::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition()
    {
        $corporations = DB::table('corporations')->select('id')->get();
        $randomCorporationId = $corporations->isNotEmpty() ? $corporations->random()->id : null;

        return [
            'name' => fake()->word,
            'description' => fake()->text(100),
            'text' => fake()->paragraph,
            'corporation_id' => $randomCorporationId,
        ];
    }

    public function withNoCorporation(array $inputData)
    {
        return $this->state(function (array $attributes) use ($inputData)  {
            if (empty($inputData['corporation_id'])) {
                return [
                    'corporation_id' => Null,
                ];
            }
            return [];
        });
    }

    public function withNoName(array $inputData)
    {
        return $this->state(function (array $attributes) use ($inputData) {
            if (empty($inputData['name'])) {
                //throw new \InvalidArgumentException('The name field is required.');
                return [
                    'name' => '',
                ];
            }
    
            return [];
        });
    }
}
