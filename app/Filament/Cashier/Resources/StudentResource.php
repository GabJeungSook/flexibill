<?php

namespace App\Filament\Cashier\Resources;

use App\Filament\Cashier\Resources\StudentResource\Pages;
use App\Filament\Cashier\Resources\StudentResource\RelationManagers;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('grade_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('section_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('first_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('last_name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('first_name')
                ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                ->searchable(),
                Tables\Columns\TextColumn::make('address')
                ->searchable(),
                Tables\Columns\TextColumn::make('grade.name')
                    ->label('Grade Level')
                    ->sortable(),
                Tables\Columns\TextColumn::make('section.name')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('grade')
                ->label('Grade Level')
                ->relationship('grade', 'name')
                ->searchable()
                ->preload(),
            ])
            ->actions([
                Tables\Actions\Action::make('view_billing')
                ->label('View Statement')
                ->icon('heroicon-o-eye')
                ->button()
                ->url(fn ($record): string => StudentResource::getUrl('view_statement', [$record])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
            'add' => Pages\AddBilling::route('/bill/{record}'),
            'view_statement' => Pages\ViewBillingStatement::route('/statement/{record}'),
        ];
    }
}
