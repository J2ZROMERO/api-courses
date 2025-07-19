<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'course_id',
        'title',
        'position',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function scopeCourseIs($query, $course)
    {
        if (is_null($course)) {
            return $query;
        }

        return $query->where('course_id', $course);
    }
}