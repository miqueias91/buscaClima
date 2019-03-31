<?php
  header("Access-Control-Allow-Origin: *");

  class Notificacoes extends Conexao {
    public static $instance;
    public function __construct(){}
    public static function getInstance() {
      self::$instance = new Notificacoes();
      return self::$instance;
    }

    public function atualizaNotificacao($token, $municipio, $estado) {
      try {
          $sql = "INSERT INTO registro_notificacoes (
                  token,
                  municipio,
                  estado
          )
          VALUES (
                  :token,
                  :municipio,
                  :estado
          )
          ON DUPLICATE KEY 
            UPDATE 
              token = :token, 
              municipio = :municipio,
              estado = :estado";
          $pdo = Conexao::getInstance()->prepare($sql);
          $pdo->bindValue(":token", $token, PDO::PARAM_STR);
          $pdo->bindValue(":municipio", $municipio, PDO::PARAM_STR);
          $pdo->bindValue(":estado", $estado, PDO::PARAM_STR);
      
          $pdo->execute();

        return true;                
      }catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
      }
    }  
  }