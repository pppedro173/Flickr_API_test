<?php

namespace App\Http\Controllers;

use App\Flickr;

use Illuminate\Http\Request;

class FlickrController extends Controller
{
    	
    /**
     * Create a new controller instance
     * 
     * @return void
     */

     public function showmultipleemp()
     {
        $Flickr = new Flickr();
        $Flickr->photossearch();
     }

     public function showmultiplet($query)
     {
        $Flickr = new Flickr();
        $Flickr->photossearch($query);
     }

     public function showmultipletpp($query, $perpage)
     {
        $Flickr = new Flickr();
        $Flickr->photossearch($query,$perpage);
     }

     public function showmultipletppp($query,$perpage,$page)
     {
        $Flickr = new Flickr();
        $Flickr->photossearch($query,$perpage,$page);
     }


    public function showrand()
    {
        $Flickr = new Flickr();
        $Flickr->photossearch(null,1,rand(0,100));
    }


}