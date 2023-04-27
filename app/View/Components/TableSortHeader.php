<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TableSortHeader extends Component
{

    public $orderBy;
    public $ascending;
    public $columnName;
    public $columnText;
    public $searchable;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($orderBy, $ascending, $columnName, $columnText, $searchable = false)
    {
        $this->orderBy = $orderBy;
        $this->ascending = $ascending;
        $this->columnName = $columnName;
        $this->columnText = $columnText;
        $this->searchable = $searchable;
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
