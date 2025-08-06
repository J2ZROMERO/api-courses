<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'description',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

      public function scopeUserIs($query, $userId = null)
    {
        // If not provided, default to the authenticated user
        $userId = $userId ?? auth()->id();

        if ($userId) {
            $query->where('user_id', $userId);
        }

        return $query;
    }
    
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'certification_course')
                    ->withTimestamps(); 
    }
}
