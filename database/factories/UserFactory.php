<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => 'TCU',
            'middle_name' => 'EVENTUAL',
            'last_name' => 'CERT',
            'id_number' => '1',
            'section' => '1',
            'year' => '1',
            'student_id_image' => '',
            'email' => 'tcueventualcert@admin.com',
            'department_id' => null,
            'is_admin' => true,
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('tcueventualcert01!'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
