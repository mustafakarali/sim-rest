<?php
/**
 * Require Router
 */

require 'middleware/Auth.php';
require 'Router.php';
require 'elloquent/DB.php';

/**
 * Authentication 
 * payload must include username and password
 */
$router->post('/auth',function($payload){
    $auth = new Auth(null);
    echo $auth->login($payload);
});


/**
 * Protect routes with Auth
 */
if($auth->routes()){

          /**
           * Return Function
           */
          $router->get('/',function(){
            echo "<h1>This is home page</h1>";
          });

          /**
          * Require File
          */
          $router->get('/about',function(){
          require __DIR__ . '/views/about.php';
          });

          /**
          * With parameter
          */
          $router->get('/user/:id',function($id){
          echo json_encode(["user_id"=>$id]);
          });

          /**
          *  Post request 
          *  The payload must be JSON format
          */
          $router->post('/', function($data){
          echo json_encode(["data"=>$data]);
          });

          /**
          * Delete request
          */
          $router->delete('/cars/:id',function($id){
          echo json_encode(["id"=>$id]);
          });

          /**
          * Get by Parameter
          */
          $router->get('/posts/:id',function($id){
          $post = DB::table("posts")->where("_id",$id)->get();
          echo json_encode($post);
          });

          /**
          * Get all posts
          */
          $router->get('/posts',function(){
          $posts = DB::table("posts")->all();
          echo json_encode($posts);
          });

          /**
          * Save to post
          */
          $router->post('/posts',function($data){
          $post = DB::table("posts")->save($data);
          echo json_encode($post);
          });

          /**
          * Delete request
          */
          $router->delete('/posts/:id',function($id){
          $posts = DB::table("posts")->delete($id);
          echo json_encode($posts);
          });

          /**
          * Put request
          */
          $router->put('/posts',function($data){
          $post = DB::table("posts")->save($data);
          echo json_encode($post);
          });

}



/**
 * If 404 not found
 */
$router->notFound(function(){
   echo json_encode(["status"=>401,"message"=>"unauthorized"]);
});