<?php


namespace App\Helpers\Google;

use Google\AdsApi\AdWords\AdWordsServices;
use Google\AdsApi\AdWords\AdWordsSessionBuilder;
use Google\AdsApi\AdWords\v201809\cm\Campaign;
use Google\AdsApi\AdWords\v201809\cm\CampaignOperation;
use Google\AdsApi\AdWords\v201809\cm\CampaignService;
use Google\AdsApi\AdWords\v201809\cm\CampaignStatus;
use Google\AdsApi\AdWords\v201809\cm\Operator;
use Google\AdsApi\AdWords\v201809\cm\OrderBy;
use Google\AdsApi\AdWords\v201809\cm\Paging;
use Google\AdsApi\AdWords\v201809\cm\Selector;
use Google\AdsApi\Common\OAuth2TokenBuilder;
class GoogleClient
{

    protected  $googleAuthSession;

    private $statusCasts = [
        'PAUSED' => false,
        'ENABLED' => true

    ];

    public function __construct($clientCustomerId)
    {
        $oAuth2Credential = (new OAuth2TokenBuilder())
            ->fromFile(storage_path('adsapi_php.ini'))
            ->build();

        $this->googleAuthSession = (new AdWordsSessionBuilder())
            ->fromFile(storage_path('adsapi_php.ini'))
            ->withOAuth2Credential($oAuth2Credential)
            ->withClientCustomerId($clientCustomerId)->build();

    }

    public function getCampaigns()
    {
        $session = $this->googleAuthSession;

        $adWordsServices = new AdWordsServices();

        $campaignService = $adWordsServices->get($session, CampaignService::class);

        $selector = new Selector();
        $selector->setFields(array('Id', 'Name', 'Status','Labels'));
        $selector->setOrdering(array(new OrderBy('Name', 'ASCENDING')));
        $selector->setPaging(new Paging(0, 100));

        $result = [];
        $totalNumEntries = 0;
        do {
            // Make the get request.
            $page = $campaignService->get($selector);
            // Display results.
            if ($page->getEntries() !== null) {
                $totalNumEntries = $page->getTotalNumEntries();
                foreach ($page->getEntries() as $campaign) {
//                    printf(
//                        "Campaign with ID %d and name '%s' was found.\n",
//                        $campaign->getId(),
//                        $campaign->getName()
//                    );

                    $result[]=array(
                        'id'=>$campaign->getId(),
                        'name'=>$campaign->getName(),
                        'label'=>
                            array_map(
                                function ($label) {
                                    return ['label' => $label->getName() , 'id' => $label->getId()];
                                },
                                $campaign->getLabels()
                        ),
                        'status'=> self::statusParser($campaign->getStatus()),
                        'actual_status'=> $campaign->getStatus(),

                    );

                }
            }
            // Advance the paging index.
            $selector->getPaging()->setStartIndex(
                $selector->getPaging()->getStartIndex() + 500
            );
        } while ($selector->getPaging()->getStartIndex() < $totalNumEntries);
        return $result;

    }


    public static  function statusParser($status)
    {
        if ($status == 'ENABLED'){
            return true;
        }
        else{
            return false;
        }

    }

    public function changeStatus( $addId , $status  )
    {

        $session = $this->googleAuthSession;

        $adWordsServices = new AdWordsServices();

        $campaignService = $adWordsServices->get($session, CampaignService::class);

        $operations = [];
        // Create a campaign with PAUSED status.
        $campaign = new Campaign();
        $campaign->setId($addId );


        if($status == "on"){
        $campaign->setStatus(CampaignStatus::PAUSED);
        }
        else{
         $campaign->setStatus(CampaignStatus::ENABLED);
        }
        // Create a campaign operation and add it to the list.
        $operation = new CampaignOperation();
        $operation->setOperand($campaign);
        $operation->setOperator(Operator::SET);
        $operations[] = $operation;

        // Update the campaign on the server.
        $result = $campaignService->mutate($operations);

        $campaign = $result->getValue()[0];
        return true;
        printf(
            "Campaign with ID %d, name '%s', and Status '%s' .\n",
            $campaign->getId(),
            $campaign->getName(),
            $campaign->getStatus()
        );

    }
}
