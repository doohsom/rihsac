<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'type', 'message'];

    public static function add($message, $type, $user_id)
    {
        //login, register, password, transaction, verification,
        $log = [];
        $log['message'] = $message;
        $log['user_id'] =  $user_id;
        $log['type'] = $type;
        ActivityLog::create($log);
    }
}
