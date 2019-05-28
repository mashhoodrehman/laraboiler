<?php

namespace App\Http\Controllers;
use DiDom\Document;
use Edujugon\GoogleAds\GoogleAds;


/**
 * Class LanguageController.
 */
class LanguageController extends Controller
{
    /**
     * @param $locale
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function swap($locale)
    {
        if (array_key_exists($locale, config('locale.languages'))) {
            session()->put('locale', $locale);
        }

        return redirect()->back();
    }

    public function getdata(){
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
dd('dfdf');
        // dd($loadhtml , $document , $html->html);
        // $promise = $client->sendAsync($request)->then(function ($response) use ($body) {
        // $html = $response->getBody();
        // echo $html;
        // });
        // $promise->wait();
    }

    public function getCampain(){
            $ads = new GoogleAds();
            dd($ads);
                $ad = $ads->service(CampaignService::class)
    ->select(['Id', 'Name', 'Status', 'ServingStatus', 'StartDate', 'EndDate'])
    ->get();
    dd($ad);
    }
}
