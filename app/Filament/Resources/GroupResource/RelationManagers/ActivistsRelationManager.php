<?php

namespace App\Filament\Resources\GroupResource\RelationManagers;

use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ActivistsRelationManager extends RelationManager
{
    protected static string $relationship = 'activists';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return trans('candil/collaboration.plural_title');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('full_name')
            ->columns([
                TextColumn::make('join_date')
                    ->label(trans('candil/collaboration.join_date'))
                    ->sortable()
                    ->dateTime('d/m/Y'),
                TextColumn::make('status')
                    ->label(trans('candil/collaboration.status'))
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'in_practice' => trans('candil/collaboration.statuses.in_practice'),
                        'active' => trans('candil/collaboration.statuses.active'),
                        'inactive' => trans('candil/collaboration.statuses.inactive'),
                    }),
                TextColumn::make('full_name')
                    ->label(trans('candil/activist.full_name'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('email')
                    ->label(trans('candil/activist.email'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('phone')
                    ->label(trans('candil/activist.phone'))
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                //
            ]);
    }
}
