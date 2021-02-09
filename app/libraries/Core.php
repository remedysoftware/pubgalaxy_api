<?php

  class Core {
    protected $currentController = 'Cars';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct(){
      //print_r($this->getUrl());

      $url = $this->getUrl();
      

      // print_r($url);
      // print_r($url);
      // Look in controllers for first value
      
      if(file_exists('../app/controllers/' . @ucwords($url[0]). '.php')){
        // If exists, set as controller
        $this->currentController = @ucwords($url[0]);
        // Unset 0 Index
        unset($url[0]);
      }

      // Require the controller
      require_once '../app/controllers/'. $this->currentController . '.php';

      // Instantiate controller class
      $this->currentController = new $this->currentController;

      // Check for second part of url
      if(isset($url[1])){
        // Check to see if method exists in controller
        if(method_exists($this->currentController, $url[1])){
          $this->currentMethod = $url[1];
          // Unset 1 index
          unset($url[1]);
        }
      }

      // Get params
      // # fix bug when params are empty array trow fatal error ( function pass 0 variables ) , so if params are empty array
      // # just set to be 0 array
      $this->params = $url ? array_values($url) : [0];

      // Call a callback with array of params
      @call_user_func_array(array($this->currentController, $this->currentMethod), $this->params);

    }

    public function getUrl(){
      if(isset($_GET['url'])){
        $url = rtrim($_GET['url'], '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $url);
        return $url;
      }
    }
  } 
  