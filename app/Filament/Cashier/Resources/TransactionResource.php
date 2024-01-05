<?php

namespace App\Filament\Cashier\Resources;

use App\Filament\Cashier\Resources\TransactionResource\Pages;
use App\Filament\Cashier\Resources\TransactionResource\RelationManagers;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->date('F d, Y h:i A')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('student_id')
                ->label('Student Name')
                ->formatStateUsing(fn ($record) => $record->student->first_name.' '.$record->student->last_name)
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('payment_type')
                     ->label('Payment Type')
                     ->formatStateUsing(fn (string $state): string => strtoupper($state))
                     ->badge()
                    ->badge()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('total')
                    ->formatStateUsing(fn ($record) => '₱ '.number_format($record->total, 2))
                    ->badge()
                    ->color('success')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('balance')
                     ->formatStateUsing(fn ($record) => '₱ '.number_format($record->balance, 2))
                    ->badge()
                    ->color('success')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount_paid')
                    ->label('Amount Paid')
                    ->formatStateUsing(fn ($record) => '₱ '.number_format($record->amount_paid, 2))
                    ->badge()
                    ->color('success')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                Filter::make('created_at')
                ->form([
                    DatePicker::make('created_from')->label('From')->native(false)->default(today()),
                    DatePicker::make('created_until')->label('To')->native(false)->default(today()),
                ])->columns(2)->columnSpan(2)
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['created_from'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                        )
                        ->when(
                            $data['created_until'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                        );
                })
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\Action::make('view_invoice')
                ->label('View Invoice')
                ->icon('heroicon-o-document-text')
                ->button()
                ->url(fn ($record): string => TransactionResource::getUrl('view_invoice', [$record])),
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
            'view_invoice' => Pages\ViewInvoice::route('/invoice/{record}'),
        ];
    }
}
