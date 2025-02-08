<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DoctorResource\Pages;
use App\Models\Doctor;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DoctorResource extends Resource
{
    protected static ?string $model = Doctor::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->maxLength(50),

                TextInput::make('email')
                    ->label('Email')
                    ->required()
                    ->email()
                    ->unique(User::class, 'email'),

                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required(),

                TextInput::make('phone')
                    ->label('Phone')
                    ->required()
                    ->maxLength(20),

                TextInput::make('specialization')
                    ->label('Specialization')
                    // ->options([
                    //     'cardiologist' => 'Cardiologist',
                    //     'neurologist' => 'Neurologist',
                    //     'pediatrician' => 'Pediatrician',
                    //     'dermatologist' => 'Dermatologist',
                    // ])
                    ->required(),

                Textarea::make('bio')
                    ->label('Bio')
                    ->maxLength(500)
                    ->rows(7),

                FileUpload::make('user.avatar')
                    ->label('Profile Picture')
                    ->image()
                    ->directory('profiles'),

                DatePicker::make('joined_at')
                    ->label('Joining Date')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('user.avatar')
                    ->label('Profile Picture')
                    ->defaultImageUrl('https://hips.hearstapps.com/hmg-prod/images/portrait-of-a-happy-young-doctor-in-his-clinic-royalty-free-image-1661432441.jpg')
                    ->circular()
                    ->size(50),

                TextColumn::make('user.name')
                    ->label('Name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('user.email')
                    ->label('Email')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('yearsOfExperience')
                    ->label('Experience')
                    ->sortable()
                    ->formatStateUsing(fn(string $state): string => $state . ' years'),

                TextColumn::make('specialization')
                    ->label('Specialization')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Joining Date')
                    ->sortable()
                    ->dateTime('F j, Y'),
            ])
            ->filters([
                // Add filters if needed
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Define relations here
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDoctors::route('/'),
            'create' => Pages\CreateDoctor::route('/create'),
            'edit' => Pages\EditDoctor::route('/{record}/edit'),
        ];
    }
}
