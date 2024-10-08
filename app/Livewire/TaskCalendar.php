<?php

namespace App\Livewire;

// use Filament\Widgets\Widget;
use App\Filament\Resources\TaskResource;
use Illuminate\Database\Eloquent\Model;
use App\Models\Task;
use Carbon\Carbon;
use Saade\FilamentFullCalendar\Data\EventData;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class TaskCalendar extends FullCalendarWidget
{
    // protected static string $view = 'livewire.task-calendar';

    public Model | string | null $model = Task::class;

    public function headerActions(): array
    {
        return [];
    }

    public function fetchEvents(array $fetchInfo): array
    {
        //dump($fetchInfo);
        return Task::query()
            ->where('due_date', '>=', $fetchInfo['start'])
            ->where('due_date', '<=', $fetchInfo['end'])
            ->where('is_completed','=',false)
            ->when(!auth()->user()->isAdmin(), function ($query) {
                return $query->where('user_id', auth()->id());
            })
            ->get()
            ->map(
                function (Task $task) : array {
                    $event = EventData::make()
                        ->id($task->id)

                        ->title(strip_tags($task->customer->is_azienda == true ? $task->customer->nome_az :$task->customer->first_name.' '.$task->customer->last_name).' – '. html_entity_decode(strip_tags($task->description)))
                        //->title(html_entity_decode(strip_tags($task->description)))
                        ->extendedProps([
                            'desc' => html_entity_decode(strip_tags($task->description)),
                            'cust' => $task->customer->is_azienda == true ? $task->customer->nome_az :$task->customer->first_name.' '.$task->customer->last_name,
                        ])
                        ->start(
                            $task->due_date
                        )
                        ->end($task->due_date)
                        ->allDay();
                    if($task->taskcategory != null){
                        $event->backgroundColor($task->taskcategory->color)
                        ->borderColor($task->taskcategory->color)
                        ->textColor($task->taskcategory->textcolor)
                        ->extraProperties([
                            'eventColor' => $task->taskcategory->color,
                        ]);

                    }


                    return $event->toArray();

                }
                /*fn(Task $task) => EventData::make()
                    ->id($task->id)
                    ->title(strip_tags($task->description))
                    //->start($task->due_date)
                    ->start(Carbon::createFromFormat('Y-d-m H:i:s',$task->due_date->format('Y-d-m').' '.$task->due_time->format('H:i:s')))
                    ->end($task->due_date)
                    //->backgroundColor($task->taskcategory?->color)
                    //->borderColor($task->taskcategory->color)
                    ->toArray()*/
            )
            ->toArray();
    }

    public function eventDidMount(): string
    {
        return <<<JS
            function({ event, timeText, isStart, isEnd, isMirror, isPast, isFuture, isToday, el, view }){
                el.setAttribute("x-tooltip", "tooltip");
                el.setAttribute("x-data", "{ tooltip: '"+event.extendedProps.cust+" – "+event.extendedProps.desc+"' }");
            }
        JS;
    }
}
