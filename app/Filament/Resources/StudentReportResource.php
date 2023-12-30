<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentReportResource\Pages;
use App\Filament\Resources\StudentReportResource\RelationManagers;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentReportResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationGroup = 'Reports';
    protected static ?string $navigationLabel  = 'Students';
    protected static ?int $navigationSort = 10;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

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
                //
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
            'index' => Pages\ReportStudent::route('/'),
            'create' => Pages\CreateStudentReport::route('/create'),
            'edit' => Pages\EditStudentReport::route('/{record}/edit'),
        ];
    }
}
