<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $primaryKey = 'code';
    public $incrementing = false;

    protected $fillable = [
        'code',
        'title',
        'description',
        'units',
        'hours',
        'prerequisite_code',
        'corequisite_code',
        'is_deleted'
    ];

    public $timestamps = true;

    public function prerequisite() {
        return $this->belongsTo(Subject::class, 'prerequisite_code', 'code');
    }

    public function corequisite() {
        return $this->belongsTo(Subject::class, 'corequisite_code', 'code');
    }

    public function curriculums() {
        return $this->belongsToMany(Curriculum::class, 'curriculum_subjects');
    }
}
