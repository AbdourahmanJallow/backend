<?php

namespace App\Filament\Resources\PatientResource\Pages;

use App\Filament\Resources\PatientResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreatePatient extends CreateRecord
{
    protected static string $resource = PatientResource::class;

    public function mutateFormDataBeforeCreate(array $data): array
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'email_verified_at' => now(),
            'password' => Hash::make($data['password']),
            'userType' => 'patient',
            'dateOfBirth' => $data['dateOfBirth'] ?? null,
        ]);

        $data['user_id'] = $user->id;

        // unset($data['name'], $data['email'], $data['password'], $data['dateOfBirth']);

        return $data;
    }
}
