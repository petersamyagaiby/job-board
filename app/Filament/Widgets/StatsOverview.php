<?php

namespace App\Filament\Widgets;

use App\Models\Admin;
use App\Models\Application;
use App\Models\Candidate;
use App\Models\Category;
use App\Models\City;
use App\Models\Company;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\JobPost;
use App\Models\Technology;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $users = User::count();
        $company = User::query()->where('type', 'company')->count();
        $admins =User::query()->where('type', 'admin')->count();
        $candidates = User::query()->where('type', 'candidate')->count();
        $postJob = JobPost::count();
        $applciations = Application::count();
        $categories = Category::count();
        $technologies = Technology::count();
        $cities = City::count();
        return [

            Stat::make('Users', $users)->description('Admins:' . $admins ."\n" .' Candidates:' . $candidates ."\n" .  ' Companies:' . $company)->descriptionIcon('heroicon-o-user-group')->color('success'),
            Stat::make('Job Posts', $postJob),
            Stat::make('Applications', $applciations),
            // Stat::make('Companies', $company),
            // Stat::make('Candidates', $candidates),
            // Stat::make('Admins', $admins),
            Stat::make('Categories', $categories),
            Stat::make('Technologies', $technologies),
            Stat::make('Cities', $cities),
        ];
    }
}
