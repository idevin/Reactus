<?php

use App\Formatters\JsonFormatter;
use Monolog\Handler\StreamHandler;

return [
    'default' => env('LOG_CHANNEL', 'stderr'),
    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['stderr'],
            'level' => env('LOG_LEVEL', 'debug'),
        ],
        'single' => [
            'name' => 'single',
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'notice'),
            'permission' => 0777,
            'days' => 666
        ],
        'syslog' => [
            'driver' => 'syslog',
            'level' => env('LOG_LEVEL', 'notice'),
        ],
        'stdout' => [
            'driver' => 'monolog',
            'name' => 'monolog',
            'handler' => StreamHandler::class,
            'with' => [
                'stream' => 'php://stdout',
                'level' => env('LOG_LEVEL', 'notice'),
            ],
            'formatter' => JsonFormatter::class,
            'formatter_with' => [
                'ignoreEmptyContextAndExtra' => true,
                'includeStacktraces' => true,
                'appendNewline' => true,
            ]
        ],
        'stderr' => [
            'name' => 'monolog',
            'driver' => 'monolog',
            'handler' => StreamHandler::class,
            'with' => [
                'stream' => 'php://stderr',
                'level' => env('LOG_LEVEL', 'notice'),
            ],
            'formatter' => JsonFormatter::class,
            'formatter_with' => [
                'ignoreEmptyContextAndExtra' => true,
                'includeStacktraces' => true,
                'appendNewline' => true,
            ]
        ],
        'slack' => [
            'driver' => 'slack',
            'url' => env('SLACK_URL'),
            'username' => 'Logger',
            'emoji' => ':boom:',
            'level' => env('LOG_LEVEL', 'notice'),
        ],
    ]
];
