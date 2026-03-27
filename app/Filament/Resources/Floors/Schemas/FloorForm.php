<?php

namespace App\Filament\Resources\Floors\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;


class FloorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('property_id')
                    ->relationship('property', 'name')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('level')
                    ->numeric()
                    ->default(0)
                    ->required(),
            ]);
    }
}
