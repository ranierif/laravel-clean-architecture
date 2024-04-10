<?php

return [
    'result_stores' => [
        Spatie\Health\ResultStores\EloquentHealthResultStore::class => [
            'connection' => env('HEALTH_DB_CONNECTION', env('DB_CONNECTION')),
            'model' => Spatie\Health\Models\HealthCheckResultHistoryItem::class,
            'keep_history_for_days' => 5,
        ],
    ],
    'notifications' => [
        'enabled' => false,
        'notifications' => [
            Spatie\Health\Notifications\CheckFailedNotification::class => ['mail'],
        ],
        'notifiable' => Spatie\Health\Notifications\Notifiable::class,
        'throttle_notifications_for_minutes' => 60,
        'throttle_notifications_key' => 'health:latestNotificationSentAt:',
        'mail' => [
            'to' => 'your@example.com',
            'from' => [
                'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
                'name' => env('MAIL_FROM_NAME', 'Example'),
            ],
        ],
        'slack' => [
            'webhook_url' => env('HEALTH_SLACK_WEBHOOK_URL', ''),
            'channel' => null,
            'username' => null,
            'icon' => null,
        ],
    ],
    'oh_dear_endpoint' => [
        'enabled' => false,
        'always_send_fresh_results' => true,
        'secret' => env('OH_DEAR_HEALTH_CHECK_SECRET'),
        'url' => '/oh-dear-health-check-results',
    ],
    'theme' => 'light',
    'silence_health_queue_job' => true,
];
