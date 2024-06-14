<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Resources\TaskResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\Task;
use Filament\Resources\Components\Tab;

class ListTasks extends ListRecords
{
    protected static string $resource = TaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $tabs = [];

        if (!auth()->user()->isAdmin()) {
            $tabs[] = Tab::make('I Miei Tasks')
                ->badge(Task::where('user_id', auth()->id())->count())
                ->modifyQueryUsing(function ($query) {
                    return $query->where('user_id', auth()->id());
                });
        }
        if (auth()->user()->isAdmin()) {
        $tabs[] = Tab::make('Tutti i Tasks')
            ->badge(Task::count());
        }
        $tabs[] = Tab::make('Completati')
            ->badge(Task::where('is_completed', true)->where('user_id', auth()->id())->count())
            ->modifyQueryUsing(function ($query) {
                return $query->where('is_completed', true)->where('user_id', auth()->id());
            });

        $tabs[] = Tab::make('Incompleti')
            ->badge(Task::where('is_completed', false)->where('user_id', auth()->id())->count())
            ->modifyQueryUsing(function ($query) {
                return $query->where('is_completed', false)->where('user_id', auth()->id());
            });

        return $tabs;
    }
}
