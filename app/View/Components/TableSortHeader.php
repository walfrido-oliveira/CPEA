<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TableSortHeader extends Component
{

    public $orderBy;
    public $ascending;
    public $columnName;
    public $columnText;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($orderBy, $ascending, $columnName, $columnText)
    {
        $this->orderBy = $orderBy;
        $this->ascending = $ascending;
        $this->columnName = $columnName;
        $this->columnText = $columnText;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.table-sort-header');
    }
}
