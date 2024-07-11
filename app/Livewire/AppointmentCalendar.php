<?php

namespace App\Livewire;

// use Filament\Widgets\Widget;
use App\Filament\Resources\AppointmentResource;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Saade\FilamentFullCalendar\Data\EventData;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class AppointmentCalendar extends FullCalendarWidget
{
    // protected static string $view = 'livewire.task-calendar';

    public Model | string | null $model = Appointment::class;

    public function fetchEvents(array $fetchInfo): array
    {
        return Appointment::query()
            ->where('due_date', '>=', $fetchInfo['start'])
            ->where('due_date', '<=', $fetchInfo['end'])
            ->when(!auth()->user()->isAdmin(), function ($query) {
                return $query->where('user_id', auth()->id());
            })
            ->get()
            ->map(
                function (Appointment $appointment) : array {
                    $event = EventData::make()
                        ->id($appointment->id)
                        ->title(html_entity_decode(strip_tags($appointment->customer->is_azienda ? $appointment->customer->nome_az : $appointment->customer->first_name . ' ' . $appointment->customer->last_name)))

                        /*
                    function ($record) {
                        if($record->customer->is_azienda){
                            $r = $record->customer->nome_az;
                        } else $r = $record->customer->first_name . ' ' . $record->customer->last_name;
                        return $r;
                    }

                        */
                        ->start(Carbon::createFromFormat('Y-d-m H:i:s',$appointment->due_date->format('Y-d-m').' '.$appointment->due_time->format('H:i:s')))
                        ->end($appointment->due_date);

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
                el.setAttribute("x-data", "{ tooltip: '"+event.title+"' }");
            }
        JS;
    }
}
