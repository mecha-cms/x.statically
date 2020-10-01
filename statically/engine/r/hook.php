<?php namespace _\lot\x\statically;

function content($content) {
    extract($GLOBALS, \EXTR_SKIP);
    if (!empty($state->x->statically->optimize->{'script/style'})) {
        if (false !== \strpos($content, '<link ')) {
            // TODO
        }
        if (false !== \strpos($content, '<script ')) {
            // TODO
        }
    }
    if (false !== \strpos($content, '<img ') && !empty($state->x->statically->optimize->image)) {
        $content = \preg_replace_callback('/<img(\s[^>]*)?>/', function($m) use($state) {
            $img = new \HTML($m[0]);
            $u = $img['src'] ?? null;
            // Skip image(s) without `src` attribute
            if (!$u) {
                return $m[0];
            }
            // Remove query string URL
            $u = \explode('?', $u, 2)[0];
            // Skip unsupported image file type
            if (false === \strpos(',gif,jpeg,jpg,png,', ',' . \pathinfo($u, \PATHINFO_EXTENSION) . ',')) {
                return $m[0];
            }
            // Skip inline image(s) data
            if (0 === \strpos($u, 'data:')) {
                return $m[0];
            }
            // Resolve relative URL
            if (0 === \strpos($u, '//')) {
                $u = 'https://cdn.statically.io/img/' . \substr($u, 2);
            } else if (0 === \strpos($u, '/')) {
                $u = 'https://cdn.statically.io/img/' . \explode('://', \URL::long(\ltrim($u, '/')), 2)[1];
            } else {
                $u = 'https://cdn.statically.io/img/' . \explode('://', $u, 2)[1];
            }
            $q = $state->x->statically->{'optimize-image'}->quality ?? 0;
            $img['src'] = $u . '?f=auto' . ($q ? '&q=' . $q : "");
            return $img;
        }, $content);
    }
    return $content;
}

\Hook::set('content', __NAMESPACE__ . "\\content", 1);
