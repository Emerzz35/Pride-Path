<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Validation\ValidationException;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function validatePassword($password)
    {
        $lowerCase = preg_match('/[a-z]/', $password);
        $upperCase = preg_match('/[A-Z]/', $password);
        $number = preg_match('/[1-9]/', $password);
        $specialChar = preg_match('/[^\w]/', $password);

        if (!$lowerCase){
            throw ValidationException::withMessages(['password' => 'A senha deve conter pelo menos umas letra minúscula.']);
        } else if (!$upperCase){
            throw ValidationException::withMessages(['password' => 'A senha deve conter pelo menos umas letra maiuscula.']);
        } else if (!$number){
            throw ValidationException::withMessages(['password' => 'A senha deve conter pelo menos um numero.']);
        } else if (!$specialChar){
            throw ValidationException::withMessages(['password' => 'A senha deve conter pelo menos um caractere especial.']);
        }

        return $password;
    }
}

