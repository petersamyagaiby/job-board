<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\JobPost;
use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JobPost::factory(10)->hasAttached(Category::all())->hasAttached(Technology::all())->create();
    }
}
