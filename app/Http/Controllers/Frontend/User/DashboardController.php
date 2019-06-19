<?php

namespace App\Http\Controllers\Frontend\User;

use App\Helpers\Google\GoogleClient;
use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use Illuminate\Support\Facades\Auth;

/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

       $user = Auth::user();
        $googleClient  = new GoogleClient($user->client_customer_id);
        $data  =$googleClient->getCampaigns();
        return view('frontend.user.dashboard' , compact('data') );
    }
}
