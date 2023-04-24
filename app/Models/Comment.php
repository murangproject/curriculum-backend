<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'curriculum_id',
        'content',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function curriculum() {
        return $this->belongsTo(Curriculum::class, 'curriculum_id');
    }
}
