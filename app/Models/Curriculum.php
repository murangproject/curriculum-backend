<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'is_deleted'
    ];

    public function subjects() {
        return $this->belongsToMany(Subject::class, 'curriculum_subjects');
    }
}
