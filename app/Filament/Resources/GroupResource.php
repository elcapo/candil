<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GroupResource\Pages;
use App\Filament\Resources\GroupResource\RelationManagers\ActivistsRelationManager;
use App\Models\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GroupResource extends Resource
{
    protected static ?string $model = Group::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getModelLabel(): string
    {
        return trans('candil/group.model_label');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(4)
            ->schema([
                self::getNameFormSection(),
                self::getContactFormSection(),
                self::getAddressFormSection(),
            ]);
    }

    private static function getNameFormSection(): Section
    {
        return Section::make()
            ->columns(['xl' => 2])
            ->columnSpan(4)
            ->schema([
                TextInput::make('name')
                    ->label(trans('candil/group.name'))
                    ->required(),
                Select::make('type')
                    ->label(trans('candil/group.type'))
                    ->required()
                    ->options([
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
                    ]),
            ]);
    }

    private static function getContactFormSection(): Section
    {
        return Section::make()
            ->columns(['xl' => 2])
            ->columnSpan(4)
            ->schema([
                TextInput::make('email')
                    ->label(trans('candil/group.email')),
                TextInput::make('phone')
                    ->label(trans('candil/group.phone')),
            ]);
    }

    private static function getAddressFormSection(): Section
    {
        return Section::make()
            ->columns(['xl' => 4])
            ->columnSpan(4)
            ->schema([
                TextInput::make('street')
                    ->label(trans('candil/group.street')),
                TextInput::make('city')
                    ->label(trans('candil/group.city')),
                TextInput::make('province')
                    ->label(trans('candil/group.province')),
                TextInput::make('zip_code')
                    ->label(trans('candil/group.zip_code')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(trans('candil/group.name'))
                    ->sortable()
                    ->searchable(),
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
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ActivistsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGroups::route('/'),
            'create' => Pages\CreateGroup::route('/create'),
            'edit' => Pages\EditGroup::route('/{record}/edit'),
        ];
    }
}
