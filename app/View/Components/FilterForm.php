<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FilterForm extends Component
{
   public string $exclude;   
    public ?string $action;    
    public string $method;

    public function __construct(string $exclude, ?string $action = null, string $method = 'GET')
    {
        $this->exclude = $exclude;
        $this->action = $action ?? url()->current();
        $this->method = $method;
    }

    public function render(): View|Closure|string
    {
        return view('components.forms.filter-form');
    }
}

