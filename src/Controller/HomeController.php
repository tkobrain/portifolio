<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

class HomeController{
    /**
     * @Route("/home")
     */
    public function homeAction(){
        echo 'Ola Mundo';
        exit();
    }

}
