<?php

namespace NoahWilderom\FilamentCMS\Filament\Resources\PostResource\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;
use NoahWilderom\FilamentCMS\Contracts\FilamentCMSPost;

class PostOverview extends BaseWidget {

    protected function getStats(): array
    {
        $posts = FilamentCMSPost::count();
        $published = FilamentCMSPost::published()->count();
        $drafts = FilamentCMSPost::drafts()->count();

        return [
            Stat::make('Total Posts', Number::format($posts))
                ->description('The total number of posts')
                ->icon('heroicon-o-book-open'),

            Stat::make('Published Posts', Number::format($published))
                ->description('The total number of published posts')
                ->icon('heroicon-o-check-circle'),

            Stat::make('Draft Posts', Number::format($drafts))
                ->description('The total number of draft posts')
                ->icon('heroicon-o-x-circle'),
        ];
    }

}