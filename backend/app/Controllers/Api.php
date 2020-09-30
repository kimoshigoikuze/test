<?php


namespace App\Controllers;
use App\Models\SOF;
use App\Models\SOFEvents;

class Api extends \Mvc\Controller
{
    public function __construct($request)
    {
        parent::__construct($request);
        $this->post();

    }

    public function sofs() {
       $this->json(SOF::all());
    }

    public function sofsEvents() {

        if(!isset($this->request['id'])) {
          return $this->json(['error' => 'no id supplied'], 422, false);
        }

        return $this->json(SOFEvents::getByIdWithSTDEvents($this->request['id']));
    }
}