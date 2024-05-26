<?php

namespace Database\Factories;

use App\Models\Credit;
use Illuminate\Database\Eloquent\Factories\Factory;

class CreditFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Credit::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'client_id' => 1,
            'user_id' => 1,
            'debtor_id' => 1,
            'headquarter_id' => 1,
            'provider_id' => 1,
            'number_installments' => $this->faker->randomNumber(1, 36),
            'number_paid_installments' => $this->faker->randomNumber(1, 36),
            'day_limit' => $this->faker->randomNumber(),
            'debtor' => $this->faker->boolean(),
            'provider' => $this->faker->boolean(),
            'status' => $this->faker->boolean(),
            'start_date' => $this->faker->date('Y-m-d'),
            'interest' => $this->faker->randomNumber(),
            'annual_interest_percentage' => $this->faker->randomNumber(),
            'interest' => $this->faker->randomNumber(1, 100),
            'installment_value' => $this->faker->randomNumber(),
            'credit_value' => $this->faker->randomNumber(),
            'paid_value' => 0,
            'capital_value' => 0,
            'interest_value' => 0,
            'description' => $this->faker->text(100),
            'disbursement_date' => $this->faker->date('Y-m-d')
        ];
    }
}
