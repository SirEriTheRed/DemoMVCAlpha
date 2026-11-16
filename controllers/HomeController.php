<?php

class HomeController
{
    public function index(): void
    {
        require_once 'views/home.php';
    }

    public function about(): void
    {
        require_once 'views/about.php';
    }
}
