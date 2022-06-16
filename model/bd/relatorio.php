<?php

/**
 * Objetivo: Arquivo de funções que manipularão o BD
 * Autor: Thales Santos
 * Data: 13/06/2022
 * Versão: 2.0
 */

// Import do arquivo responsável pela Conexão do BD 
require_once('conexaoMySQL.php');

/**
 * Função responsável por gerar o relatório de rendimentos diário
 * @author Thales Santos
 * @param Date $data Data desejada 
 * @return Array Rendimentos da data
 */
function dailyReport($data) {
    // Abrindo a conexão com o BD
    $conexao = conexaoMySQL();

    // Script SQL para obter o rendimento gerado por determinada data
    $sql = "SELECT 
	            FORMAT(SUM(tblMovimentacao.valor), 2, 'de_DE') AS rendimento,
                DATE_FORMAT('{$data}', '%d/%m/%Y') AS data

	            FROM tblMovimentacao
		
            WHERE tblmovimentacao.dataSaida = '{$data}'";

    $resposta = mysqli_query($conexao, $sql);

    // Validação para verificar se houve retorno por parte do BD
    if($resposta) {
        // Convertendo os dados obtidos em array
        if($resultado = mysqli_fetch_assoc($resposta))
            // Montando um Array com os dados encontrados
            $arrayDados = array(
                "data" => $resultado['data'],
                "rendimento" => $resultado['rendimento']
            );
    }

    // Solicitando o fechamento da conexão com BD
    fecharConexaoMySQL($conexao);

    // Validação para verificar se há dados para serem retornados
    return isset($arrayDados) ? $arrayDados : false;
}

/**
 * Função responsável por gerar o relatório de rendimentos Mensal
 * @author Thales Santos
 * @param Date $data Data desejada 
 * @return Array Rendimentos da data
 */
function monthReport($data) {
    // Abrindo a conexão com o BD
    $conexao = conexaoMySQL();

    // Script SQL para obter o rendimento gerado por determinada data
    $sql = "SELECT 
                FORMAT(SUM(tblMovimentacao.valor), 2, 'de_DE') AS rendimento,
                DATE_FORMAT('{$data['ano']}-{$data['mes']}-00', '%m/%Y') AS data

                FROM tblMovimentacao
        
            WHERE MONTH(tblmovimentacao.dataSaida) = {$data['mes']}
                AND YEAR(tblmovimentacao.dataSaida) = {$data['ano']}";

    $resposta = mysqli_query($conexao, $sql);

    // Validação para verificar se houve retorno por parte do BD
    if($resposta) {
        // Convertendo os dados obtidos em array
        if($resultado = mysqli_fetch_assoc($resposta))
            // Montando um Array com os dados encontrados
            $arrayDados = array(
                "data" => $resultado['data'],
                "rendimento" => $resultado['rendimento']
            );
    }

    // Solicitando o fechamento da conexão com BD
    fecharConexaoMySQL($conexao);

    // Validação para verificar se há dados para serem retornados
    return isset($arrayDados) ? $arrayDados : false;
}


/**
 * Função responsável por gerar o relatório de rendimentos Anual
 * @author Thales Santos
 * @param Date $ano ano desejado 
 * @return Array Rendimentos do ano 
 */
function yearReport($ano) {
    // Abrindo a conexão com o BD
    $conexao = conexaoMySQL();

    // Script SQL para obter o rendimento gerado por determinada data
    $sql = "SELECT 
	            FORMAT(SUM(tblMovimentacao.valor), 2, 'de_DE') AS rendimento,
                '{$ano}' AS data

	            FROM tblMovimentacao
		
            WHERE YEAR(tblmovimentacao.dataSaida) = {$ano}";

    $resposta = mysqli_query($conexao, $sql);

    // Validação para verificar se houve retorno por parte do BD
    if($resposta) {
        // Convertendo os dados obtidos em array
        if($resultado = mysqli_fetch_assoc($resposta))
            // Montando um Array com os dados encontrados
            $arrayDados = array(
                "data" => $resultado['data'],
                "rendimento" => $resultado['rendimento']
            );
    }

    // Solicitando o fechamento da conexão com BD
    fecharConexaoMySQL($conexao);

    // Validação para verificar se há dados para serem retornados
    return isset($arrayDados) ? $arrayDados : false;
}

