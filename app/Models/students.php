<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class students extends Model
{
    use HasFactory;
    protected $fillable = ['Student_Number','Name','Email','Parent_Name','Parent_Number','Grade','Address','Image'];
}
