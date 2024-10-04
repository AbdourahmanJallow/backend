<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum AppointmentStatus: string implements HasColor, HasIcon, HasLabel
{

    case Pending = 'pending';

    case Scheduled = 'scheduled';

    case Completed = 'completed';

    case Cancelled = 'canceled';

    public function getLabel(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Scheduled => 'Scheduled',
            self::Completed => 'Completed',
            self::Cancelled => 'Cancelled',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Pending => 'info',
            self::Scheduled => 'warning',
            self::Completed, => 'success',
            self::Cancelled => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            // self::New => 'heroicon-m-sparkles',
            self::Pending => 'heroicon-m-arrow-path',
            self::Scheduled => 'heroicon-m-calendar',
            self::Completed => 'heroicon-m-check-badge',
            self::Cancelled => 'heroicon-m-x-circle',
        };
    }
}
