<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElementProgress extends Model
{
    protected $table = 'element_progress';
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'element_id',
        'completed',
        'completed'
    ];

    public function element()
    {
        return $this->belongsTo(Element::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeUserIs($query, $user)
    {
        if (is_null($user)) {
            return $query;
        }

        return $query->where('user_id', $user);
    }

    public function scopeElementIs($query, $element)
    {
        if (is_null($element)) {
            return $query;
        }

        return $query->where('element_id', $element);
    }

    public function scopeCompletedIs($query, $status)
    {
        if (is_null($status)) {
            return $query;
        }

        return $query->where('completed', $status);
    }
}
