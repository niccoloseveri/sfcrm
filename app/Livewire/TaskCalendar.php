<?php

namespace App\Livewire;

// use Filament\Widgets\Widget;
use App\Filament\Resources\TaskResource;
use App\Models\Task;
use Carbon\Carbon;
use Saade\FilamentFullCalendar\Data\EventData;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class TaskCalendar extends FullCalendarWidget
{
    // protected static string $view = 'livewire.task-calendar';

    public function fetchEvents(array $fetchInfo): array
    {
        return Task::query()
            ->where('due_date', '>=', $fetchInfo['start'])
            ->where('due_date', '<=', $fetchInfo['end'])
            ->when(!auth()->user()->isAdmin(), function ($query) {
                return $query->where('user_id', auth()->id());
            })
            ->get()
            ->map(
                fn(Task $task) => EventData::make()
                    ->id($task->id)
                    ->title(strip_tags($task->description))
                    //->start($task->due_date)
                    ->start(Carbon::createFromFormat('Y-d-m H:i:s',$task->due_date->format('Y-d-m').' '.$task->due_time->format('H:i:s')))
                    ->end($task->due_date)
                    ->url(TaskResource::getUrl('edit', [$task->id]))
                    ->toArray()
            )
            ->toArray();
    }
}
