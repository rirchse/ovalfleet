<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GcaptchaController extends Controller
{
    public function site_key()
    {
        return '6LeNxKIUAAAAAAK6S8tZZ8oi5qWmjX02jVoqKppa';        
    }
    
    public function secret_key()
    {
        return '6LeNxKIUAAAAAO7VuLYDyLivgEr2BPk3vcCTL6in';
    }

    static function Check($captcha)
    {
    	
    $secret_key = '6LeNxKIUAAAAAO7VuLYDyLivgEr2BPk3vcCTL6in';
    // $secret_key = '6Lf3RKEUAAAAAIYvck4zHaElkr-aP63VaVIm-Yue';

    // post request to server
    $url =  'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secret_key) .  '&response=' . urlencode($captcha);
    $response = file_get_contents($url);
    $responseKeys = json_decode($response,true);
    return $responseKeys;
    }
}
