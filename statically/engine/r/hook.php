<?php namespace _\lot\x\statically;

function content($content) {
    extract($GLOBALS, \EXTR_SKIP);
    // Resolve relative URL and convert it to CDN
    $resolve = function($path, $key, $q = "") use($url) {
        // Skip inline data
        if (0 === \strpos($path, 'data:')) {
            return $path;
        }
        if (0 === \strpos($path, '//')) {
            return 'https://cdn.statically.io/' . $key . \substr($path, 2) . $q;
        }
        if (0 === \strpos($path, '/')) {
            return 'https://cdn.statically.io/' . $key . \explode('://', $url . $path, 2)[1] . $q;
        }
        return 'https://cdn.statically.io/' . $key . \explode('://', $path, 2)[1] . $q;
    };
    if (false !== \strpos($content, '<link ') && !empty($state->x->statically->f->style)) {
        $content = \preg_replace_callback('/<link(\s[^>]*)?>/', function($m) use($resolve) {
            // Skip link(s) without `href` and `rel` attribute
            if (false === \strpos($m[0], 'href=') || false === \strpos($m[0], 'rel=')) {
                return $m[0];
            }
            $link = new \HTML($m[0]);
            // Make sure it is a style sheet
            if ('stylesheet' !== $link['rel']) {
                return $m[0];
            }
            // Skip link(s) without `href` attribute
            if (!$href = $link['href']) {
                return $m[0];
            }
            // Make sure it ends with `.css`
            if ('.css' !== \substr($href, -4)) {
                return $m[0];
            }
            $link['href'] = $resolve($href, 'css');
            return $link;
        }, $content);
    }
    if (false !== \strpos($content, '<script ') && !empty($state->x->statically->f->script)) {
        $content = \preg_replace_callback('/<script(\s[^>]*)?>/', function($m) use($resolve) {
            // Skip script(s) without `src` attribute
            if (false === \strpos($m[0], 'src=')) {
                return $m[0];
            }
            $script = new \HTML($m[0]);
            // Skip script(s) without `src` attribute
            if (!$src = $script['src']) {
                return $m[0];
            }
            // Make sure it ends with `.js`
            if ('.js' !== \substr($src, -3)) {
                return $m[0];
            }
            $script['src'] = $resolve($src, 'js');
            return $script;
        }, $content);
    }
    if (false !== \strpos($content, '<img ') && !empty($state->x->statically->f->image)) {
        $content = \preg_replace_callback('/<img(\s[^>]*)?>/', function($m) use($resolve, $state) {
            // Skip image(s) without `src` attribute
            if (false === \strpos($m[1], 'src=')) {
                return $m[0];
            }
            $img = new \HTML($m[0]);
            // Skip image(s) without `src` attribute
            if (!$src = $img['src']) {
                return $m[0];
            }
            // Remove query string URL
            $src = \explode('?', $src, 2)[0];
            // Skip unsupported image file type
            if (false === \strpos(',gif,jpeg,jpg,png,', ',' . \pathinfo($src, \PATHINFO_EXTENSION) . ',')) {
                return $m[0];
            }
            $q = (int) ($state->x->statically->image->quality ?? 0);
            $img['src'] = $resolve($src, 'img', '?f=auto' . ($q ? '&q=' . $q : ""));
            return $img;
        }, $content);
    }
    return $content;
}

\Hook::set('content', __NAMESPACE__ . "\\content", 1);
