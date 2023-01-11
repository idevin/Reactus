<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    |
    | Intervention Image supports "GD Library" and "Imagick" to process images
    | internally. You may choose one of them according to your PHP
    | configuration. By default PHP's "GD Library" implementation is used.
    |
    | Supported: "gd", "imagick"
    |
    */

    'driver' => 'gd',
    'thumb' => [
        'site_header' => [
            [
                'size' => [1920, 1080],
                'generateImage' => true,
                'watermark' => false,
                'text' => false,
                'color' => null
            ],
            [
                'size' => [70, 70],
                'generateImage' => true,
                'watermark' => true,
                'text' => true,
                'color' => null
            ]
        ],
        'site_preview' => [
            [
                'size' => [280, 157],
                'generateImage' => true,
                'watermark' => true,
                'text' => true,
                'color' => null
            ],
            [
                'size' => [70, 70],
                'generateImage' => true,
                'watermark' => true,
                'text' => true,
                'color' => null
            ]
        ],
        'site_logo' => [
            [
                'size' => [560, 315],
                'generateImage' => false,
                'watermark' => false,
                'text' => false,
                'color' => null
            ],
            [
                'size' => [280, 157],
                'generateImage' => true,
                'watermark' => true,
                'text' => true,
                'color' => null
            ],
            [
                'size' => [70, 70],
                'generateImage' => true,
                'watermark' => false,
                'text' => true,
                'color' => null
            ],
        ],
        'favicon' => [
            [
                'size' => [512, 512],
                'generateImage' => true,
                'watermark' => true,
                'text' => true,
                'color' => null
            ],
            [
                'size' => [128, 128],
                'generateImage' => true,
                'watermark' => true,
                'text' => true,
                'color' => null
            ],
            [
                'size' => [32, 32],
                'generateImage' => true,
                'watermark' => true,
                'text' => true,
                'color' => null
            ]
        ],
        'article_slider' => [
            [
                'size' => [1920, 1080],
                'generateImage' => true,
                'watermark' => false,
                'text' => false,
                'color' => null
            ],
            [
                'size' => [280, 157],
                'generateImage' => true,
                'watermark' => true,
                'text' => true,
                'color' => null
            ],
        ],
        'section' => [
            [
                'size' => [1920, 1080],
                'generateImage' => true,
                'watermark' => false,
                'text' => false,
                'color' => null
            ],
            [
                'size' => [280, 157],
                'generateImage' => true,
                'watermark' => true,
                'text' => true,
                'color' => null
            ],
            [
                'size' => [70, 70],
                'generateImage' => true,
                'watermark' => false,
                'text' => true,
                'color' => null
            ],
        ],
        'storage' => [
            [
                'size' => [1920, 1080],
                'generateImage' => true,
                'watermark' => false,
                'text' => false,
                'color' => null
            ],
            [
                'size' => [280, 157],
                'generateImage' => true,
                'watermark' => false,
                'text' => false,
                'color' => null
            ],
            [
                'size' => [180, 180],
                'generateImage' => true,
                'watermark' => false,
                'text' => false,
                'color' => null
            ],
            [
                'size' => [150, 150],
                'generateImage' => true,
                'watermark' => false,
                'text' => false,
                'color' => null
            ],
            [
                'size' => [70, 70],
                'generateImage' => true,
                'watermark' => false,
                'text' => false,
                'color' => null
            ],
            [
                'size' => [512, 512],
                'generateImage' => true,
                'watermark' => true,
                'text' => true,
                'color' => null
            ],
            [
                'size' => [128, 128],
                'generateImage' => true,
                'watermark' => true,
                'text' => true,
                'color' => null
            ],
            [
                'size' => [32, 32],
                'generateImage' => true,
                'watermark' => true,
                'text' => true,
                'color' => null
            ]
        ],
        'menu' => [
            [
                'size' => [70, 70],
                'generateImage' => true,
                'watermark' => false,
                'text' => true,
                'color' => null
            ]
        ],
        'slider' => [
            [
                'size' => [1920, 1080],
                'generateImage' => true,
                'watermark' => false,
                'text' => false,
                'color' => null
            ],
            [
                'size' => [710, 400],
                'generateImage' => true,
                'watermark' => false,
                'text' => false,
                'color' => null
            ],
            [
                'size' => [200, 100],
                'generateImage' => true,
                'watermark' => false,
                'text' => false,
                'color' => null
            ],
            [
                'size' => [70, 70],
                'generateImage' => true,
                'watermark' => false,
                'text' => true,
                'color' => null
            ]
        ],
        'avatar' => [
            [
                'size' => [240, 240],
                'generateImage' => true,
                'watermark' => false,
                'text' => true,
                'color' => null
            ],
            [
                'size' => [150, 150],
                'generateImage' => true,
                'watermark' => false,
                'text' => true,
                'color' => null
            ],
            [
                'size' => [70, 70],
                'generateImage' => true,
                'watermark' => false,
                'text' => true,
                'color' => null
            ],
            [
                'size' => [40, 40],
                'generateImage' => true,
                'watermark' => false,
                'text' => true,
                'color' => null
            ]
        ],
        'content_slider' => [
            [
                'size' => [1920, 1080],
                'generateImage' => true,
                'watermark' => false,
                'text' => false,
                'color' => null
            ],
            [
                'size' => [280, 157],
                'generateImage' => true,
                'watermark' => false,
                'text' => true,
                'color' => null
            ]
        ]
    ]
);
