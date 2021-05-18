<?php

  class Municipios {

    function __construct(){}

    public function CURL($url){
      $ch     =   curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $result = (curl_exec($ch));
      return $result;
    }

    public function buscaMunicipios($uf = null) {
      $url0 = "https://servicodados.ibge.gov.br/api/v1/localidades/estados/$uf/distritos";
      $result0 = $this->CURL($url0);
      return $result0;
    }  
  }