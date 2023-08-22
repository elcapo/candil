<?php

namespace App\Filament\Resources\ActivistResource\RelationManagers;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class GroupsRelationManager extends RelationManager
{
    protected static string $relationship = 'groups';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return trans('candil/collaboration.plural_title');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('join_date')
                    ->label(trans('candil/collaboration.join_date'))
                    ->required()
                    ->native(false)
                    ->displayFormat('d/m/Y'),
                Select::make('status')
                    ->label(trans('candil/collaboration.status'))
                    ->required()
                    ->options([
                        'in_practice' => trans('candil/collaboration.statuses.in_practice'),
                        'active' => trans('candil/collaboration.statuses.active'),
                        'inactive' => trans('candil/collaboration.statuses.inactive'),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
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
                TextColumn::make('name')
                    ->label(trans('candil/group.name'))
                    ->sortable(),
                TextColumn::make('type')
                    ->label(trans('candil/group.type'))
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'local_group' => trans('candil/group.types.local_group'),
                        'action_group' => trans('candil/group.types.action_group'),
                        'university_group' => trans('candil/group.types.university_group'),
                        'autonomous_entity_group' => trans('candil/group.types.autonomous_entity_group'),
                        'state_secretariat_group' => trans('candil/group.types.state_secretariat_group'),
                        'country_work_group' => trans('candil/group.types.country_work_group'),
                        'autonomous_entity' => trans('candil/group.types.autonomous_entity'),
                        'committee' => trans('candil/group.types.committee'),
                        'commission' => trans('candil/group.types.commission'),
                        'work_group' => trans('candil/group.types.work_group'),
                    }),
                TextColumn::make('email')
                    ->label(trans('candil/group.email'))
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable()
                    ->searchable(),
                TextColumn::make('phone')
                    ->label(trans('candil/group.phone'))
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable()
                    ->searchable(),
                TextColumn::make('street')
                    ->label(trans('candil/group.street'))
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('city')
                    ->label(trans('candil/group.city'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable()
                    ->searchable(),
                TextColumn::make('province')
                    ->label(trans('candil/group.province'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable()
                    ->searchable(),
                TextColumn::make('zip_code')
                    ->label(trans('candil/group.zip_code'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->form(fn (AttachAction $action): array => [
                        $action->getRecordSelect(),
                        DatePicker::make('join_date')
                            ->label(trans('candil/collaboration.join_date'))
                            ->required(),
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
