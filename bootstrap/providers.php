<?php

use App\Providers\AppServiceProvider;
use App\Providers\AuthServiceProvider;
use App\Providers\RouteServiceProvider;
use Aimeos\Shop\ShopServiceProvider;
use Illuminate\Broadcasting\BroadcastServiceProvider;
use Illuminate\Cache\CacheServiceProvider;
use Illuminate\Foundation\Providers\ConsoleSupportServiceProvider;
use Illuminate\Hashing\HashServiceProvider;
use Illuminate\Mail\MailServiceProvider;
use Illuminate\Notifications\NotificationServiceProvider;
use Illuminate\Pagination\PaginationServiceProvider;
use Illuminate\Queue\QueueServiceProvider;
use Illuminate\Session\SessionServiceProvider;
use Illuminate\Translation\TranslationServiceProvider;
use Illuminate\Validation\ValidationServiceProvider;
use Illuminate\View\ViewServiceProvider;

return [
    AppServiceProvider::class,
    AuthServiceProvider::class,
    RouteServiceProvider::class,
    ShopServiceProvider::class,
    BroadcastServiceProvider::class,
    CacheServiceProvider::class,
    ConsoleSupportServiceProvider::class,
    HashServiceProvider::class,
    MailServiceProvider::class,
    NotificationServiceProvider::class,
    PaginationServiceProvider::class,
    QueueServiceProvider::class,
    SessionServiceProvider::class,
    TranslationServiceProvider::class,
    ValidationServiceProvider::class,
    ViewServiceProvider::class,
];
