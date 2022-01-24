<?php

namespace SmarterCoding\WpPlus\Helpers;

use BoxyBird\Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class Response
{
    public function render(string $component, $props = [])
    {
        ob_start();
        Inertia::render($component, $props);
        $content = ob_get_clean();

        return new SymfonyResponse($content, SymfonyResponse::HTTP_OK, [
            'content-type' => 'text/html'
        ]);
    }

    public function html($html)
    {
        return new SymfonyResponse($html, SymfonyResponse::HTTP_OK, [
            'content-type' => 'text/html'
        ]);
    }

    public function json($content)
    {
        $content = json_encode($content);

        return new SymfonyResponse($content, SymfonyResponse::HTTP_OK, [
            'content-type' => 'application/json'
        ]);
    }
}
