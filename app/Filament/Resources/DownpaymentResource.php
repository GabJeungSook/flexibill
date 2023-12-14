<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Downpayment;
use Filament\Support\RawJs;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DownpaymentResource\Pages;
use App\Filament\Resources\DownpaymentResource\RelationManagers;

class DownpaymentResource extends Resource
{
    protected static ?string $model = Downpayment::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?int $navigationSort = 5;
    protected static ?string $navigationGroup = 'Manage Fees';
    protected static ?string $navigationLabel  = 'Down Payment';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('down_payment')
                ->prefix('₱')
                 ->mask(RawJs::make('$money($input)'))
                ->stripCharacters(',')
                ->label('Downpayment')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('down_payment')
                    ->label('Amount')
                    ->badge()
                    ->color('success')
                    ->formatStateUsing(fn ($record) => '₱ '. number_format($record->down_payment, 2)),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                  //  Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListDownpayments::route('/'),
            'create' => Pages\CreateDownpayment::route('/create'),
            'edit' => Pages\EditDownpayment::route('/{record}/edit'),
        ];
    }
}
