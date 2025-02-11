<?php

namespace App\Zeus\DataSources;

use LaraZeus\Bolt\DataSources\DataSourceContract;

class TipoForm extends DataSourceContract
{
    public function title(): string
    {
        return 'TipoForm';
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
        return \App\Models\TipoForm::class;
    }
}

