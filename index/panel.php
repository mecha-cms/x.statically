<?php

// Add menu that links to the state page
$_['lot']['bar']['lot'][1]['lot']['statically'] = [
    'current' => 'x/statically/state.php' === $_['path'],
    'icon' => 'M11.5,20L16.36,10.27H13V4L8,13.73H11.5V20M12,2C14.75,2 17.1,3 19.05,4.95C21,6.9 22,9.25 22,12C22,14.75 21,17.1 19.05,19.05C17.1,21 14.75,22 12,22C9.25,22 6.9,21 4.95,19.05C3,17.1 2,14.75 2,12C2,9.25 3,6.9 4.95,4.95C6.9,3 9.25,2 12,2Z',
    'stack' => 20,
    'url' => [
        'hash' => null,
        'part' => 0,
        'path' => 'x/statically/state.php',
        'query' => null,
        'task' => 'get'
    ]
];

if ('x/statically/state.php' === $_['path'] && !array_key_exists('type', $_GET) && !isset($_['type'])) {
    $_['type'] = 'state';
    if (isset($_['lot']['desk']['lot']['form']['lot'][1]['lot']['tabs']['lot'])) {
        $data = require __DIR__ . D . '..' . D . 'state.php';
        $_['lot']['desk']['lot']['form']['lot'][1]['title'] = \S . 'Statically' . \S;
        $_['lot']['desk']['lot']['form']['lot'][1]['description'] = 'The fast and easy way to make your web sites load faster.';
        $_['lot']['desk']['lot']['form']['lot'][1]['lot']['tabs']['lot']['file']['skip'] = true; // Hide the “File” tab
        $_['lot']['desk']['lot']['form']['lot'][1]['lot']['tabs']['lot']['free'] = [
            'lot' => [
                'fields' => [
                    'type' => 'fields',
                    'lot' => [
                        'base' => [
                            'name' => 'state[base]',
                            'type' => 'link',
                            'value' => $data['base'] ?? null,
                            'vital' => true,
                            'width' => true
                        ],
                        'service' => [
                            'flex' => false,
                            'lot' => [
                                'image' => [
                                    'title' => 'Optimize image files automatically.',
                                    'value' => 1
                                ],
                                'script' => [
                                    'title' => 'Optimize CSS files automatically.',
                                    'value' => 1
                                ],
                                'style' => [
                                    'title' => 'Optimize JS files automatically.',
                                    'value' => 1
                                ]
                            ],
                            'name' => 'state[service]',
                            'stack' => 10,
                            'title' => 'Services',
                            'type' => 'items',
                            'values' => $data['service'] ?? []
                        ],
                        'minify' => [
                            'flex' => false,
                            'lot' => [
                                'script' => [
                                    'title' => 'Minify JS files automatically.',
                                    'value' => 1
                                ],
                                'style' => [
                                    'title' => 'Minify CSS files automatically.',
                                    'value' => 1
                                ]
                            ],
                            'name' => 'state[minify]',
                            'stack' => 20,
                            'title' => 'Minification',
                            'type' => 'items',
                            'values' => $data['minify'] ?? []
                        ],
                        'image-quality' => [
                            'active' => !empty($data['service']['image']),
                            'description' => 'Set the compression rate for all images. Enter <code>0</code> or leave empty to disable.',
                            'hint' => 0,
                            'max' => 100,
                            'min' => 0,
                            'name' => 'state[image][quality]',
                            'stack' => 30,
                            'step' => 1,
                            'title' => 'Image Quality',
                            'type' => 'number',
                            'unit' => '%',
                            'value' => $data['image']['quality'] ?? null
                        ],
                        'image-format' => [
                            'active' => !empty($data['service']['image']),
                            'description' => ['Convert images to %s on the fly?', '<a href="https://en.wikipedia.org/wiki/WebP" rel="nofollow" target="_blank">WebP</a>'],
                            'lot' => [
                                'auto' => 'Automatic',
                                'false' => 'No',
                                'webp' => 'Yes (Force)'
                            ],
                            'name' => 'state[image][format]',
                            'stack' => 40,
                            'title' => 'WebP',
                            'type' => 'item',
                            'value' => s($data['image']['format'] ?? null)
                        ]
                    ],
                    'stack' => 10
                ]
            ],
            'stack' => 10
        ];
        $_['lot']['desk']['lot']['form']['lot'][1]['lot']['tabs']['lot']['pro'] = [
            'lot' => [
                'fields' => [
                    'type' => 'fields',
                    'lot' => [
                        'token' => [
                            'description' => ['Get your own personal access token <a href="%s" target="_blank">here</a>.', 'https://statically.io/wordpress'],
                            'hint' => $data['token'] ?? \md5('statically'),
                            'name' => 'state[token]',
                            'pattern' => '^[a-z\\d]+$',
                            'stack' => 10,
                            'type' => 'text',
                            'value' => $data['token'] ?? null,
                            'width' => true
                        ]
                    ],
                    'stack' => 10
                ]
            ],
            'stack' => 20
        ];
    }
}