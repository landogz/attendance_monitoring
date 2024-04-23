<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsApi extends Model
{
    use HasFactory;
    protected $fillable = ['api','account_id','account_name','status','credit_balance'];
}
