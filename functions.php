<?php

function get_rss() {
    $items = array();
    $url = 'https://www.guru.com/rss/jobs/';

    $xml_doc = new DOMDocument();
    $xml_doc->load($url);
    $xml_items = $xml_doc->getElementsByTagName('item');
    for ($i=0; $i<$xml_items->length; $i++) {
        $item = array();
        $item['title'] = $xml_items->item($i)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
        $item['link'] = $xml_items->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue;
        $item['description'] = $xml_items->item($i)->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue;
        $item['pubDate'] = $xml_items->item($i)->getElementsByTagName('pubDate')->item(0)->childNodes->item(0)->nodeValue;

        array_push($items, $item);
    }

    return $items;
}

$items = get_rss();

echo json_encode($items);