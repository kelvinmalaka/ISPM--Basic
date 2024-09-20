<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Set email and password.
     * 
     * @param  string   $name
     * @param  string   $email
     * @param  string   $password
     * @return Factory
     */
    public function setCredentials(string $name, string $email, string $password): Factory {
        return $this->state([
            "name" => $name,
            "email" => $email,
            "password" => Hash::make($password)
        ]);
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        $password =  "password";

        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => Hash::make($password),
            'remember_token' => Str::random(10)
        ];
    }
}
