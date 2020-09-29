<?php namespace _\lot\x\panel\route;

function __statically($_) {
    extract($GLOBALS, \EXTR_SKIP);
    $_['layout'] = 'state';
    $_['lot']['desk']['lot']['form']['lot'][1]['title'] = 'Statically';
    $_['lot']['desk']['lot']['form']['lot'][1]['description'] = 'Statically is a free and public Content Delivery Network (CDN) for static assets.';
    $_['lot']['desk']['lot']['form']['lot'][1]['lot']['tabs']['lot'] = [
        'general' => [
            'lot' => [
                'fields' => [
                    'type' => 'fields',
                    'lot' => [
                        'base' => [
                            'title' => 'Base URL',
                            'description' => 'Enter the CDN URL without trailing slash. The format is <code>***</code>',
                            'type' => 'text',
                            'alt' => 'https://cdn.statically.io/sites/' . $url->host,
                            'width' => true,
                            'stack' => 10
                        ],
                        'key' => [
                            'title' => 'API Key',
                            'description' => 'Statically API key to make this extension working.',
                            'type' => 'pass',
                            'alt' => sha1(__FILE__),
                            'width' => true,
                            'stack' => 20
                        ]
                    ],
                    'stack' => 10
                ]
            ],
            'stack' => 10
        ],
        'speed' => [
            'lot' => [
                'fields' => [
                    'type' => 'fields',
                    'lot' => [
                        'minify' => [
                            'type' => 'items',
                            'block' => true,
                            'lot' => [
                                'minify' => 'Minify CSS and JavaScript files automatically.',
                                'image' => 'Optimize image files automatically.'
                            ],
                            'stack' => 10
                        ],
                        'quality' => [
                            'title' => 'Image Quality',
                            'description' => 'Set the compression rate for all images. Enter <code>0</code> to disable.',
                            'alt' => 0,
                            'type' => 'number',
                            'max' => 100,
                            'min' => 0,
                            'step' => 1,
                            'stack' => 20
                        ]
                    ],
                    'stack' => 10
                ]
            ],
            'stack' => 20
        ]
    ];
    return $_;
}
