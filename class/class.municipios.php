<?php
  header("Access-Control-Allow-Origin: *");

  class Municipios extends Conexao {
    public static $instance;
    public function __construct(){}
    public static function getInstance() {
      self::$instance = new Municipios();
      return self::$instance;
    }

    public function buscaMunicipios($uf = null, $pesquisa = null) {
      $filtro = "";
      $filtro .= isset($uf) ? " AND Uf = :uf " : "";
      $filtro .= isset($pesquisa) ? " AND concat_ws(' - ',Nome,Uf) LIKE :pesquisa " : "";
      try {
          $sql = "SELECT Id, Nome, Uf
                  FROM municipio
                  WHERE Id > :Id
                  $filtro
                ";
            $pdo = Conexao::getInstance()->prepare($sql);
            $pdo->bindValue(':Id', 0, PDO::PARAM_INT);

            if (isset($uf)) {
              $pdo->bindValue(':uf', $uf, PDO::PARAM_STR);             
            }  
            if (isset($pesquisa)) {
              $pdo->bindValue(':pesquisa', '%'.$pesquisa.'%', PDO::PARAM_STR);             
            }        
              $pdo->execute();
              return $pdo->fetchAll(PDO::FETCH_BOTH);
          }
          catch (Exception $e) {
              echo "<br>".$e->getMessage();
          }
    }  
  }