<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class KibTemplateExport implements WithMultipleSheets
{
    use Exportable;

    protected $kibType;

    public function __construct(string $kibType)
    {
        $this->kibType = strtoupper($kibType);
    }

    public function sheets(): array
    {
        return [
            new KibTemplateDataSheet($this->kibType),
            new KibTemplateGuidanceSheet($this->kibType),
        ];
    }
}
