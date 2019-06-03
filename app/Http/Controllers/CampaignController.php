<?php

namespace App\Http\Controllers;

use App\Helpers\Google\GoogleClient;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    //
    /**
     *
     */
    public function getCampaigns(Request $request)
    {

        $user =  $request->user('api');

        $googleClient  = new GoogleClient($user->client_customer_id);
        $data  =$googleClient->getCampaigns();
        return response()->json($data);


    }

    public function changeStatus(Request $request)
    {
        $user =  $request->user('api');
        $googleClient  = new GoogleClient($user->client_customer_id);
        $googleClient->changeStatus();

    }
}
