<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\Google\GoogleClient;
use App\Http\Controllers\Controller;
use Google\AdsApi\AdWords\AdWordsServices;
use Google\AdsApi\AdWords\AdWordsSessionBuilder;
use Google\AdsApi\AdWords\v201809\cm\CampaignService;
use Google\AdsApi\AdWords\v201809\cm\OrderBy;
use Google\AdsApi\AdWords\v201809\cm\Paging;
use Google\AdsApi\AdWords\v201809\cm\Selector;
use Google\AdsApi\Common\OAuth2TokenBuilder;


/**
 * Class HomeController.
 */
class HomeController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {

//        $oAuth2Credential = (new OAuth2TokenBuilder())
//            ->fromFile(storage_path('app/adsapi_php.ini'))
//            ->build();
//
//        $session = (new AdWordsSessionBuilder())
//            ->fromFile(storage_path('app/adsapi_php.ini'))
//            ->withOAuth2Credential($oAuth2Credential)
//            ->withClientCustomerId('208-036-0101')
//            ->build();

        $googleClient = new GoogleClient('208-036-0101');

        $campaigns=  $googleClient->getCampaigns();

        dd($campaigns);

//        $adWordsServices = new AdWordsServices();
//
//        $campaignService = $adWordsServices->get($session, CampaignService::class);
//
//
//        $selector = new Selector();
//        $selector->setFields(array('Id', 'Name'));
//        $selector->setOrdering(array(new OrderBy('Name', 'ASCENDING')));
//        $selector->setPaging(new Paging(0, 100));
//
//
//
//        $totalNumEntries = 0;
//        do {
//            // Make the get request.
//            $page = $campaignService->get($selector);
//            // Display results.
//            if ($page->getEntries() !== null) {
//                $totalNumEntries = $page->getTotalNumEntries();
//                foreach ($page->getEntries() as $campaign) {
//                    printf(
//                        "Campaign with ID %d and name '%s' was found.\n",
//                        $campaign->getId(),
//                        $campaign->getName()
//                    );
//                }
//            }
//            // Advance the paging index.
//            $selector->getPaging()->setStartIndex(
//                $selector->getPaging()->getStartIndex() + 500
//            );
//        } while ($selector->getPaging()->getStartIndex() < $totalNumEntries);

//        printf("Number of results found: %d\n", $totalNumEntries);
        return view('frontend.index');
    }


}
