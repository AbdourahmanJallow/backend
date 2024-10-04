<?php

namespace App\Filament\Resources\AppointmentResource\Pages;

use App\Filament\Resources\AppointmentResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListAppointments extends ListRecords
{
    protected static string $resource = AppointmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }


    public function getTabs(): array
    {
        return [
            null => Tab::make('All'),
            'pending' => Tab::make()->query(fn($query) => $query->where('status', 'pending')),
            'scheduled' => Tab::make()->query(fn($query) => $query->where('status', 'scheduled')),
            'completed' => Tab::make()->query(fn($query) => $query->where('status', 'completed')),
            'cancelled' => Tab::make()->query(fn($query) => $query->where('status', 'canceled')),
        ];
    }
}
