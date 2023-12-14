<?php

namespace App\Filament\Resources;

use App\Models\Fee;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Support\RawJs;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\FeeResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\FeeResource\RelationManagers;

class FeeResource extends Resource
{
    protected static ?string $model = Fee::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationGroup = 'Manage Fees';
    protected static ?string $navigationLabel  = 'Fees';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('grade_id')
                ->label('Grade Level')
                ->required()
                ->unique(ignoreRecord : true)
                ->live()
                ->relationship(name: 'grade', titleAttribute: 'name'),
                Forms\Components\TextInput::make('tuition')
                    ->prefix('₱')
                     ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->label('Tuition Fee')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('misc')
                    ->prefix('₱')
                     ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                ->label('Miscellaneous Fee')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('books')
                    ->prefix('₱')
                     ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->label('Books')
                    ->required()
                    ->numeric(),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('grade.name')
                    ->label('Grade Level'),
                Tables\Columns\TextColumn::make('tuition')
                    ->label('Tuition Fee')
                    ->badge()
                    ->color('success')
                    ->formatStateUsing(fn ($record) => '₱ '. number_format($record->tuition, 2)),
                Tables\Columns\TextColumn::make('misc')
                    ->label('Miscellaneous Fee')
                    ->badge()
                    ->color('success')
                    ->formatStateUsing(fn ($record) => '₱ '.number_format($record->misc, 2)),
                Tables\Columns\TextColumn::make('books')
                    ->label('Books')
                    ->badge()
                    ->color('success')
                    ->formatStateUsing(fn ($record) => '₱ '.number_format($record->books, 2)),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                   // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFees::route('/'),
            'create' => Pages\CreateFee::route('/create'),
            'edit' => Pages\EditFee::route('/{record}/edit'),
        ];
    }
}
