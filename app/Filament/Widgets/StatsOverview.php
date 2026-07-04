<?php

namespace App\Filament\Widgets;

use App\Models\EmbuddyUser;
use App\Models\Guide;
use App\Models\Event;
use App\Models\MoodEntry;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', EmbuddyUser::count())
                ->description('Registered students')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),
            Stat::make('Guides', Guide::count())
                ->description('Published articles')
                ->descriptionIcon('heroicon-m-book-open')
                ->color('info'),
            Stat::make('Events', Event::count())
                ->description('Upcoming events')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('warning'),
            Stat::make('Mood Check-ins', MoodEntry::count())
                ->description('Total entries')
                ->descriptionIcon('heroicon-m-heart')
                ->color('danger'),
        ];
    }
}
