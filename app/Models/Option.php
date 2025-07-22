<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'question_id',
        'option',
        'is_correct'
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function scopeQuestionIs($query, $question)
    {
        if (is_null($question)) {
            return $query;
        }

        return $query->where('question_id', $question);
    }
}