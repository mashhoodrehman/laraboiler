<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class getProductReview implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {


        $endpoint = "localhost:3333/get-html?url=https://www.amazon.com/dp/B07KXVH473";
        $client = new \GuzzleHttp\Client();
        $body = '';
        $body = $client->get($endpoint);
        $html = $body->getBody()->getContents();
$html = json_decode($html);
        $document = new Document;
        $document = $document->loadhtml($html->html);
        $loadhtml = $document->find('#acrCustomerReviewText');
        
        foreach($loadhtml as $text) {
    echo $text->text(), "\n";
}
    }
}
