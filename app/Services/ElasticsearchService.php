<?php

namespace App\Services;

use Elastic\Elasticsearch\ClientBuilder;


class ElasticsearchService
{
    protected $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()->setHosts(['localhost:9200'])->build();
    }

    // Метод search принимает три строковых параметра
    public function search(string $index, string $field, string $query)
    {
        $params = [
            'index' => $index,
            'body' => [
                'query' => [
                    'match_phrase_prefix' => [
                        $field => $query
                    ]
                ]
            ]
        ];

        return $this->client->search($params);
    }
}
