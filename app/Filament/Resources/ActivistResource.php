<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivistResource\Pages;
use App\Filament\Resources\ActivistResource\RelationManagers\GroupsRelationManager;
use App\Models\Activist;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ActivistResource extends Resource
{
    protected static ?string $model = Activist::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $recordTitleAttribute = 'full_name';

    public static function getModelLabel(): string
    {
        return trans('candil/activist.model_label');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(4)
            ->schema([
                self::getNameFormSection(),
                self::getContactFormSection(),
                self::getPictureFormSection(),
                self::getIdentificationFormSection(),
                self::getDatesFormSection(),
                self::getAddressFormSection(),
            ]);
    }

    private static function getNameFormSection(): Section
    {
        return Section::make()
            ->columns(['xl' => 3])
            ->columnSpan(4)
            ->schema([
                TextInput::make('first_name')
                    ->label(trans('candil/activist.first_name'))
                    ->required(),
                TextInput::make('surname')
                    ->label(trans('candil/activist.surname'))
                    ->required(),
                TextInput::make('second_surname')
                    ->label(trans('candil/activist.second_surname')),
            ]);
    }

    private static function getContactFormSection(): Section
    {
        return Section::make()
            ->columns(['xl' => 1])
            ->columnSpan(1)
            ->schema([
                TextInput::make('email')
                    ->label(trans('candil/activist.email')),
                TextInput::make('phone')
                    ->label(trans('candil/activist.phone')),
                TextInput::make('second_phone')
                    ->label(trans('candil/activist.second_phone')),
            ]);
    }

    private static function getPictureFormSection(): Section
    {
        return Section::make()
            ->columns(['xl' => 3])
            ->columnSpan(3)
            ->schema([
                FileUpload::make('picture_filename')
                    ->label(trans('candil/activist.picture'))
                    ->visibility('private')
                    ->image()
                    ->columnSpanFull(),
            ]);
    }

    private static function getIdentificationFormSection(): Section
    {
        return Section::make()
            ->columns(['xl' => 2])
            ->columnSpan(2)
            ->schema([
                TextInput::make('identity_number')
                    ->label(trans('candil/activist.identity_number'))
                    ->required(),
                Select::make('identity_type')
                    ->label(trans('candil/activist.identity_type'))
                    ->default('nif')
                    ->options([
                        'nif' => 'NIF',
                        'nie' => 'NIE',
                        'other' => 'Otro',
                    ]),
            ]);
    }

    private static function getDatesFormSection(): Section
    {
        return Section::make()
            ->columns(['xl' => 2])
            ->columnSpan(2)
            ->schema([
                DatePicker::make('birth_date')
                    ->label(trans('candil/activist.birth_date'))
                    ->required()
                    ->native(false)
                    ->displayFormat('d/m/Y'),
                DatePicker::make('join_date')
                    ->label(trans('candil/activist.join_date'))
                    ->native(false)
                    ->displayFormat('d/m/Y'),
            ]);
    }

    private static function getAddressFormSection(): Section
    {
        return Section::make()
            ->columns(['xl' => 4])
            ->columnSpan(4)
            ->schema([
                TextInput::make('street')
                    ->label(trans('candil/activist.street')),
                TextInput::make('city')
                    ->label(trans('candil/activist.city')),
                TextInput::make('province')
                    ->label(trans('candil/activist.province')),
                TextInput::make('zip_code')
                    ->label(trans('candil/activist.zip_code')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('join_date')
                    ->label(trans('candil/activist.join_date'))
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->dateTime('d/m/Y')
                    ->sortable(),
                TextColumn::make('identity_number')
                    ->label(trans('candil/activist.identity_number'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable()
                    ->searchable(),
                TextColumn::make('identity_type')
                    ->label(trans('candil/activist.identity_type'))
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('first_name')
                    ->label(trans('candil/activist.first_name'))
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable()
                    ->searchable(),
                TextColumn::make('surname')
                    ->label(trans('candil/activist.surname'))
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable()
                    ->searchable(),
                TextColumn::make('second_surname')
                    ->label(trans('candil/activist.second_surname'))
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable()
                    ->searchable(),
                TextColumn::make('birth_date')
                    ->label(trans('candil/activist.birth_date'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->dateTime('d/m/Y')
                    ->sortable(),
                TextColumn::make('email')
                    ->label(trans('candil/activist.email'))
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable()
                    ->searchable(),
                TextColumn::make('phone')
                    ->label(trans('candil/activist.phone'))
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable()
                    ->searchable(),
                TextColumn::make('second_phone')
                    ->label(trans('candil/activist.second_phone'))
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('street')
                    ->label(trans('candil/activist.street'))
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('city')
                    ->label(trans('candil/activist.city'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable()
                    ->searchable(),
                TextColumn::make('province')
                    ->label(trans('candil/activist.province'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable()
                    ->searchable(),
                TextColumn::make('zip_code')
                    ->label(trans('candil/activist.zip_code'))
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
            GroupsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivists::route('/'),
            'create' => Pages\CreateActivist::route('/create'),
            'edit' => Pages\EditActivist::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [
            'first_name',
            'surname',
            'second_surname',
            'identity_number',
            'email',
            'phone',
            'second_phone',
        ];
    }
}
