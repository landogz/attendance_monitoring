<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    use HasFactory;

    // Define the table name (optional if it's plural of model name)
    protected $table = 'login_logs';

    // Specify which fields are fillable
    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
        'login_time',
    ];

    // Cast 'login_time' to a datetime object
    protected $casts = [
        'login_time' => 'datetime',
    ];

    /**
     * Relationship to the User model
     * Each login log belongs to a user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}