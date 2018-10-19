<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Skill;

class CreateComposer
{

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $skills = Skill::orderBy('nombre','asc')->get();
        $view->with('skills', $skills);
    }
}