<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function scopeSectionIs($query, $section)
    {
        if (is_null($section)) {
            return $query;
        }

        return $query->where('section_id', $section);
    }
}
