<?php

namespace App\Filament\Resources\Properties\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
class PropertyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                ->label('Property Manager')
                ->relationship(name: 'user', titleAttribute: 'name') // 👈 This links to the User model
                ->searchable() // Makes it easy to find a user if you have many
                ->preload()    // Loads the names immediately (great for mobile)
                ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('address'),
            ]);
    }
}
