<?php

namespace SmarterCoding\WpPlus\Structs;

class PostType
{
    private $key;
    private $args;

    public function __construct($key)
    {
        $this->key = $key;

        $this->args = [
            'public' => true,
            'has_archive' => true,
            'show_in_rest' => true,
            'supports' => ['title', 'editor', 'thumbnail']
        ];
    }

    public static function key($key): PostType
    {
        return new PostType($key);
    }

    public function labels($singular, $plural): PostType
    {
        $this->args['labels'] = [
            'name' => __($plural),
            'singular_name' => __($singular)
        ];

        return $this;
    }

    public function slug($slug): PostType
    {
        $this->args['rewrite']['slug'] = $slug;

        return $this;
    }

    public function menuIcon($value) : PostType
    {
        $this->args['menu_icon'] = $value;

        return $this;
    }

    public function set($key, $value): PostType
    {
        $this->args[$key] = $value;

        return $this;
    }

    public function register()
    {
        register_post_type($this->key, $this->args);
    }
}
