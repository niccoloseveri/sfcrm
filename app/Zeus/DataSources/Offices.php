<?php

namespace App\Zeus\DataSources;

use LaraZeus\Bolt\DataSources\DataSourceContract;

class Offices extends DataSourceContract
{
    public function title(): string
    {
        return 'Offices';
    }

    public function getValuesUsing(): string
    {
        return 'name';
    }

    public function getKeysUsing(): string
    {
        return 'id';
    }

    public function getModel(): string
    {
        return \LaraZeus\Thunder\Models\Office::class;
    }
}

