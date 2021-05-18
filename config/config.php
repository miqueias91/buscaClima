<?php
  $base       = "/var/www/site-climaHoje";
  $base_http    = "http://www.localhost/site-climaHoje/";

  $PATH_BASE_HTTP = $base_http;
  $CLASS_PATH    = $base."/class" ;
  $PATH_CLASS    = $CLASS_PATH ;
  $SCRIPT_PATH  = $base_http."/css" ;
  $PATH_CSS    = $SCRIPT_PATH ;
  $PATH_JS    = $base_http."/js" ;
  $FUNCTION_PATH  = $base."/funcoes" ;
  $PATH_FUNCTION  = $FUNCTION_PATH ;
  $IMAGE_PATH    = $base_http."/img" ;


  if(empty($extraidos)){
    extract($_POST);
    extract($_GET);
    extract($_FILES);
    if(isset($_SESSION))extract($_SESSION);
    $extraidos = 1;
  }


  $tokenClimaTempo = 'db0b630c9cfd789d97c89c45e8e52068';