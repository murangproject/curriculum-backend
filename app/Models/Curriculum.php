<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'title',
        'description',
        'is_deleted'
    ];

    public function subjects() {
        return $this->belongsToMany(Subject::class, 'curriculum_subjects');
    }

    public function department() {
        return $this->belongsTo(Department::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class, 'curriculum_id');
    }
}
