<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ColabsSkills extends Model
{
    protected $table = 'colabs_skills';

    public function colaborator()
    {
        return $this->belongsToMany('App\Colaborator','colaborators');
    }

    public function skill()
    {
        return $this->belongsToMany('App\Skill', 'skills');
    }
}
