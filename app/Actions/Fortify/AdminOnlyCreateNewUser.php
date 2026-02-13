<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Illuminate\Auth\Access\AuthorizationException;

class AdminOnlyCreateNewUser implements CreatesNewUsers
{
    /**

     * Crea un nuevo usuario solo si el actual tiene rol admin.
     */
    public function create(array $input): User
    {
        $user = Auth::guard('web')->user();

        // Verifica autenticación y rol admin (Spatie)
        if (!$user || !$user->hasRole('admin')) {
            throw new AuthorizationException('Solo los administradores pueden registrar nuevos usuarios.');
        }

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ])->validate();

        // Crea el usuario
        $newUser = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        // Asigna rol por defecto
        $newUser->assignRole('user');

        return $newUser;
    }
}
