<?php

namespace App\Filament\Resources;

use App\Filament\CanDeleteBulk;
use App\Filament\RefreshableAuditsRelationManager;
use App\Filament\Resources\ActivistGroupResource\Pages;
use App\Filament\Resources\ActivistGroupResource\RelationManagers;
use App\Models\ActivistGroup;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
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
use Illuminate\Support\Str;

class ActivistGroupResource extends Resource
{
    protected static ?string $model = ActivistGroup::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';

    protected static ?int $navigationSort = 3;

    public static function getModelLabel(): string
    {
        return trans('candil/collaboration.model_label');
    }

    public static function getPluralLabel(): ?string
    {
        return trans('candil/collaboration.plural_title');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema([
                DatePicker::make('join_date')
                    ->label(trans('candil/attributes.join_date'))
                    ->required()
                    ->native(false)
                    ->default(fn () => \Carbon\Carbon::today())
                    ->displayFormat('d/m/Y'),
                Select::make('status')
                    ->label(trans('candil/attributes.status'))
                    ->required()
                    ->default('active')
                    ->options([
                        'in_practice' => trans('candil/collaboration.statuses.in_practice'),
                        'active' => trans('candil/collaboration.statuses.active'),
                        'inactive' => trans('candil/collaboration.statuses.inactive'),
                    ])
                    ->afterStateUpdated(function ($set, $state) {
                        // https://github.com/filamentphp/filament/issues/8010
                        $set('leave_date', $state == 'inactive' ? \Carbon\Carbon::today() : null);
                    }),
                DatePicker::make('leave_date')
                    ->label(trans('candil/attributes.leave_date'))
                    ->native(false)
                    ->displayFormat('d/m/Y'),
                Group::make()
                    ->columnSpan(4)
                    ->columns(2)
                    ->schema([
                        Select::make('group_id')
                            ->label(Str::title(trans('candil/group.model_label')))
                            ->relationship('group', 'name')
                            ->required()
                            ->searchable(),
                        Select::make('activist_id')
                            ->label(Str::title(trans('candil/activist.model_label')))
                            ->relationship('activist', 'full_name')
                            ->required()
                            ->searchable(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('join_date')
                    ->label(trans('candil/attributes.join_date'))
                    ->sortable()
                    ->dateTime('d/m/Y'),
                TextColumn::make('status')
                    ->label(trans('candil/attributes.status'))
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'in_practice' => trans('candil/collaboration.statuses.in_practice'),
                        'active' => trans('candil/collaboration.statuses.active'),
                        'inactive' => trans('candil/collaboration.statuses.inactive'),
                    }),
                TextColumn::make('leave_date')
                    ->label(trans('candil/attributes.leave_date'))
                    ->sortable()
                    ->dateTime('d/m/Y'),
                TextColumn::make('group.name')
                    ->label(Str::title(trans('candil/group.model_label')))
                    ->sortable(),
                TextColumn::make('activist.full_name')
                    ->label(Str::title(trans('candil/activist.model_label')))
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('is_active')
                    ->label(trans('candil/collaboration.filters.is_active'))
                    ->query(fn (Builder $query): Builder => $query->whereIn('status', ['in_practice', 'active']))
                    ->default(),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
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
            RefreshableAuditsRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivistGroups::route('/'),
            'create' => Pages\CreateActivistGroup::route('/create'),
            'edit' => Pages\EditActivistGroup::route('/{record}/edit'),
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
