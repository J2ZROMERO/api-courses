<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Element extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'section_id',
        'title',
        'position',
        'type',
        'url'
    ];

    protected $appends = ['status_progress'];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function elementProgress()
    {
        return $this->hasOne(ElementProgress::class);
    }

    public function scopeSectionIs($query, $section)
    {
        if (is_null($section)) {
            return $query;
        }

        return $query->where('section_id', $section);
    }

    public function getStatusProgressAttribute()
    {
        $user = Auth::user();

        if (!$user || !$user->hasRole('student')) {
            return false;
        }

        return DB::table('element_progress')
            ->where('user_id', $user->id)
            ->where('element_id', $this->id)
            ->exists();
    }
}