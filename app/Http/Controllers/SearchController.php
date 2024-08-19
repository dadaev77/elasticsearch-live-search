<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ElasticsearchService;

class SearchController extends Controller
{
    protected $elasticsearch;

    public function __construct(ElasticsearchService $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        // Проверка на пустое значение
        if (empty($query)) {
            return response()->json([], 200);
        }

        // Выполнение поиска
        $results = $this->elasticsearch->search('my_index', 'my_field', $query);

        // Проверка результатов
        if (empty($results['hits']['hits'])) {
            return response()->json([], 200);
        }

        return response()->json($results['hits']['hits']);
    }
}