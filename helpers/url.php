<?php
function route(string $page = '', array $params = []): string
{
    $url = BASE_URL . '/index.php';

    if ($page) {
        $url .= '?page=' . urlencode($page);

        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $url .= '&' . urlencode($key) . '=' . urlencode($value);
            }
        }
    }

    return $url;
}