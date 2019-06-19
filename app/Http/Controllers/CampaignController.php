<?php

namespace App\Http\Controllers;

use App\Helpers\Google\GoogleClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CampaignController extends Controller
{
    //
    /**
     *
     */
    public function getCampaigns(Request $request)
    {

        $user =  $request->user('api');

        $googleClient  = new GoogleClient('32433242342');
        $data  =$googleClient->getCampaigns();
        return response()->json($data);


    }

    public function getLabels(Request $request){
        $user =  $request->user('api');
        $googleClient  = new GoogleClient($user->client_customer_id);
        $data  =$googleClient->getCampaigns();
        return response()->json($data);
    }

    public function changeStatus(Request $request , $id , $status)
    {
        $user =  $request->user('api');
        $googleClient  = new GoogleClient($user->client_customer_id);
        $googleClient->changeStatus($id , $status);
        return response()->json('successful');

    }

    public function statusCampains(Request $request){
        $user = Auth::user();
        $googleClient  = new GoogleClient($user->client_customer_id);
        foreach ($request->id as $id){
            $googleClient->changeStatus($id , "off");
        }
        return "successful";
    }
    public function statusCampainsEnab(Request $request){
        $user = Auth::user();
        $googleClient  = new GoogleClient($user->client_customer_id);
        foreach ($request->id as $id){
            $googleClient->changeStatus($id , "on");
        }
        return "successful";
    }
}
