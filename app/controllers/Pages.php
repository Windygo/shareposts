<?php
  class Pages extends Controller {
    public function __construct(){
     
    }
    
    public function index(){

      // If logged in redirect to main posts page, not homepage
      if (isLoggedIn()) {
        redirect('posts');
      }

      $data = [
        'title' => 'SharePosts',
        'description' => 'Simple social network built on the Eshel MVC PHP framework'
      ];
     
      $this->view('pages/index', $data);
    }

    public function about(){
      $data = [
        'title' => 'About Us',
        'description' => 'App to share posts with other users'
      ];

      $this->view('pages/about', $data);
    }
  }