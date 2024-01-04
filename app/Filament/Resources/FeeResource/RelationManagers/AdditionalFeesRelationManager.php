<?php

namespace App\Filament\Resources\FeeResource\RelationManagers;

use App\Models\Fee;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Mockery\Matcher\Not;
use Filament\Tables\Table;
use Filament\Support\RawJs;
use App\Models\AdditionalFee;
use Filament\Notifications\Notification;
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
                    Forms\Components\TextInput::make('amount')
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
                Tables\Columns\TextColumn::make('amount')
                ->badge()
                ->color('success')
                ->formatStateUsing(fn ($record) => '₱ '.number_format($record->amount, 2)),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->action(function (array $data): array {
                    $fee_id = $this->getOwnerRecord()->id;
                    foreach($data['additional_fees'] as $additional_fee){
                        AdditionalFee::create([
                            'fee_id' => $fee_id,
                            'description' => $additional_fee['description'],
                            'amount' => $additional_fee['amount'],
                          ]);
                     }
                    return $data;
                })

                ->label('Add New')
                ->createAnother(false)->modalHeading('Add Additional Fee')
                ->modalSubmitActionLabel('Save'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