/**
 * Função responsável por listar os dias que trouxe rendimentos ao estacioanamento
 * @author Thales Santos
 * @param Void
 * @return Array
 */
function getDays() {
    // Abrindo a conexão com o BD
    $conexao = conexaoMySQL();

    // Script SQL para listar os dias que trouxe rendimentos
    $sql = "SELECT 
	            DISTINCT(tblmovimentacao.dataSaida) AS data

    
                FROM tblmovimentacao
            WHERE tblmovimentacao.valor IS NOT NULL
                ORDER BY tblmovimentacao.dataSaida DESC";

    
    $resposta = mysqli_query($conexao, $sql);

    // Validação para verificar o retorno
    if($resposta) {
        // Convertendo os dados em Array
        $contador = 0;
        while($resultado = mysqli_fetch_assoc($resposta)) {
            // Montando um Array com os dados
            $arrayDados[$contador] = array(
                "data" => $resultado['data']
            );

            // Incrementando o contador
            $contador++;
        }
    }

    // Solitando o fechamento da conexão com o BD
    fecharConexaoMySQL($conexao);

    // Retornando os dados encontrados ou false
    return isset($arrayDados) ? $arrayDados : false;
}

/**
 * Função responsável por listar os meses que trouxe rendimentos ao estacioanamento
 * @author Thales Santos
 * @param Void
 * @return Array
 */
function getMonths() {
    // Abrindo a conexão com o BD
    $conexao = conexaoMySQL();

    // Script SQL para listar os dias que trouxe rendimentos
    $sql = "SELECT 
                DISTINCT(DATE_FORMAT(tblMovimentacao.dataSaida, '%m/%Y')) AS mes

                FROM tblmovimentacao
            WHERE tblmovimentacao.valor IS NOT NULL
                ORDER BY tblmovimentacao.dataSaida DESC";

    
    $resposta = mysqli_query($conexao, $sql);

    // Validação para verificar o retorno
    if($resposta) {
        // Convertendo os dados em Array
        $contador = 0;
        while($resultado = mysqli_fetch_assoc($resposta)) {
            // Montando um Array com os dados
            $arrayDados[$contador] = array(
                "mes" => $resultado['mes']
            );

            // Incrementando o contador
            $contador++;
        }
    }

    // Solitando o fechamento da conexão com o BD
    fecharConexaoMySQL($conexao);

    // Retornando os dados encontrados ou false
    return isset($arrayDados) ? $arrayDados : false;
}

/**
 * Função responsável por listar os anos que trouxe rendimentos ao estacionamento
 * @author Thales Santos
 * @param Void
 * @return Array
 */
function getYears() {
    // Abrindo a conexão com o BD
    $conexao = conexaoMySQL();

    // Script SQL para listar os ANOS em que há rendimentos
    $sql = "SELECT 
                DISTINCT(YEAR(tblmovimentacao.dataSaida)) AS ano

                FROM tblmovimentacao
            WHERE tblmovimentacao.valor IS NOT NULL
                ORDER BY tblmovimentacao.dataSaida DESC";

    $resposta = mysqli_query($conexao, $sql);

    // Validando o retorno do BD
    if($resposta) {
        // Convertendo os dados em Array
        $contador = 0;
        while($resultado = mysqli_fetch_assoc($resposta)) {
            // Montando um Array com os dados
            $arrayDados[$contador] = array(
                "ano" => $resultado['ano']
            );

            // Incrementando o contador
            $contador++;
        }
    }

    // Solitando o fechamento da conexão com o BD
    fecharConexaoMySQL($conexao);

    // Retornando os dados encontrados ou false
    return isset($arrayDados) ? $arrayDados : false;
}



?>