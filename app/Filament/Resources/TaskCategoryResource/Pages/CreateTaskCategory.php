<?php

namespace App\Filament\Resources\TaskCategoryResource\Pages;

use App\Filament\Resources\TaskCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTaskCategory extends CreateRecord
{
    protected static string $resource = TaskCategoryResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array {

        $color= ltrim($data['color'],'#');

        $json =file_get_contents('https://webaim.org/resources/contrastchecker/?fcolor=000000&bcolor='.$color.'&api');
        $djson = json_decode($json,true);

        $data['textcolor'] = $djson['AA']=='pass' ? '#000000' : '#FFFFFF';

        return $data;
    }
}

