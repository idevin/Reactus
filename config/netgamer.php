<?php

use App\Models\Domain;

$defaultVisibiliy = [
    '0' => [
        'name' => 'Видно всем',
        'css' => 'btn-success'
    ],
    '1' => [
        'name' => 'Видно только мне',
        'css' => 'btn-danger'
    ],
    '2' => [
        'name' => 'Никому не видно',
        'css' => 'btn-warning'
    ]
];

$colorsArray = [
    [244, 67, 54],
    [233, 30, 99],
    [156, 39, 176],
    [103, 58, 183],
    [63, 81, 181],
    [33, 150, 243],
    [3, 169, 244],
    [0, 188, 212],
    [0, 150, 136],
    [76, 175, 80],
    [139, 195, 74],
    [255, 193, 7],
    [255, 152, 0],
    [255, 87, 34],
    [121, 85, 72],
    [158, 158, 158],
    [96, 125, 139],
    [251, 192, 45],
    [255, 160, 0]
];

return [
    'domain_language_limit' => 10000,
    'module_comments_limit' => 4,
    'content_domain' => 'reactus.net',
    'content_domain_dev' => 'entitus.ru',
    'local_content_domain' => env('DEFAULT_DOMAIN'),
    'registration' => [
        'bonus-via-email' => 200,
        'bonus-via-phone' => 200,
        'sms-code-length' => 5,
        'password_length' => 5
    ],
    'defaultModuleSettings' => false,
    'home' => [
        'limit' => [
            'best-of-day' => 3,
            'best-of-week' => 3,
            'best-of-month' => 3,
            'latest-comments' => 10,
            'more' => 5,
            'other' => 5,
            'sidebar' => [
                'netgamer' => 3,
                'community' => 3,
                'latest' => 3,
                'latest-other' => 3
            ]
        ]
    ],
    'pagination' => [
        'size-left-side' => 10
    ],
    'slider' => [
        'limit' => [
            'best-of-day' => 3,
            'best-of-week' => 3,
            'best-of-month' => 3
        ]
    ],
    'upload_dir' => 'uploads', // TODO Брать из энва
    'scoped_image_types' => [
        'png' => 'image/png',
        'jpe' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'gif' => 'image/gif',
        'bmp' => 'image/bmp',
        'xbmp' => 'image/x-ms-bmp',
        'wbmp' => 'image/x-windows-bmp',
        'ico' => 'image/vnd.microsoft.icon',
        'tiff' => 'image/tiff',
        'tif' => 'image/tiff',
        'svg' => ['image/svg', 'image/xvg+xml'],
        'svgz' => 'image/svg+xml',
        'webp' => 'image/webp'
    ],
    'scoped_link_types' => [
        'url' => 'application/internet-shortcut'
    ],
    'scoped_contact_types' => [
        'contact' => 'application/x-contact'
    ],
    'scoped_file_types' => [

    ],
    'scoped_document_types' => [
        'doc' => '',
        'rtf' => '',
        'xls' => '',
    ],
    'scoped_video_types' => [
        'mpg' => '',
        'mov' => ''
    ],
    'scoped_audio_types' => [
        'mp3' => '',
    ],
    /**
     * editable - время комментария в минутах, когда его можно редактировать
     * glued - время скейки комментария в минутах
     */
    'comments' => [
        'editable' => 5,
        'glued' => 5
    ],
    'group_visibility' => $defaultVisibiliy,
    'field_visibility' => $defaultVisibiliy,
    'default_group_visibility' => 2,
    'default_field_visibility' => 2,
    'user_field_group' => -1,
    'colors' => $colorsArray,
    'sections_limit' => 6,
    'articles_limit' => 10,
    'default_domains' => [
        env('DEFAULT_PERSONAL_DOMAIN') => [
            'environment' => env('DEVELOPMENT') == true ? Domain::DEVELOPMENT : Domain::PRODUCTION,
            'domain_type' => Domain::DOMAIN_TYPE_PERSONAL,
            'root' => true,
            'local' => false
        ],
        env('DEFAULT_DOMAIN') => [
            'environment' => env('DEVELOPMENT') == true ? Domain::DEVELOPMENT : Domain::PRODUCTION,
            'domain_type' => Domain::DOMAIN_TYPE_THEMATIC,
            'root' => true,
            'local' => false
        ],
        env('LOCAL_DOMAIN') => [
            'environment' => env('DEVELOPMENT') == true ? Domain::DEVELOPMENT : Domain::PRODUCTION,
            'domain_type' => Domain::DOMAIN_TYPE_THEMATIC,
            'root' => true,
            'local' => true
        ]
    ],
    'social_networks' => [
        1 => 'vkontakte',
        2 => 'facebook',
        3 => 'ok',
        4 => 'instagram',
        5 => 'mailru',
        6 => 'yandex',
        7 => 'twitter',
        8 => 'linkedin'
    ],
    'oauth1' => [
        'twitter',
        'facebook'
    ],
    'google_ads' => false,
    'yandex_ads' => false,
    'allowed_file_types' => [
        'image/webp', 'image/png', 'application/x-zip-compressed',
        'image/jpeg', 'audio/mpeg', 'application/zip',
        'image/gif', 'video/mpeg', 'application/x-compressed',
        'image/bmp', 'image/x-jps', 'application/vnd.ms-excel',
        'image/x-ms-bmp', 'audio/x-mpeg', 'audio/mpeg',
        'image/x-windows-bmp', 'application/x-msexcel',
        'image/vnd.microsoft.icon', 'application/vnd.oasis.opendocument.text',
        'image/tiff', 'application/book',
        'image/tiff', 'multipart/x-gzip', 'text/x-log',
        'image/svg+xml', 'application/drafting',
        'image/svg+xml', 'application/x-gzip',
        'application/postscript', 'application/excel',
        'application/msword', 'image/x-xbm', 'image/xbm',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/rtf', 'image/x-xbitmap', 'application/x-excel',
        'application/msword', 'application/pdf',
        'application/acad', 'video/mpeg', 'video/x-mpeg',
        'application/postscript', 'x-world/x-3dmf', 'text/vnd.abc', 'audio/aiff', 'audio/x-aiff'
    ]
];
