<?php

namespace App\Filament\Resources\FeeResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Support\RawJs;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class AdditionalFeesRelationManager extends RelationManager
{
    protected static string $relationship = 'additional_fees';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Repeater::make('additional_fees')
                ->label('')
                ->addActionLabel('Add another')
                ->schema([
                    Forms\Components\TextInput::make('description')
                    ->required()
                    ->maxLength(255),
                    Forms\Components\TextInput::make('books')
                    ->prefix('₱')
                     ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->label('Amount')
                    ->required()
                    ->numeric(),
                ]),
            ])->columns(1);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('description')
            ->columns([
                Tables\Columns\TextColumn::make('description'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->label('Add Additional Fee')
                ->createAnother(false)->modalHeading('Add Additional Fee')
                ->modalSubmitActionLabel('Save'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
