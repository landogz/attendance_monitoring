<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class table_logs extends Model
{
    use HasFactory;
    protected $fillable = ['Student_ID','Date','AM_in','AM_out','PM_in','PM_out'];
}
