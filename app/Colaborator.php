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

    protected $fillable = ['nombre',
                            'apellido',
                            'edad',
                            'dni',
                            'legajo',
                            'puesto',
                            'mail',
                        ];

    public function skill()
    {
        return $this->belongsToMany('App\Skill', 'colabs_skills', 'colab_id')->withTimestamps();
    }

}
