<?php

namespace App\Filament\Resources\Tenants\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TenantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->numeric(),
                TextInput::make('room_id')
                    ->required()
                    ->numeric(),
                TextInput::make('full_name')
                    ->required(),
                TextInput::make('phone_number')
                    ->tel()
                    ->required(),
                TextInput::make('telegram_id')
                    ->tel(),
                TextInput::make('bakong_account_id'),
                DatePicker::make('move_in_date')
                    ->required(),
                TextInput::make('deposit_amount')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
