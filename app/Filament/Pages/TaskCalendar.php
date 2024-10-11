<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class TaskCalendar extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
        // Our Custom heading to be displayed on the page
        protected ?string $heading = 'Calendario Task';
        // Custom Navigation Link name
        protected static ?string $navigationGroup="Clienti";

        protected static ?string $navigationLabel = 'Calendario Task';
        protected static ?string $title= 'Calendario Task';
        protected static ?int $navigationSort = 6;


    protected static string $view = 'filament.pages.task-calendar';
}
