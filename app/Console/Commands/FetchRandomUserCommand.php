<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class FetchRandomUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-random-user-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client = new Client();

        try {
            $response = $client->get('https://randomuser.me/api/');

            $data = json_decode($response->getBody()->getContents(), true);
            Log::info('Random User Response:', ['data' => $data]);
        } catch (\Exception $e) {
            Log::error('Error fetching random user: ' . $e->getMessage());
        }
    }
}
