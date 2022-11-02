<?php

namespace Useless\Sitemap;

use Exception;
use DateTime;
use Useless\Sitemap\Output\OutputFactory;

class Generator
{
    protected $pages = [];
    protected $params = ['loc', 'lastmod', 'priority', 'changefreq'];

    public function __construct(array $pages = [])
    {
        $this->addPages($pages);
    }

    public function save(string $path) : void
    {
        $pathInfo = pathinfo($path);
        $output = OutputFactory::getInstance($pathInfo['extension'] ?? '');
        $content = $output->generate($this->pages);
        $this->saveToFile($pathInfo, $content);
    }

    public function addPages(array $pages = []) : void
    {
        foreach ($pages as $page) {
            $this->addPage($page);
        }
    }

    /**
     * @throws Exception
     */
    private function saveToFile(array $pathInfo, string $content) : void
    {
        if (!is_dir($pathInfo['dirname'])) {
            if (false === @mkdir($pathInfo['dirname'], 0777, true)) {
                throw new Exception('Unable to create directory: ' . $pathInfo['dirname']);
            }
        }

        if (false === @file_put_contents($pathInfo['dirname'] . '/' . $pathInfo['basename'], $content)) {
            throw new Exception('Unable to write file: ' . $pathInfo['dirname'] . '/' . $pathInfo['basename']);
        }
    }

    private function addPage(array $page) : void
    {
        $this->validatePage($page);
        $this->pages[] = $this->filterPage($page);
    }

    private function filterPage(array $page) : array
    {
        foreach ($page as $key => $value) {
            if (!in_array($key, $this->params)) {
                unset($page[$key]);
            }
        }
        return $page;
    }

    /**
     * @throws Exception
     */
    private function validatePage(array $page) : void
    {
        foreach ($this->params as $param) {
            if (!isset($page[$param])) {
                throw new Exception("Page parameter missed: " . $page[$param]);
            }
        }

        if (!filter_var($page['loc'], FILTER_VALIDATE_URL)) {
            throw new Exception("Invalid loc parameter: " . $page['loc']);
        }

        $dt = DateTime::createFromFormat("Y-m-d", $page['lastmod']);
        if ($dt === false || array_sum($dt::getLastErrors())) {
            throw new Exception("Invalid lastmod parameter: " . $page['lastmod']);
        }

        if ((!is_float($page['priority']) && !is_int($page['priority'])) || $page['priority'] < 0 || $page['priority'] > 1) {
            throw new Exception("Invalid priority parameter: " . $page['priority']);
        }

        if (!in_array(strtolower($page['changefreq']), ['always', 'hourly', 'daily', 'weekly', 'monthly', 'yearly', 'never'])) {
            throw new Exception("Invalid changefreq parameter: " . $page['changefreq']);
        }

    }

}