<?php

namespace App\Filament\Resources\Tenants\Tables;

use App\Notifications\TenantNotification;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TenantsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->contentGrid([
                'sm' => 1,
                'md' => 2,
                'lg' => 3,
            ])
            ->columns([
                TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('room_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('full_name')
                    ->searchable(),
                TextColumn::make('phone_number')
                    ->searchable(),
                TextColumn::make('telegram_id')
                    ->searchable(),
                TextColumn::make('bakong_account_id')
                    ->searchable(),
                TextColumn::make('move_in_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('deposit_amount')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('sendTelegram')
                    ->label('Send Telegram')
                    ->icon(Heroicon::OutlinedPaperAirplane->value)
                    ->color('success')
                    ->visible(fn ($record) => $record->telegram_id !== null)
                    ->form([
                        Textarea::make('message')
                            ->required()
                            ->rows(5),
                    ])
                    ->action(function (array $data, $record) {
                        $record->notify(new TenantNotification($data['message']));
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Send Telegram Message')
                    ->modalDescription('This will send a message directly to the tenant on Telegram.')
                    ->modalSubmitActionLabel('Send Message'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
