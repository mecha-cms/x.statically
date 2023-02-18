<?php namespace x\statically;

function content($content) {
    // Ignore offline site
    if (!$content || \in_array(\ip(), ['127.0.0.1', '::1'])) {
        return $content;
    }
    \extract($GLOBALS, \EXTR_SKIP);
    // Resolve relative URL and convert it to CDN
    $resolve = static function (string $path, string $key, string $query) use ($state, $url) {
        // Skip data URI
        if (0 === \strpos($path, 'data:')) {
            return $path;
        }
        $prefix = ($state->x->statically->base ?? "") . '/' . $key;
        $query = $query ? '?' . $query : "";
        if (0 === \strpos($path, '//')) {
            return $prefix . '/' . \substr($path, 2) . $query;
        }
        if (0 === \strpos($path, '/')) {
            return $prefix . $path . $query;
        }
        return $prefix . '/' . \explode('://', $path, 2)[1] . $query;
    };
    if (false !== \strpos($content, '<img ') && !empty($state->x->statically->service->picture)) {
        $content = \preg_replace_callback('/<img(\s[^>]*)?>/', function ($m) use ($resolve, $state) {
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
            [$path, $query] = \explode('?', $src, 2);
            // Skip unsupported image file type
            if (false === \strpos(',gif,jpeg,jpg,png,svg,', ',' . \pathinfo($path, \PATHINFO_EXTENSION) . ',')) {
                return $m[0];
            }
            $f = ($state->x->statically->picture->format ?? false);
            $q = (int) ($state->x->statically->picture->quality ?? 0);
            [$query, $hash] = \array_replace(["", ""], \explode('#', $query, 2));
            $query = \To::query(\array_replace_recursive((array) \From::query($query), ['f' => false === $f ? null : $f, 'q' => $q]));
            $img['src'] = $resolve($src, 'img', $query . ("" !== $hash ? '#' . $hash : ""));
            return (string) $img;
        }, $content);
    }
    if (false !== \strpos($content, '</script>') && !empty($state->x->statically->service->script)) {
        $content = \preg_replace_callback('/<script(\s[^>]*)?>/', static function ($m) use ($resolve, $state) {
            // Skip script(s) without `src` attribute
            if (false === \strpos($m[0], 'src=')) {
                return $m[0];
            }
            $script = new \HTML($m[0]);
            // Skip script(s) without `src` attribute
            if (!$src = $script['src']) {
                return $m[0];
            }
            [$path, $query] = \explode('?', $src, 2);
            // Make sure it ends with `.js`
            if ('.js' !== \substr($src, -3)) {
                return $m[0];
            }
            if ('.min.js' !== \substr($src, -7) && !empty($state->x->statically->minify->script)) {
                $path = \strtr(\dirname($path) . '/' . \basename($path, '.js') . '.min.js', [\D => '/']);
            }
            $script['src'] = $resolve($src, 'js', $query);
            return (string) $script;
        }, $content);
    }
    if (false !== \strpos($content, '<link ') && !empty($state->x->statically->service->style)) {
        $content = \preg_replace_callback('/<link(\s[^>]*)?>/', static function ($m) use ($resolve, $state) {
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
            [$path, $query] = \explode('?', $href, 2);
            // Make sure it ends with `.css`
            if ('.css' !== \substr($path, -4)) {
                return $m[0];
            }
            if ('.min.css' !== \substr($path, -8) && !empty($state->x->statically->minify->style)) {
                $path = \strtr(\dirname($path) . '/' . \basename($path, '.css') . '.min.css', [\D => '/']);
            }
            $link['href'] = $resolve($path, 'css', $query);
            return (string) $link;
        }, $content);
    }
    return $content;
}

\Hook::set('content', __NAMESPACE__ . "\\content", 40);