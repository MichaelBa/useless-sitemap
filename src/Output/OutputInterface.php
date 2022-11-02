<?php

namespace Useless\Sitemap\Output;

interface OutputInterface
{
    public function generate(array $pages) : string;
}