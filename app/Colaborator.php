<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Colaborator extends Model
{
	use SoftDeletes;

    protected $table = 'colaborators';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    
    protected $softDelete = true;

    public function colabsSkills()
    {
        return $this->hasMany('App\ColabsSkills', 'colab_id');
    }
}
