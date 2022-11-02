<?php

namespace Useless\Sitemap\Output;

class OutputJson implements OutputInterface
{

    public function generate(array $pages) : string
    {
        return json_encode($pages);
    }
}