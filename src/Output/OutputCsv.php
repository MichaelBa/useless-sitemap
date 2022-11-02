<?php

namespace Useless\Sitemap\Output;

class OutputCsv implements OutputInterface
{

    public function generate(array $pages) : string
    {
        $file = fopen('php://memory', 'r+');
        foreach ($pages as $page) {
            fputcsv($file, $page);
        }
        rewind($file);
        $csv = stream_get_contents($file);

        return rtrim($csv);
    }
}