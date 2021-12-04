<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankInformation extends Model
{
    use HasFactory;
    protected $fillable = ['uuid', 'user_id', 'bank_name', 'account_name', 'account_number', 'bvn'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
