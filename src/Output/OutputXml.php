<?php

namespace Useless\Sitemap\Output;

class OutputXml implements OutputInterface
{

    public function generate(array $pages) : string
    {
        $xml = "<?xml version='1.0' encoding='UTF-8'?>\n";
        $xml .= "<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9' xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xsi:schemaLocation='http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd'>\n";

        foreach ($pages as $page) {
            $xml .= "\t<url>\n";
            $xml .= "\t\t<loc>" . htmlentities($page['loc']) . "</loc>\n";
            $xml .= "\t\t<lastmod>" . $page['lastmod'] . "</lastmod>\n";
            $xml .= "\t\t<priority>" . $page['priority'] . "</priority>\n";
            $xml .= "\t\t<changefreq>" . $page['changefreq'] . "</changefreq>\n";
            $xml .= "\t</url>\n";
        }
        $xml .= "</urlset>";

        return $xml;
    }
}