<?php

namespace App\Controllers;

use Mvc\View as View;

class Landing extends \Mvc\Controller
{
    public function index()
    {
        return View::render('index.html');
    }
}