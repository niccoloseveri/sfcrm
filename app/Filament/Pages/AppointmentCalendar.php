<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class AppointmentCalendar extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    // Our Custom heading to be displayed on the page
    protected ?string $heading = 'Calendario Appuntamenti';
    // Custom Navigation Link name
    protected static ?string $navigationLabel = 'Calendario Appuntamenti';
    protected static ?string $title= 'Calendario Appuntamenti';
    protected static ?int $navigationSort = 4;



    protected static string $view = 'filament.pages.appointment-calendar';
}
