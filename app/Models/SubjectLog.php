<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectLog extends Model
{
    use HasFactory;
    protected $table = 'subject_logs';
    protected $fillable = ['subject_id','student_id','Date','In','Out'];
}
