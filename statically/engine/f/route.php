<?php namespace _\lot\x\panel\route\__state;

function statically($_) {
    extract($GLOBALS, \EXTR_SKIP);
    // Get request only
    if ('g' !== $_['task']) {
        $_['kick'] = \strtr($url->current, ['/::' . $_['task'] . '::/' => '/::g::/']);
        return $_;
    }
    // Page offset is not allowed in the URL
    if (isset($_['i'])) {
        $_['kick'] = $url->clean;
        return $_;
    }
    $_['title'] = \S . 'Statically' . \S;
    $_['type'] = 'state';
    // Hide search form
    $_['lot']['bar']['lot'][0]['lot']['search']['skip'] = true;
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
    $_['lot']['desk']['lot']['form']['lot'][1]['title'] = \S . 'Statically' . \S;
    $_['lot']['desk']['lot']['form']['lot'][1]['description'] = 'The all-in-one solution for open source static asset delivery.';
    // $_['lot']['desk']['lot']['form']['lot'][0]['content'] = '<h2><img alt="Statically" src="' . $url . '/lot/x/statically/lot/asset/svg/statically.svg"></h2><p class="description">' . \i('The all-in-one solution for open source static asset delivery.') . '</p>';
    $data = require __DIR__ . \DS . '..' . \DS . '..' . \DS . 'state.php';
    $_['lot']['desk']['lot']['form']['lot'][1]['lot']['tabs']['lot'] = [
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
                                    'title' => 'Optimize CSS files automatically.',
                                    'value' => 1
                                ],
                                'style' => [
                                    'title' => 'Optimize JS files automatically.',
                                    'value' => 1
                                ]
                            ],
                            'stack' => 10
                        ],
                        'minify' => [
                            'title' => 'Minification',
                            'type' => 'items',
                            'block' => true,
                            'name' => 'state[minify]',
                            'value' => $data['minify'] ?? [],
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
                            'stack' => 20
                        ],
                        'image' => [
                            'name' => 'state[image][quality]',
                            'value' => $data['image']['quality'] ?? null,
                            'title' => 'Image Quality',
                            'description' => 'Set the compression rate for all images. Enter <code>0</code> or leave empty to disable.',
                            'after' => '%',
                            'hint' => 0,
                            'type' => 'number',
                            'max' => 100,
                            'min' => 0,
                            'step' => 1,
                            'stack' => 30
                        ]
                    ],
                    'stack' => 10
                ]
            ],
            'stack' => 10
        ],
        'pro' => [
            'lot' => [
                'fields' => [
                    'type' => 'fields',
                    'lot' => [
                        'token' => [
                            'name' => 'state[token]',
                            'value' => $data['token'] ?? null,
                            'description' => ['Get your own personal access token <a href="%s" target="_blank">here</a>.', 'https://statically.io/wordpress'],
                            'hint' => $data['token'] ?? \md5('statically'),
                            'pattern' => '^[a-z\\d]+$',
                            'type' => 'text',
                            'width' => true,
                            'stack' => 10
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
