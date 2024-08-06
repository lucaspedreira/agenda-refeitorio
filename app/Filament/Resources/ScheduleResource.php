<?php

namespace App\Filament\Resources;

use App\Enums\ScheduleStatus;
use App\Filament\Resources\ScheduleResource\Pages;
use App\Filament\Resources\ScheduleResource\RelationManagers;
use App\Models\Meal;
use App\Models\Schedule;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Validation\Rules\Unique;

class ScheduleResource extends Resource
{
    protected static ?string $model = Schedule::class;

    protected static ?string $navigationIcon = 'mdi-calendar-clock-outline';
    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = 'Agendamento';
    protected static ?string $pluralModelLabel = 'Agendamentos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Aluno')
                    ->placeholder('Selecione um aluno')
                    ->options(
                        User::all()->pluck('name', 'id')->toArray()
                    )
                    ->searchable()
                    ->native(false)
                    ->required(),
                Forms\Components\Select::make('meal_id')
                    ->label('Refeição')
                    ->placeholder('Selecione uma refeição')
                    ->options(
                        Meal::all()->pluck('name', 'id')->toArray()
                    )
                    ->unique(ignoreRecord: true, modifyRuleUsing: function (Unique $rule, callable $get) {
                        $date = date('Y-m-d', strtotime($get('date')));
                        $user_id = $get('user_id');
                        $meal_id = $get('meal_id');

                        return $rule->where('date', $date)
                            ->where('user_id', $user_id)
                            ->where('meal_id', $meal_id);
                    })
                    ->validationMessages([
                        'unique' => 'Já existe um agendamento para este aluno nesta refeição nesta data.'
                    ])
                    ->required(),
                Forms\Components\DatePicker::make('date')
                    ->label('Data')
                    ->native(false)
                    ->closeOnDateSelection()
                    ->minDate(now()->toDateString())
                    ->maxDate(now()->endOfWeek(5)->toDateString())
                    ->displayFormat('d/m/Y')
                    ->required(),
                Forms\Components\ToggleButtons::make('status')
                    ->label('Status')
                    ->options(ScheduleStatus::class)
                    ->default(ScheduleStatus::Scheduled)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Aluno')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('meal.name')
                    ->label('Refeição')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->label('Data')
                    ->date('l, d/m/Y')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
            ])
            ->filters([
                //
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSchedules::route('/'),
        ];
    }
}
