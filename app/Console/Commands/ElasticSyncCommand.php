<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AktaNikah;
use Elastic\Elasticsearch\ClientBuilder;

class ElasticSyncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elastic:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync all AktaNikah data to Elasticsearch';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting Elasticsearch Sync...');

        $hosts = [env('ELASTICSEARCH_HOSTS', 'http://elasticsearch:9200')];
        $client = ClientBuilder::create()->setHosts($hosts)->build();

        // Check if index exists, delete it if it does
        $params = ['index' => 'akta_nikah'];
        if ($client->indices()->exists($params)->asBool()) {
            $this->info('Index already exists. Deleting...');
            $client->indices()->delete($params);
        }

        // Create index with mapping and n-gram analyzer
        $this->info('Creating index...');
        $createParams = [
            'index' => 'akta_nikah',
            'body' => [
                'settings' => [
                    'analysis' => [
                        'analyzer' => [
                            'ngram_analyzer' => [
                                'type' => 'custom',
                                'tokenizer' => 'ngram_tokenizer',
                                'filter' => ['lowercase']
                            ]
                        ],
                        'tokenizer' => [
                            'ngram_tokenizer' => [
                                'type' => 'edge_ngram',
                                'min_gram' => 2,
                                'max_gram' => 20,
                                'token_chars' => ['letter', 'digit']
                            ]
                        ]
                    ]
                ],
                'mappings' => [
                    'properties' => [
                        'nama_suami' => [
                            'type' => 'text',
                            'analyzer' => 'ngram_analyzer',
                            'search_analyzer' => 'standard'
                        ],
                        'nama_istri' => [
                            'type' => 'text',
                            'analyzer' => 'ngram_analyzer',
                            'search_analyzer' => 'standard'
                        ],
                        'nomor_akta' => [
                            'type' => 'text',
                            'analyzer' => 'ngram_analyzer',
                            'search_analyzer' => 'standard'
                        ],
                        'lokasi_fisik' => [
                            'type' => 'text',
                            'analyzer' => 'ngram_analyzer',
                            'search_analyzer' => 'standard'
                        ]
                    ]
                ]
            ]
        ];
        $client->indices()->create($createParams);

        // Fetch data
        $aktas = AktaNikah::all();
        $this->info('Found ' . $aktas->count() . ' records. Syncing...');

        foreach ($aktas as $akta) {
            $params = [
                'index' => 'akta_nikah',
                'id'    => $akta->id,
                'body'  => $akta->toSearchableArray()
            ];
            $client->index($params);
        }

        $this->info('Sync Complete!');
    }
}
