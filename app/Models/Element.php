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
        'subsection_id',
        'title',
        'position',
        'type',
        'url'
    ];

    protected $appends = ['status_progress', 'unlock'];

    public function subsection()
    {
        return $this->belongsTo(Subsection::class);
    }

    public function elementProgress()
    {
        return $this->hasOne(ElementProgress::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function scopeSubsectionIs($query, $section)
    {
        if (is_null($section)) {
            return $query;
        }

        return $query->where('subsection_id', $section);
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

    public function getUnlockAttribute()
    {
        $user = Auth::user();

        if (!$user || !$user->hasRole('student')) {
            return false;
        }

        // Obtener el curso desde la sección
        $section = $this->section;
        if (!$section || !$section->course) {
            return false;
        }

        $course = $section->course;

        // Obtener todos los elementos ordenados por sección y por posición
        $elements = $course->sections()
            ->with(['elements' => function ($q) {
                $q->orderBy('position');
            }])
            ->orderBy('position')
            ->get()
            ->flatMap(function ($section) {
                return $section->elements;
            });

        // Buscar la posición del elemento actual
        $index = $elements->search(function ($e) {
            return $e->id === $this->id;
        });

        if ($index === false) {
            return false;
        }

        // Si es el primer elemento del curso
        if ($index === 0) {
            return true;
        }

        $previous1 = $elements[$index - 1] ?? null;
        $previous2 = $elements[$index - 2] ?? null;

        // Si alguno de los dos anteriores fue completado
        return ($previous1 && $previous1->status_progress) || ($previous2 && $previous2->status_progress);
    }
}