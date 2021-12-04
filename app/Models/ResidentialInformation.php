<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResidentialInformation extends Model
{
    use HasFactory;
    protected $fillable = ['uuid', 'user_id', 'apartment_type', 'ownership'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function apartment_type()
    {
        return $this->hasMany(Setting::class, 'apartment_type');
    }

    public function ownership()
    {
        return $this->hasMany(Setting::class, 'ownership');
    }
}
