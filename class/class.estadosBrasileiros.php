<?php

/**
 * RETORNA OS ESTADOS DO BRASIL
 */
class estadosBrasileiros{
    
    function __construct(){}

    public function buscaEstadosBrasileiros($pesquisa){
        $estados["AC"] = "Acre";
        $estados["AL"] = "Alagoas";
        $estados["AM"] = "Amazonas";
        $estados["AP"] = "Amapá";
        $estados["BA"] = "Bahia";
        $estados["CE"] = "Ceará";
        $estados["DF"] = "Distrito Federal";
        $estados["ES"] = "Espírito Santo";
        $estados["GO"] = "Goiás";
        $estados["MA"] = "Maranhão";
        $estados["MT"] = "Mato Grosso";
        $estados["MS"] = "Mato Grosso do Sul";
        $estados["MG"] = "Minas Gerais";
        $estados["PA"] = "Pará";
        $estados["PB"] = "Paraíba";
        $estados["PR"] = "Paraná";
        $estados["PE"] = "Pernambuco";
        $estados["PI"] = "Piauí";
        $estados["RJ"] = "Rio de Janeiro";
        $estados["RN"] = "Rio Grande do Norte";
        $estados["RO"] = "Rondônia";
        $estados["RS"] = "Rio Grande do Sul";
        $estados["RR"] = "Roraima";
        $estados["SC"] = "Santa Catarina";
        $estados["SE"] = "Sergipe";
        $estados["SP"] = "São Paulo";
        $estados["TO"] = "Tocantins";

        return array_search($pesquisa, $estados);
    }
}