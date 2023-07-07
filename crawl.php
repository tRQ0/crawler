<?php
/**
 * crawl the specified url
 * 
 * @param Goutte\Client $client The client instance
 * @param string $url The url to crawl
 * @param string $filter The CSS filter to filter upon
 * 
 * @return <array|string>
 */
function crawl(Goutte\Client $client, string $url, string $filter) : array|string
{
    /**
     * @var $crawler Gouttle\Client a client instance
     */
    $crawler = $client->request('GET', $url);
    /**
     * @var array @result Result array
     */
    $result =  $crawler->filter($filter)->each(function ($node) {
        $text = $node->text();
        return($text);
    });
    return count($result) == 0 ? 'Nothing found' : $result;
}
?>