<?php

use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;

require __DIR__ . '/vendor/autoload.php';

$client = new Client(HttpClient::create(['verify_host' => false]));
$text = [];
$finalLinks = [];
$url = 'https://codingcafe.website';
 
function crawlLink($url, $client){
    
    $crawler = $client->request('GET', $url);
    $text =  $crawler->filter('h1, h4, h5, h6, span, h3, h2, p, a')->each(function ($node) {
      return $node->text()."<br>";
    });
    $text = array_filter($text);
    $text = implode('<br>', $text);
    $finalLinks['url'] = $url;
    $finalLinks['content'] = $text;
    $finalLinks['words'] = str_word_count($text);
    $links =  $crawler->filter('a')->each(function ($node) use($url) {
        $link = $node->attr('href');
        if(str_contains($link, $url)) {
            if(str_ends_with($link, '/')) {
                return substr($link, 0, strlen($link) - 1);
            }
            return $link;
        }
    });
    $links = array_unique(array_filter($links));
}
crawlLink($url, $client);
print_r($finalLinks);