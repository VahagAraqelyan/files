<?php

class Constants
{

    public static function routes()
    {
      return [
            'main' => 'HomeController@main',
            'reset_password' => 'HomeController@reset_password',
            'change_plan' => 'PricingController@change_plan',
            'home' => 'HomeController@index',
            'contact' => 'HomeController@contact',
            'about_us' => 'HomeController@about_us',
            'faq' => 'HomeController@faq'
        ];
    }


}