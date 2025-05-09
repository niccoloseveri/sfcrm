<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use App\Models\Customer;
use App\Models\PipelineStage;
use Filament\Actions;
use Filament\Forms\Components\Builder;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class ListCustomers extends ListRecords
{
    protected static string $resource = CustomerResource::class;
    //protected ?string $subheading = 'Caricamento documenti disabilitato.';



    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $tabs = [];

        // Adding `all` as our first tab
        if(auth()->user()->isAdmin()){
        $tabs['all'] = Tab::make('Tutti i Clienti')
            // We will add a badge to show how many customers are in this tab
            ->badge(Customer::count())->badgeColor('warning');
        }
        if (!auth()->user()->isAdmin()) {
            $tabs['my'] = Tab::make('I Miei Clienti')
                ->badge(Customer::where('employee_id', auth()->id())->count())->badgeColor('warning')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('employee_id', auth()->id());
                });
        }

        // Load all Pipeline Stages
        $pipelineStages = PipelineStage::orderBy('position')->withCount('customers')->get();

        // Loop through each Pipeline Stage
        foreach ($pipelineStages as $pipelineStage) {
            // Add a tab for each Pipeline Stage
            // Array index is going to be used in the URL as a slug, so we transform the name into a slug
            $tabs[str($pipelineStage->name)->slug()->toString()] = Tab::make($pipelineStage->name)
                // We will add a badge to show how many customers are in this tab
                ->badge($pipelineStage->customers_count >=1 ? ' • ': null)->badgeColor('warning')
                // We will modify the query to only show customers in this Pipeline Stage
                ->modifyQueryUsing(function ($query) use ($pipelineStage) {
                    return $query->where('pipeline_stage_id', $pipelineStage->id);
                });
        }
        $tabs['archived'] = Tab::make('Archiviati')
            ->badge(Customer::onlyTrashed()->count() >=1 ? ' • ' : null )->badgeColor('warning')
            ->modifyQueryUsing(function ($query) {
                return $query->onlyTrashed();
            });

        return $tabs;
    }

    /*
    protected function paginateTableQuery(EloquentBuilder $query): Paginator|CursorPaginator
    {
        return $query->simplePaginate(50);
    }
    */
}
