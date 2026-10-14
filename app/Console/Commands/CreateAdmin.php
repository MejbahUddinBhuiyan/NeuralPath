<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;

use function Laravel\Prompts\text;
use function Laravel\Prompts\password;

class CreateAdmin extends Command
{
    protected $signature = 'neuralpath:create-admin';

    protected $description = 'Create the initial NeuralPath administrator';

    public function handle(): int
    {
        if (User::where('role', 'admin')->exists()) {
            $this->error(
                'An administrator already exists.'
            );

            return self::FAILURE;
        }

        $name = text(
            label: 'Administrator name',
            required: true
        );

        $email = strtolower(trim(text(
            label: 'Administrator email',
            required: true
        )));

        $password = password(
            label: 'Administrator password',
            required: true
        );

        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ], [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'password' => [
                'required',
                Password::min(12)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ])->forceFill([
            'role' => 'admin',
            'is_active' => true,
            'email_verified_at' => now(),
            'remember_token' => Str::random(60),
        ])->save();

        $this->info(
            'NeuralPath administrator created successfully.'
        );

        return self::SUCCESS;
    }
}
