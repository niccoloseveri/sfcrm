<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Task;
use Filament\Tables;
use App\Models\Customer;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TaskResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TaskResource\RelationManagers;
use Filament\Notifications\Notification;


class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $modelLabel="Task";
    protected static ?string $pluralModelLabel="Tasks";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('customer_id')->label('Cliente')
                    ->searchable()
                    ->relationship('customer')
                    ->getOptionLabelFromRecordUsing(function (Customer $record){
                        if($record->is_azienda){
                            $r = $record->nome_az;
                        } else $r = $record->first_name . ' ' . $record->last_name;
                        return $r;
                    })
                    ->preload()
                    ->searchable(['first_name', 'last_name', 'nome_az'])
                    ->required(),
                Forms\Components\Select::make('user_id')->label('Commerciale')
                    ->preload()
                    ->searchable()
                    ->relationship('employee', 'name'),
                Forms\Components\RichEditor::make('description')->label('Descrizione')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('due_date')->label('Data Scadenza'),
                Forms\Components\TimePicker::make('due_time')->label('Ora Scadenza'),

                Forms\Components\Toggle::make('is_completed')->label('Completato?')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('is_completed')->label('Completo?')
                    ->boolean(),
                Tables\Columns\TextColumn::make('customer.first_name')->label('Cliente')
                    ->formatStateUsing(function ($record) {
                        if($record->customer->is_azienda){
                            $r = $record->customer->nome_az;
                        } else $r = $record->customer->first_name . ' ' . $record->customer->last_name;
                        return $r;
                    })
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(),
                Tables\Columns\TextColumn::make('employee.name')->label('Impiegato')

                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')->label('Descrizione')
                    ->html(),
                Tables\Columns\TextColumn::make('due_date')->label('Data Scadenza')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('due_time')->label('Ora Scadenza')
                    ->time()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')->label('Creato')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->label('Modificato')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('Complete')->label('Completa')
                    ->hidden(fn (Task $record) => $record->is_completed)
                    ->icon('heroicon-m-check-badge')
                    ->modalHeading('Task completato?')
                    ->modalDescription('Sei sicuro di vole contrassegnare il task come completo?')
                    ->action(function (Task $record) {
                        $record->is_completed = true;
                        $record->save();

                        Notification::make()
                            ->title('Task completato.')
                            ->success()
                            ->send();
                    })
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort(function ($query) {
                return $query->orderBy('due_date', 'asc')
                    ->orderBy('id', 'desc');
            });
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
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
            'edit' => Pages\EditTask::route('/{record}/edit'),
        ];
    }
}
