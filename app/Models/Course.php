<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'description',
        'created_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeUserIs($query, $user)
    {
        if (is_null($user)) {
            return $query;
        }

        return $query->where('created_by', $user);
    }
}
