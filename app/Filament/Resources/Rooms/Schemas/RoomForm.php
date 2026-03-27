<?php

namespace App\Filament\Resources\Rooms\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use App\Models\Floor;


class RoomForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('property_id')
                    ->relationship('property', 'name')
                    ->required()
                    ->live(),
                Select::make('floor_id')
                    ->relationship(
                        name: 'floor',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (Get $get, $query) => $query->where('property_id', $get('property_id')),
                    )
                    ->required(),
                TextInput::make('room_name')
                    ->required(),
            ]);
    }
}
