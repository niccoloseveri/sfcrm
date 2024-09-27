<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Support\Enums\ActionSize;

class Dashboard extends \Filament\Pages\Dashboard
{
    // ...
    use InteractsWithActions;
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-m-home';

    protected function getHeaderActions(): array
    {
       return [
            Action::make('newcontact')->label('Nuovo Cliente')->color('success')->size(ActionSize::Large)->icon('heroicon-s-user-plus')->url(fn():string => route('filament.admin.resources.customers.create')),
            Action::make('newtask')->label('Nuovo Task')->color('info')->size(ActionSize::Large)->icon('heroicon-o-rectangle-stack')->url(fn():string => route('filament.admin.resources.tasks.create')),
            Action::make('newappointment')->color('warning')->label('Nuovo Appuntamento')->size(ActionSize::Large)->icon('heroicon-o-calendar-days')->url(fn():string => route('filament.admin.resources.appointments.create')),
            //Action::make('newnote')->color('warning')->label('Nuova Nota')->size(ActionSize::Large)->icon('heroicon-o-calendar-days')->url(fn():string => route('#'))

       ];
    }
}
