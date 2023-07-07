<?php

use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/crawl.php';

/**
 * Misscelaneous variables
 * 
 * @var $client Gouttle\Client $client A crawler client instance
 * @val $url string $url The url to crawl
 * @var $inStockText stores $inStockText The exact text that is stored in #availability tag when a product is in stock
 */
$client = new Client(HttpClient::create(['verify_host' => false]));
$url = 'https://www.amazon.in/dp/B072PRH59B/?coliid=I1J7S6167YE0ZW&colid=Z1348PFM3I4R&psc=0&ref_=list_c_wl_lv_ov_lig_dp_it';
$inStockText = 'In stock';


$baseURL = parse_url($url, PHP_URL_HOST);
/** @var string $availabilityText Text contained in #availability */
$availabilityText = implode('', crawl($client, $url, '#availability'));

/** Fetching the price of the product */
if (strcmp($availabilityText, $inStockText) == 0) {
    $price = crawl($client, $url, '#corePriceDisplay_desktop_feature_div > div > .reinventPricePriceToPayMargin'); // '#corePriceDisplay_desktop_feature_div >  .reinventPricePriceToPayMargin');
    $price = implode('', array_unique(array_filter(explode('₹', $price[0]))));
    echo 'Availability: ' . $availabilityText . '<br>Price: ' . $price;
}

echo 'Availability: '. $availabilityText;

?>