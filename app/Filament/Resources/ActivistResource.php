<?php

namespace App\Filament\Resources;

use App\Filament\CanDeleteBulk;
use App\Filament\RefreshableAuditsRelationManager;
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
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ActivistResource extends Resource
{
    protected static ?string $model = Activist::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?int $navigationSort = 1;

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
                    ->label(trans('candil/attributes.first_name'))
                    ->required(),
                TextInput::make('surname')
                    ->label(trans('candil/attributes.surname'))
                    ->required(),
                TextInput::make('second_surname')
                    ->label(trans('candil/attributes.second_surname')),
            ]);
    }

    private static function getContactFormSection(): Section
    {
        return Section::make()
            ->columns(['xl' => 2])
            ->columnSpan(2)
            ->schema([
                TextInput::make('email')
                    ->label(trans('candil/attributes.email'))
                    ->columnSpan(2),
                TextInput::make('phone')
                    ->label(trans('candil/attributes.phone')),
                TextInput::make('second_phone')
                    ->label(trans('candil/attributes.second_phone')),
            ]);
    }

    private static function getPictureFormSection(): Section
    {
        return Section::make()
            ->columns(['xl' => 2])
            ->columnSpan(2)
            ->schema([
                FileUpload::make('picture_filename')
                    ->label(trans('candil/attributes.picture'))
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
                    ->label(trans('candil/attributes.identity_number'))
                    ->required(),
                Select::make('identity_type')
                    ->label(trans('candil/attributes.identity_type'))
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
                    ->label(trans('candil/attributes.birth_date'))
                    ->required()
                    ->native(false)
                    ->displayFormat('d/m/Y'),
                DatePicker::make('join_date')
                    ->label(trans('candil/attributes.join_date'))
                    ->required()
                    ->native(false)
                    ->displayFormat('d/m/Y')
                    ->default(fn () => \Carbon\Carbon::today()),
            ]);
    }

    private static function getAddressFormSection(): Section
    {
        return Section::make()
            ->columns(['xl' => 4])
            ->columnSpan(4)
            ->schema([
                TextInput::make('street')
                    ->label(trans('candil/attributes.street')),
                TextInput::make('city')
                    ->label(trans('candil/attributes.city')),
                TextInput::make('province')
                    ->label(trans('candil/attributes.province')),
                TextInput::make('zip_code')
                    ->label(trans('candil/attributes.zip_code')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('join_date')
                    ->label(trans('candil/attributes.join_date'))
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->dateTime('d/m/Y')
                    ->sortable(),
                TextColumn::make('identity_number')
                    ->label(trans('candil/attributes.identity_number'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable()
                    ->searchable(),
                TextColumn::make('identity_type')
                    ->label(trans('candil/attributes.identity_type'))
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('first_name')
                    ->label(trans('candil/attributes.first_name'))
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable()
                    ->searchable(),
                TextColumn::make('surname')
                    ->label(trans('candil/attributes.surname'))
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable()
                    ->searchable(),
                TextColumn::make('second_surname')
                    ->label(trans('candil/attributes.second_surname'))
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable()
                    ->searchable(),
                TextColumn::make('birth_date')
                    ->label(trans('candil/attributes.birth_date'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->dateTime('d/m/Y')
                    ->sortable(),
                TextColumn::make('email')
                    ->label(trans('candil/attributes.email'))
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable()
                    ->searchable(),
                TextColumn::make('phone')
                    ->label(trans('candil/attributes.phone'))
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable()
                    ->searchable(),
                TextColumn::make('second_phone')
                    ->label(trans('candil/attributes.second_phone'))
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('street')
                    ->label(trans('candil/attributes.street'))
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('city')
                    ->label(trans('candil/attributes.city'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable()
                    ->searchable(),
                TextColumn::make('province')
                    ->label(trans('candil/attributes.province'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable()
                    ->searchable(),
                TextColumn::make('zip_code')
                    ->label(trans('candil/attributes.zip_code'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->before(fn (DeleteBulkAction $action, Collection $records) => CanDeleteBulk::check($action, $records)),
                    Tables\Actions\ForceDeleteBulkAction::make()
                        ->before(fn (ForceDeleteBulkAction $action, Collection $records) => CanDeleteBulk::check($action, $records)),
                    Tables\Actions\RestoreBulkAction::make(),
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
            RefreshableAuditsRelationManager::class,
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
