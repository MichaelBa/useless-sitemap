<?php

namespace Useless\Sitemap\Output;

use Exception;

class OutputFactory
{
    /**
     * @throws Exception
     */
    public static function getInstance(string $type)
    {
        switch ($type) {
            case 'json':
                return new OutputJson();
                break;
            case 'xml':
                return new OutputXml();
                break;
            case 'csv':
                return new OutputCsv();
                break;
            default:
                throw new Exception("Invalid output format: " . $type);
                break;
        }
    }
}