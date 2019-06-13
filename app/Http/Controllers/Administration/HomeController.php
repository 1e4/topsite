<?php
namespace App\Http\Controllers\Administration;

class HomeController extends \App\Http\Controllers\Controller {

    public function getHome()
    {
        return view('administration.index');
    }

}