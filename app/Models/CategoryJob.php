<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryJob extends Model
{
    use HasFactory;
    protected $table = 'categories_job_posts';

    protected $fillable = [
        'job_post_id',
        'category_id'
    ];
}
