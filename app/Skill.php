<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $table = 'skills';
    protected $guarded = ['id'];
    
    public function colaborator()
    {
    	return $this->belongsToMany('App\Colaborator', 'colabs_skills', 'skill_id')->withTimestamps();
    }
}
