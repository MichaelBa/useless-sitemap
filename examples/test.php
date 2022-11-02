<?php

require('../vendor/autoload.php');

use Useless\Sitemap\Generator;

$sitemap = new Generator([
    [
        'loc' => 'http://google.com',
        'lastmod' => '2022-11-01',
        'priority' => 1,
        'changefreq' => 'weekly',
    ],
    [
        'loc' => 'http://yandex.com',
        'lastmod' => '2021-11-01',
        'priority' => 0.1,
        'changefreq' => 'never',
    ],
    [
        'loc' => 'http://stackoverflow.com',
        'lastmod' => '2022-11-02',
        'priority' => 0.5,
        'changefreq' => 'hourly',
    ],
]);

$sitemap->save('1/s.json');
$sitemap->save('s.xml');
$sitemap->save('/../s.csv');


