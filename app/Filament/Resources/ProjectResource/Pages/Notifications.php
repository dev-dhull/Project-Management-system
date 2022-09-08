<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use Filament\Resources\Pages\Page;

class Notifications extends Page
{
    protected static string $resource = ProjectResource::class;

    protected static string $view = 'filament.resources.project-resource.pages.notifications';

    protected static function shouldRegisterNavigation(): bool
{
    return auth()->user()->canManageNotifications();
}
}