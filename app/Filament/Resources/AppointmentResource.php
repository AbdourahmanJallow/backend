<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentResource\Pages;
use App\Filament\Resources\AppointmentResource\RelationManagers;
use App\Models\Appointment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;


class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('doctor_name')
                    ->label('Doctor')
                    ->required(),
                Forms\Components\TextInput::make('patient_name')
                    ->label('Patient')
                    ->readOnly()
                    ->required(),
                Forms\Components\DateTimePicker::make('scheduled_at')
                    ->label('Scheduled At')
                    ->required(),
                Forms\Components\Textarea::make('reasons')
                    ->readOnly()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('status')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('patient.user.name')
                    ->numeric()
                    ->label('Patient')
                    ->sortable(),
                Tables\Columns\TextColumn::make('doctor.user.name')
                    ->numeric()
                    ->label('Doctor')
                    ->sortable(),
                Tables\Columns\TextColumn::make('reasons')
                    ->numeric()
                    ->label('Reasons')
                    ->sortable(),
                Tables\Columns\TextColumn::make('scheduled_at')
                    ->dateTime()
                    ->label('Appointment Date')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }

    // public static function getTableQuery(): Builder
    // {
    //     $user = auth()->user();

    //     // Admins can see all appointments
    //     // if ($user->isAdmin()) {
    //     //     return Appointment::query();
    //     // }

    //     // Doctors can only see their own appointments
    //     if ($user->isDoctor()) {
    //         return Appointment::where('doctor_id', $user->doctor->id);
    //     }

    //     return Appointment::query();
    // }

    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();

        if (!$user->isAdmin()) {

            return parent::getEloquentQuery()->where('doctor_id', $user->doctor->id);
        }

        return parent::getEloquentQuery();
    }
}
