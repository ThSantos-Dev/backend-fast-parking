<?php
    /**********************************************************************************************
     * Objetivo: Arquivo principal da API que irá receber a URL requisitada para as APIs (router)
     * Data: 19/05/2022
     * Autor: Thales
     * Versão: 1.0
     *********************************************************************************************/

    // Permite ativar quais endereços de sites que poderão fazer requisições na API (* libera para todos os sites)
    header('Access-Control-Allow-Origin: *');

    // Permite ativar os métodos do protocolo HTTP que irão requisitar a API
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');

    // Permite ativar o 'Content-Type' das requisições (formato de dados que será utilizado (JSON, XML, FORM/DATA, etc...))
    header('Access-Control-Allow-Header: Content-Type');

    // Permite liberar quais 'Content-Type' serão utilizados na API
    header('Content-Type: application/json');

    // Recebe a url digitada na requisição
    $urlHTTP = (string) $_GET['url'];

    // Converte a URL Requisitada em um Array para dividir as opções de busca, que é separada pela barra '/'
    $url = explode('/', $urlHTTP);

    // Verifica a qual API será encaminhada a requisição
    switch(strtoupper($url[0])) {
        case 'MOVIMENTACAO':
            require_once('movimentacaoAPI/index.php');
            break;
        case 'VEICULO':
            require_once('veiculoAPI/index.php');
            break;
        case 'VAGA':
            require_once('vagaAPI/index.php');
            break;
        case 'PRECO':
            require_once('precoAPI/index.php');
            break;
        case 'RELATORIO':
            require_once('relatorioAPI/index.php');
            break;
        case 'COR':
            require_once('corAPI/index.php');
            break;
        case 'TIPO':
            require_once('tipoVeiculoAPI/index.php');
            break;
    }
































?>