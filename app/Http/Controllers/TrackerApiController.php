<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TrackerApi;
use Stevebauman\Location\Facades\Location;
use Jenssegers\Agent\Agent;

class TrackerApiController extends Controller
{

    public function trackme(Request $req){
        $new_track = new TrackerApi();
        $new_track->ip_adress = $req->ip();

        //get location
        $new_track->locations = Location::get($new_track->ip_adress);

        //get device info
        $os_data = ['Windows','Mac','Linux','GNU'];
        foreach($os_data as $os){
            if (str_contains($_SERVER['HTTP_USER_AGENT'], $os)){
                $new_track->OS = $os;
            }else{
                $new_track->OS = "Not defined";
            }
        }
        $agent = new Agent;
        $mobileResult = $agent->isMobile();
        if ($mobileResult) {
          $result = 'Mobile';
        }

        $desktopResult= $agent->isDesktop();
        if ($desktopResult) {
          $result = 'Desktop';
        }

        $tabletResult= $agent->isTablet();
        if ($tabletResult) {
          $result = 'Desktop';
        }

        $tabletResult= $agent->isPhone();
        if ($tabletResult) {
          $result = 'Mobile';
        }
        $new_track->device = $result;

        //get referer
        if(empty($_SERVER['HTTP_REFERER'])){

            $new_track->refferer = "127.0.0.1"         ;
        }else{
            $new_track->refferer = $_SERVER['HTTP_REFERER'];
        }

        $new_track->url = $req->url();
        $new_track->language = $req->getLocale();
        $new_track->save();


        // return response()->json($new_track);
        return redirect()->away('https://www.additive.eu/en/');
    }
}

