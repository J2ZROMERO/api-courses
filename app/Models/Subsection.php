<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subsection extends Model
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
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function elements()
    {
        return $this->hasMany(Element::class);
    }

    public function scopeSectionIs($query, $section)
    {
        if (is_null($section)) {
            return $query;
        }

        return $query->where('section_id', $section);
    }
}
