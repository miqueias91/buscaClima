<?php
    // header ('Content-type: text/html; charset=ISO-8859-1');
    // header("Content-Type: application/json; charset=UTF-8");

  // $base       ="/home/thewebbestads/public_html/app/teindico";
  // $base_http     = "/home/storage/f/87/f0/thewebbestads/public_html/app/teindico";

  $base       = "C:/xampp/htdocs/climaHoje";
  $base_http    = "http://localhost/climaHoje";

  //$base       = "/var/www/teindico-admin";
  //$base_http    = "http://localhost/teindico-admin";

  $PATH_BASE_HTTP = $base_http;
  $CLASS_PATH    = $base."/class" ;
  $PATH_CLASS    = $CLASS_PATH ;
  $SCRIPT_PATH  = $base_http."/css" ;
  $PATH_CSS    = $SCRIPT_PATH ;
  $PATH_JS    = $base_http."/js" ;
  $FUNCTION_PATH  = $base."/funcoes" ;
  $PATH_FUNCTION  = $FUNCTION_PATH ;
  $IMAGE_PATH    = $base_http."/img" ;


  include_once( "$base/class/class.conexao.php" );
  /*****************************************
   *       Conexao com o db principal      *
   *****************************************/   
  $conexao = Conexao::getInstance();

  if(empty($extraidos)){
    extract($_POST);
    extract($_GET);
    extract($_FILES);
    if(isset($_SESSION))extract($_SESSION);
    $extraidos = 1;
  }