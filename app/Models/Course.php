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
        return $this->belongsTo(User::class, 'id', 'created_by');
    }

    public function signInUsers()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function certifications()
    {
        return $this->belongsToMany(Certification::class, 'certification_course')
        ->withTimestamps();
    }

    public function scopeUserIs($query, $user)
    {
        if (is_null($user)) {
            return $query;
        }

        return $query->where('created_by', $user);
    }
}
