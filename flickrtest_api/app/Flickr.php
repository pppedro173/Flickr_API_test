<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

Class Flickr extends Model 

{

    private $apiKey;


    public function __construct() 
    {
        $this->apiKey = env('FLICKR_KEY');
    } 
    
    public function file_get_contents_curl($url) 
    {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36');
		curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		$data = curl_exec($ch);
		$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		if ($retcode == 200) {
			return $data;
		} else {
			return null;
		}
    }


    public function display($data)
    {
         echo '<p>'.' NPAGES : '.$data['photos']['pages'].'</p>';
         echo '<p>'.' PAGE : '.$data['photos']['page'].'</p>';
         echo '<p>'.' TOTAL : '.$data['photos']['total'].'</p>';
         foreach($data['photos']['photo'] as $photo) { 
             echo '<img src="' . 'http://farm' . $photo["farm"] . '.static.flickr.com/' . $photo["server"] . '/' . $photo["id"] . '_' . $photo["secret"] . '.jpg">'; 
             echo '<p>'.' ID: '.$photo["id"].'</p>';
             echo '<p>'.' TITLE: '.$photo["title"].'</p>';
             echo '<p>'.' OWNER : '.$photo["owner"].'</p>';
             echo '<p>'.' URL="' . 'http://farm' . $photo["farm"] . '.static.flickr.com/' . $photo["server"] . '/' . $photo["id"] . '_' . $photo["secret"] . '.jpg"'.'</p>';
             $this->photosdescp($photo["id"]);
             $this->photosize($photo["id"]);
            }            
         }


    public function displayinfo($data)
    {
        foreach($data['photo']['description'] as $photoinf){
            echo '<p>'. 'Description :' .$photoinf.'</p>';
        }
    }

    public function displaysizes($data)
    {
        foreach($data['sizes']['size'] as $size){
            echo '<p>'. 'Height :' .$size["height"].'</p>';
            echo '<p> WIDTH :' .$size["width"].'</p>';
            return;
          }

    }

    public function photosdescp($photo_id, $format = 'php_serial')
    {
        $method = 'flickr.photos.getInfo';

		$args = array(
			'method' => $method,
			'api_key' => $this->apiKey,
			'photo_id' => urlencode($photo_id),
            'format' => $format
        );

		$url = 'http://flickr.com/services/rest/?'; 
        $search = $url.http_build_query($args);
		$result = $this->file_get_contents_curl($search); 
        if ($format == 'php_serial') $result = unserialize($result);
        $this->displayinfo($result);      
    }

    public function photosize($photo_id, $format = 'php_serial')
    {
        $method = 'flickr.photos.getSizes';

		$args = array(
			'method' => $method,
			'api_key' => $this->apiKey,
			'photo_id' => urlencode($photo_id),
            'format' => $format
        );

		$url = 'http://flickr.com/services/rest/?'; 
        $search = $url.http_build_query($args);
		$result = $this->file_get_contents_curl($search); 
        if ($format == 'php_serial') $result = unserialize($result);
        $this->displaysizes($result);      
    }

    


    public function photossearch($query = null, $per_page = null, $page = null, $format = 'php_serial')
    {
        $method = 'flickr.photos.search';

        if($query == null) $method = 'flickr.photos.getRecent';
        if($per_page == null) $per_page = 1;
        if($page == null) $page = 1;

		$args = array(
			'method' => $method,
			'api_key' => $this->apiKey,
			'text' => urlencode($query),
            'per_page' => $per_page,
            'page' => $page,
            'format' => $format
        );

		$url = 'http://flickr.com/services/rest/?'; 
        $search = $url.http_build_query($args);
        echo $search;
		$result = $this->file_get_contents_curl($search); 
        if ($format == 'php_serial') $result = unserialize($result);
        $idsent = $this->display($result);        
    }
}