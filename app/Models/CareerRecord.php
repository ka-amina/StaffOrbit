<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerRecord extends Model
{
    /** @use HasFactory<\Database\Factories\CareerRecordFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'notes',
        'end_date',
        'document_path',
        'status',
    ];

    public function user()
{
    return $this->belongsTo(User::class);
}
}
