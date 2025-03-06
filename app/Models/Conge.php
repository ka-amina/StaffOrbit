<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conge extends Model
{
    /** @use HasFactory<\Database\Factories\CongesFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',
        'type',
        'start_date',
        'end_date',
        'total_days',
        'status',
        'manager_approval',
        'hr_approval',
    ];

    protected $dates = [
        'start_date',
        'end_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
