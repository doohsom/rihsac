<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivationToken extends Model
{
    use HasFactory;
    protected $fillable = ['email', 'type', 'code'];
    public static function add($email, $type, $code)
    {
        $log = [];
        $log['email'] = $email;
        $log['type'] =  $type;
        $log['code'] = $code;
        ActivationToken::create($log);
    }

    public function scopeEmail($query)
    {
        return $query->where('type','EMAIL_TOKEN');
    }

    public function scopeSms($query)
    {
        return $query->where('type','PHONE_TOKEN');
    }
}
