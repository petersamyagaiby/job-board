<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Technology extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
    ];

    public function jobPosts(): BelongsToMany
    {
        return $this->belongsToMany(JobPost::class, 'technologies_job_posts');
    }
}
