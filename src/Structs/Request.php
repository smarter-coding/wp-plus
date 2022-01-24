<?php

namespace SmarterCoding\WpPlus\Structs;

use Illuminate\Support\MessageBag;
use Illuminate\Validation\Factory;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class Request extends SymfonyRequest
{
    private $routeParameters;

    public function setRouteParameters($parameters)
    {
        $this->routeParameters = $parameters;
    }

    public function errors(): MessageBag
    {
        return session()->get('errors') ?? new MessageBag();
    }

    public function route($key)
    {
        if (!isset($this->routeParameters[$key])) {
            throw new \InvalidArgumentException("Invalid route parameter: {$key}");
        }

        return $this->routeParameters[$key];
    }

    public function validate()
    {
        if (method_exists($this, 'rules')) {
            $factory = new Factory(trans()->translator());
            $validator = $factory->make($this->request->all(), $this->rules());

            if (!$validator->passes()) {
                session()->flash('errors', $validator->errors());
                $url = $this->headers->get('referer');
                redirect()->to($url);
            }
        }
    }
}
