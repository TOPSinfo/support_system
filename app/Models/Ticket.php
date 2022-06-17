<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tickets';

    /**
     * The attributes that are mass assignable.
     *
     */
    protected $fillable = [
        'salted_hash_id',
        'title',
        'description',
        'status',
        'created_by',
        'lastmodified_by_type',
        'lastmodified_by',
    ];
}
