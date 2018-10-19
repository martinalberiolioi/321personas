<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Colaborator;

class IndexComposer
{

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $personas = Colaborator::with('skill')->get();
        $view->with('personas', $personas);
    }
}