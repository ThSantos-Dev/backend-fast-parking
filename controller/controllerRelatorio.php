<?php
/*****************************************************************************
 * Objetivo: Arquivo responsável pela manipulação de dados de Relatório
 *              Obs(Este arquivo fará ponte entre a API e a MODEL)
 * Autor: Thales
 * Data: 06/06/2022
 * Versão: 1.0
 */

// Import do arquivo de Configurações
require_once('../module/config.php');

// Import do arquivo de Modelagem de Relatório
require_once(SRC . 'model/bd/relatorio.php');

/**
 * Função responsável por trazer o relatório diário de rendimentos
 * @author Thales Santos
 * @param Date $data Data desejada
 * @return Array Dados encontrados
 */
function geraRelatorioDiario($data) {
    // Validação para verificar se a data informada é uma data válida
    if(!empty($data)){
        // Chamando a model para listar o rendimento diário de acordo com a data especificada
        $resposta = dailyReport($data);

        // Validação para verificar o retorno do BD
        if(is_array($resposta)) 
            // Retornando os dados 
            return $resposta;
        else 
            return MESSAGES['error']['Select'][0];

    } else 
        return MESSAGES['error']['Data'][1];
}

/**
 * Função reponsável por trazer o relatório mensal de rendimentos
 * @author Thlaes Santos
 * @param Array $data Mês e Ano desejado
 * @return Array Dados encontrados
 */
function geraRelatorioMensal($data) {
    // Validação para verificar se a data foi informada
    if(!empty($data)) {
        // Validação para verificar se a data foi informada é válida
        if(!empty($data['ano']) && !empty($data['mes'])){
            // Chamando a model para trazer o relatório de rendendimentos de acordo com o mês
            $resposta = monthReport($data);

            // Validação para verificar o retorno do BD
            if(is_array($resposta)) 
                return $resposta;
            elseif(is_bool($resposta) && $resposta == false) 
                return MESSAGES['error']['Select'][0];
        } else 
            return MESSAGES['error']['Data'][1];
    } else 
        return MESSAGES['error']['Data'][0];
}

/**
 * Função responsável por trazer o relatório anual de rendimentos
 * @author Thales Santos
 * @param String $ano Ano desejado (04 dígitos)
 * @return Array Dados encontrados
 */
function geraRelatorioAnual($ano) {
    // Validação para verificar se o ANO é válido
    if(strlen($ano) == 4) {
        // Chamando a model que retorna os rendimentos do ano 
        $resposta = yearReport($ano);

        // Validação para verificar o retorno do BD
        if(is_array($resposta)) 
            return $resposta;
        else 
            return MESSAGES['error']['Select'][0];
    } else 
        return MESSAGES['error']['Data'][1] . "Formato inválido.";
}

/**
 * Função responsável por trazer os Dias que possuem rendimentos
 * @author Thales Santos
 * @param Void
 * @return Array Dias (datas: yyyy-mm-dd)
 */
function listaDias() {
    // Chamando a model que lista os dias de rendimento
    $resposta = getDays();

    // Validação para verificar o retorno do BD
    if(is_array($resposta))
        return $resposta;
    else 
        return MESSAGES['error']['Select'][0];
}

/**
 * Função responsável por trazer os Meses que possuem rendimentos
 * @author Thales Santos
 * @param Void
 * @return Array Meses (datas: yyyy-mm)
 */
function listaMeses() {
    // Chamando a model que lista os Meses de rendimento
    $resposta = getMonths();

    // Validação para verificar o retorno do BD
    if(is_array($resposta))
        return $resposta;
    else 
        return MESSAGES['error']['Select'][0];
}

/**
 * Função responsável por trazer os anos que possuem rendimentos
 * @author Thales Santos
 * @param Void
 * @return Array Anos (yyyy)
 */
function listaAnos() {
    // Chamando a model que lista os Anos de rendimento
    $resposta = getYears();

    // Validação para verificar o retorno do BD
    if(is_array($resposta))
        return $resposta;
    else 
        return MESSAGES['error']['Select'][0];
}

/**
 * Função responsável por trazer um relatorio completo
 * @author Thales Santos
 * @param Void
 * @return Array Dados encontrados 
 */
function geraRelatorio() {
     // Gerando o relatorio - Diário
     $dias = listaDias();
     $relatorioDiario = array();
 
     // Obtendo valores
     foreach($dias as $dia) {
        // Obtendo o relátorio de cada data
         $detalhes = geraRelatorioDiario($dia['data']);
 
        //  Montando um array com os dados
         $rendimento = array(
             "data" => $detalhes['data'],
             "rendimento" => $detalhes['rendimento']
         );
 
        //  Adicionando os dados ao Array Principal
         array_push($relatorioDiario, $rendimento);
     }
 
     // Gerando o relatorio - Mensal
     $meses = listaMeses();
     $relatorioMensal = array();
 
     // Obtendo valores
     foreach($meses as $mes) {
 
         // Separando o mês do ano
         $data = array(
             "mes" => explode("/", $mes['mes'])[0],
             "ano" => explode("/", $mes['mes'])[1]
         );

        //  Obtendo o relátorio de cada data
         $detalhes = geraRelatorioMensal($data);
 
        //  Montando um array com os dados
         $rendimento = array(
             "data" => $detalhes['data'],
             "rendimento" => $detalhes['rendimento']
         );
 
        //  Adicionando os dados ao Array Principal
         array_push($relatorioMensal, $rendimento);
     }
 
     // Gerando o relatorio - Anual
     $anos = listaAnos();
     $relatorioAnual = array();
 
     // Obtendo valores
     foreach($anos as $ano) {
        // Obtendo o relátorio de cada data
         $detalhes = geraRelatorioAnual($ano['ano']);
 
        //  Montando um array com os dados
         $rendimento = array(
             "data" => $detalhes['data'],
             "rendimento" => $detalhes['rendimento']
         );
 
        //  Adicionando os dados ao Array Principal
         array_push($relatorioAnual, $rendimento);
     }
 
 
         // Montando um Array com o relatorio
         $relatorio = array(
             "diario"    => $relatorioDiario,
             "mensal"    => $relatorioMensal,
             "anual"     => $relatorioAnual
         );

        //  Retornando o relatorio
        return $relatorio;
}

?>