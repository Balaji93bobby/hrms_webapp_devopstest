<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VmtEmployeeOfficeDetails>
 */
class VmtEmployeeOfficeDetailsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {


        return [
            'id' =>$this->faker->randomNumber(3, false),
            'user_id' => 0 ,
            'department_id' => 0,
            'process'=> '' ,
            'designation' => '' ,
            'cost_center' => '' ,
            'confirmation_period' => '' ,
            'holiday_location' => '' ,
            'l1_manager_code' => '' ,
            'l1_manager_designation' => '' ,
            'l1_manager_name' => '' ,
            'work_location'  => '' ,
            'officical_mail'  => '' ,
            'official_mobile'  => '' ,
            'emp_notice'  => '' ,
            'created_at'  => '' ,
            'updated_at'  => '' ,
            'probation_period' => ''

        ];

    }
}
