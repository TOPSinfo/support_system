<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Ticket;

class Comment extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'comments';

    /**
     * The attributes that are mass assignable.
     *
     */
    protected $fillable = [
        'salted_hash_id',
        'ticket_id',
        'message',
        'image_name',
        'created_by'
    ];

    // Get created by user.
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Get ticket info for comment.
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
}
