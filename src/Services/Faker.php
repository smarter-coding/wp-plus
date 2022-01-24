<?php

namespace SmarterCoding\WpPlus\Services;

use Faker\Provider\Base as FakerBase;

class Faker extends FakerBase
{
    public function wp_paragraphs(int $number)
    {
        $content = '';

        for ($i = 0; $i < $number; ++$i) {
            $content .= "<!-- wp:paragraph --><p>{$this->generator->paragraph(6)}</p><!-- /wp:paragraph -->";
        }

        return $content;
    }
}
