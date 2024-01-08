<?php

namespace App\Filament\Resources\StudentReportResource\Pages;

use App\Filament\Resources\StudentReportResource;
use Filament\Resources\Pages\Page;
use App\Models\Student;
use App\Models\Grade;
use App\Models\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Components\Grid;

class ReportStudent extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = StudentReportResource::class;

    protected static string $view = 'filament.resources.student-report-resource.pages.report-student';
    protected static ?string $title = 'Students';
    public $record;
    public $grade;
    public $section;


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()
                ->schema([
                    Select::make('grade')
                    ->label('Grade Level')
                    ->live()
                    ->afterStateUpdated(function ($state) {
                        //show all when nothing is selected
                        if($state == null)
                        {
                            $this->record = Student::all();
                        }else
                        {
                            $this->record = Student::where('grade_id', $state)->get();
                        }
                    })
                    ->options(Grade::all()->pluck('name', 'id')),
                    Select::make('section')
                    ->label('Section')
                    ->live()
                    ->options(fn ($get) => Section::where('grade_id', $get('grade'))->pluck('name', 'id'))
                    ->afterStateUpdated(function ($state, $get) {
                        //show all when nothing is selected
                        if($state == null)
                        {
                            $this->record = Student::where('grade_id',  $get('grade'))->get();
                        }else
                        {
                            $this->record = Student::where('grade_id', $get('grade'))
                            ->where('section_id', $state)->get();
                        }
                    })
                ])->columns(2)
            ]);
    }


    public function mount(): void
    {
        $this->record = Student::all();
        static::authorizeResourceAccess();
    }
}
