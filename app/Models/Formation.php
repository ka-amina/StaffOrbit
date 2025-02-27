<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    /** @use HasFactory<\Database\Factories\FormationFactory> */
    use HasFactory;

    protected $fillable = ['nom', 'type', 'date_formation'];

//    public function users()
//    {
//        return $this->belongsTo(user::class);
//    }
    public function users()
    {
        return $this->belongsToMany(users::class, 'employe_formation');
    }
}
