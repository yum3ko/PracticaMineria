<?php
namespace Prueba\Repositories;

use Symfony\Component\DomCrawler\Crawler;

class CrawlerRepo{

	public function getDatos($documento)
    {
		$crawler = new Crawler($documento);

		$array = $crawler->filter('a')->each(function ($node, $i) {
    		$palabra[] = $node->text();
    		$href[]  = $node->attr('href');

    		return compact('palabra', 'href');
		});

		return $array;
	}


}