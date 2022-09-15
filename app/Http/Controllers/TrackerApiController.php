<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TrackerApi;
use Stevebauman\Location\Facades\Location;
use Jenssegers\Agent\Agent;

class TrackerApiController extends Controller
{

    public function trackme(Request $req, $link){
        $new_track = new TrackerApi();

        $new_track->ip_adress = $req->server->get('REMOTE_ADDR');

        //get location

        $locationObj = Location::get($req->ip());
        if($locationObj){
            $new_track->locations = $locationObj->countryName;
        }else{
            $new_track->locations = "unavailable";
        }

        //get OS info
        $os_data = ['Windows','Mac','Linux','GNU'];
        $new_track->OS = "Not defined";
        foreach($os_data as $os){
            if (str_contains($_SERVER['HTTP_USER_AGENT'], $os)){
                $new_track->OS = $os;
            }
        }

        //get device info
        $agent = new Agent;
        $mobileResult = $agent->isMobile();
        if ($mobileResult) {
            $new_track->device = $result = 'Mobile';
        }

        $desktopResult= $agent->isDesktop();
        if ($desktopResult) {
            $new_track->device = $result = 'Desktop';
        }

        $tabletResult= $agent->isTablet();
        if ($tabletResult) {
            $new_track->device = $result = 'Tablet';
        }

        $tabletResult= $agent->isPhone();
        if ($tabletResult) {
            $new_track->device =  $result = 'Phone';
        }

        if(empty($req->headers->get('referer'))){

            $new_track->refferer = "direct"         ;
        }else{
            $new_track->refferer = $req->headers->get('referer');
        }

        $new_track->url = $link;
        $new_track->language = $req->getLocale();
        $new_track->save();


        return redirect()->away('https://www.'.$link);
    }
}
