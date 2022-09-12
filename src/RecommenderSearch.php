<?php

namespace Shopeo\CompleteTheLook;

class RecommenderSearch
{
    private $url = 'https://vs.warp-driven.com/img/vs_search?sku=%s&table_name=woolworlds_products';

    public function search($sku)
    {
        $url = sprintf($this->url, $sku);
        $response = wp_remote_post($url);
        error_log(print_r($response, true));
        if (!is_wp_error($response)) {
            return json_decode($response['body']);
        } else {
            return array();
        }
    }
}