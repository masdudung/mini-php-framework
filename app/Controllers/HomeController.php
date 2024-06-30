<?php

Use System\Core\Controller;

class HomeController extends Controller {
    public function index() {
        $this->render('home/index.html', ['title' => 'Welcome to My Mini Framework']);
    }
}
