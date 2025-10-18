<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StartupDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'industry',
        'current_stage',
        'team_size',
        'monthly_revenue',
        'funding_goal',
        'partnership_timeline',
        'subject',
        'about_startup',
        'pitch_deck'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
