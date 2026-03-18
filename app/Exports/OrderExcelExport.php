<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromArray;

class OrderExcelExport implements FromArray
{
    protected $orders;
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct(array $orders)
    {
        $this->orders = $orders;
    }

    public function array(): array
    {
        return $this->orders;
    }

}
