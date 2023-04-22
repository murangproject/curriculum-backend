<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'title',
        'lab_unit',
        'lec_unit',
        'description',
        'syllabus',
        'deleted'
    ];

    public function head() {
        return $this->hasOne(User::class, 'head_id');
    }

    public function prerequisites() {
        return $this->belongsToMany(SubjectData::class, 'prerequisite_id');
    }

    public function corequisites() {
        return $this->belongsToMany(SubjectData::class, 'corequisite_id');
    }
}
