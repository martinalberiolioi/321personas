<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $table = 'skills';
    protected $guarded = ['id'];

    public function colabsSkills()
    {
        return $this->hasMany('App\ColabsSkills', 'skill_id');
    }
}
