<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AktaNikah;
use Elastic\Elasticsearch\ClientBuilder;

class KomparasiPencarianController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('q', '');
        
        $meiliResults = [];
        $meiliLatency = 0;
        $meiliTotal = 0;
        
        $elasticResults = [];
        $elasticLatency = 0;
        $elasticTotal = 0;

        if (!empty($keyword)) {
            // --- Meilisearch ---
            $startMeili = microtime(true);
            // using scout
            $meiliPaginated = AktaNikah::search($keyword)->paginate(10);
            $meiliLatency = round((microtime(true) - $startMeili) * 1000);
            $meiliResults = $meiliPaginated->items();
            $meiliTotal = $meiliPaginated->total();

            // --- Elasticsearch ---
            $startElastic = microtime(true);
            try {
                $hosts = [env('ELASTICSEARCH_HOSTS', 'http://elasticsearch:9200')];
                $client = ClientBuilder::create()->setHosts($hosts)->build();

                $params = [
                    'index' => 'akta_nikah',
                    'body'  => [
                        'query' => [
                            'multi_match' => [
                                'query' => $keyword,
                                'fields' => ['nama_suami', 'nama_istri', 'nomor_akta', 'lokasi_fisik'],
                                'fuzziness' => 'AUTO',
                                'operator' => 'and'
                            ]
                        ],
                        'size' => 10
                    ]
                ];

                $response = $client->search($params);
                $elasticLatency = round((microtime(true) - $startElastic) * 1000);
                
                $hits = $response['hits']['hits'] ?? [];
                foreach ($hits as $hit) {
                    $elasticResults[] = (object) $hit['_source'];
                }
                $elasticTotal = $response['hits']['total']['value'] ?? count($hits);

            } catch (\Exception $e) {
                // If elastic fails
                $elasticResults = [];
                $elasticTotal = 0;
                $elasticLatency = -1; // Indicate error
            }
        }

        return view('admin.komparasi.index', compact(
            'keyword', 
            'meiliResults', 'meiliLatency', 'meiliTotal',
            'elasticResults', 'elasticLatency', 'elasticTotal'
        ));
    }
}
