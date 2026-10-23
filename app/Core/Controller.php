<?php
namespace App\Core;

/** Base controller: rendering, JSON responses and 404s. */
abstract class Controller
{
    protected function render(string $view, array $data = []): string
    {
        if (!headers_sent()) header('Content-Type: text/html; charset=UTF-8');
        return view($view, $data);
    }

    protected function json(array $data, int $status = 200): string
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=UTF-8');
        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    protected function notFound(): string
    {
        http_response_code(404);
        return view('errors/404');
    }

    protected function wantsJson(): bool
    {
        return str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json')
            || ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'XMLHttpRequest';
    }
}
