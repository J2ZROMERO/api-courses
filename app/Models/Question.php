<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'element_id',
        'question'
    ];

    public function element()
    {
        return $this->belongsTo(Element::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function scopeElementIs($query, $element)
    {
        if (is_null($element)) {
            return $query;
        }

        return $query->where('element_id', $element);
    }
}
