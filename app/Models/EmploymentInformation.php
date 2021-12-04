<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmploymentInformation extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'uuid', 'employment_status', 'number_of_dependents',
                           'monthly_income', 'monthly_savings', 'monthly_expense'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function employment_status()
    {
        return $this->hasMany(Setting::class, 'employment_status');
    }
}
