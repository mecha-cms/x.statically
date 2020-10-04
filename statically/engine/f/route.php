<?php namespace _\lot\x\panel\route\__state;

function statically($_) {
    extract($GLOBALS, \EXTR_SKIP);
    if ('g' !== $_['task']) {
        // TODO: Reject!
    }
    if ('POST' === $_SERVER['REQUEST_METHOD']) {
        // Filling out the custom CDN URL requires you to fill out the API key too!
        if (!empty($_['form']['state']['pro'][0]) && empty($_['form']['state']['pro'][1])) {
            $_['alert']['error'][] = ['Please fill out the %s field.', ['API Key']];
        }
    }
    $_['layout'] = 'state';
    // Hide search form
    $_['lot']['bar']['lot'][0]['lot']['search']['hidden'] = true;
    // This field was added to remove the file name error message
    // The value of this field does not determine anything
    $_['lot']['desk']['lot']['form']['lot']['fields']['lot']['name'] = [
        'name' => 'file[name]',
        'type' => 'hidden',
        'value' => 'state.php'
    ];
    // This field determine the original extension state location
    $_['lot']['desk']['lot']['form']['lot']['fields']['lot']['path'] = [
        'name' => 'path',
        'type' => 'hidden',
        'value' => 'x/statically/state.php'
    ];
    // $_['lot']['desk']['lot']['form']['lot'][1]['title'] = 'Statically';
    // $_['lot']['desk']['lot']['form']['lot'][1]['description'] = 'The all-in-one solution for open source static asset delivery.';
    $_['lot']['desk']['lot']['form']['lot'][0]['content'] = '<h2><img alt="Statically" src="' . $url . '/lot/x/statically/lot/asset/svg/statically.svg"></h2><p class="description">' . \i('The all-in-one solution for open source static asset delivery.') . '</p>';
    // Fix #13 <https://stackoverflow.com/a/53893947/1163000>
    $fresh = function($path) {
        if (\function_exists("\\opcache_invalidate") && \strlen((string) \ini_get('opcache.restrict_api')) < 1) {
            \opcache_invalidate($path, true);
        } else if (function_exists("\\apc_compile_file")) {
            \apc_compile_file($path);
        }
        return $path;
    };
    $data = require $fresh(__DIR__ . \DS . '..' . \DS . '..' . \DS . 'state.php');
    $_['lot']['desk']['lot']['form']['lot'][1]['lot']['tabs']['lot'] = [
        'pro' => [
            'lot' => [
                'fields' => [
                    'type' => 'fields',
                    'lot' => [
                        0 => [
                            'name' => 'state[pro][0]',
                            'value' => $data['pro'][0] ?? null,
                            'title' => 'Base CDN URL',
                            'description' => 'Enter the CDN URL without trailing slash.',
                            'type' => 'link',
                            'alt' => 'https://cdn.statically.io/sites/' . $url->host,
                            'width' => true,
                            'stack' => 10
                        ],
                        1 => [
                            'name' => 'state[pro][1]',
                            'value' => $data['pro'][1] ?? null,
                            'title' => 'API Key',
                            'description' => 'Statically API key to make this extension working. Never share it to anybody! Treat this API key as a password &rarr; <a href="https://statically.io/wordpress" rel="nofollow" target="_blank">get one here</a>',
                            'type' => 'text',
                            'width' => true,
                            'stack' => 20
                        ]
                    ],
                    'stack' => 10
                ]
            ],
            'stack' => 10
        ],
        'free' => [
            'lot' => [
                'fields' => [
                    'type' => 'fields',
                    'lot' => [
                        'f' => [
                            'name' => 'state[f]',
                            'value' => $data['f'] ?? [],
                            'title' => 'Features',
                            'type' => 'items',
                            'block' => true,
                            'lot' => [
                                'image' => [
                                    'title' => 'Optimize image files automatically.',
                                    'value' => 1
                                ],
                                'script' => [
                                    'title' => 'Minify CSS files automatically.',
                                    'value' => 1
                                ],
                                'style' => [
                                    'title' => 'Minify JS files automatically.',
                                    'value' => 1
                                ]
                            ],
                            'stack' => 10
                        ],
                        'image' => [
                            'name' => 'state[image][quality]',
                            'value' => $data['image']['quality'] ?? null,
                            'title' => 'Image Quality',
                            'description' => 'Set the compression rate for all images. Enter <code>0</code> or leave empty to disable.',
                            'after' => '%',
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
