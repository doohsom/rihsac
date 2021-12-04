<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuarantorInformation extends Model
{
    use HasFactory;
    protected $fillable = [ 'user_id', 'uuid', 'firstname', 'lastname', 'email', 'phone_number', 'relationship'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function relationship()
    {
        return $this->hasMany(Setting::class, 'relationship');
    }
}
