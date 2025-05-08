<?php

return [
    /**
     * set the default domain.
     */
    'domain' => env('APP_URL'),

    /**
     * set the default path for the blog homepage.
     */
    'prefix' => 'tickets',


    /*
     * set database table prefix
     */
    'table-prefix' => 'thunder_',

    /**
     * the middleware you want to apply on all the blog routes
     * for example if you want to make your blog for users only, add the middleware 'auth'.
     */
    'middleware' => ['web'],

    /**
     * you can overwrite any model and use your own
     * you can also configure the model per panel in your panel provider using:
     * ->skyModels([ ... ])
     */
    'models' => [
        'Office' => \LaraZeus\Thunder\Models\Office::class,
        'Operations' => \LaraZeus\Thunder\Models\Operations::class,
        //'Ticket' => \LaraZeus\Thunder\Models\Ticket::class,
        'Ticket' => \App\Models\Ticket::class, // Example: Custom Ticket model
        'TicketsStatus' => \LaraZeus\Thunder\Models\TicketsStatus::class,
        'Abilities' => \LaraZeus\Thunder\Enums\Abilities::class,
    ],

    'default-status' => 'OPEN',

    /*
     * generate ticket no using:
     */
    'ticket-no' => \LaraZeus\Thunder\Support\TicketNo::class,

    /*
     * the mini chart is to show the numbers of open and closes tickets, you can overwrite the widget with your class
     */
    'office-mini-chart' => \LaraZeus\Thunder\Filament\Resources\OfficeResource\Widgets\OfficeTicketsChart::class,

    'comments-editor-toolbar' => [
        'attachFiles',
        'blockquote',
        'bold',
        'bulletList',
        'codeBlock',
        'heading',
        'italic',
        'link',
        'orderedList',
        'redo',
        'strike',
        'table',
        'undo',
    ],

    'chat_polling' => [
        'enabled' => true,
        'time' => '15s', // or '15000ms' or 'keep-alive'
    ],
];
