<?php
/*****************************************************************************
 * Objetivo: Arquivo responsável pela manipulação de dados de Veiculo
 *              Obs(Este arquivo fará ponte entre a API e a MODEL)
 * Autor: Thales
 * Data: 07/06/2022
 * Versão: 1.0
 */


// Import do arquivo de Modelagem de Vaga
require_once(SRC . 'model/bd/veiculo.php');

/**
 * Função responsável por inserir novo Veículo
 * @author Thales Santos
 * @param Array $dados Informações do veículo: placa, fabricante, modelo, Id: cor, tipo do veículo e cliente
 * @return Int ID do veículo inserido ou um Array com uma mensagem de erro.
 */
function inserirVeiculo($dados){
    // Validação para verificar se há dados para serem inseridos
    if(!empty($dados)) {
        // Validação para verificar se os campos obrigatórios foram preenchidos
        // Placa, Fabricante, Modelo, IDs: cor, tipo do veículo e cliente
        if(
            !empty($dados['placa']) && strlen($dados['placa']) >= 7 && strlen($dados['placa']) < 10
            && !empty($dados['fabricante']) && !empty($dados['modelo'])
            && is_numeric($dados['idCor']) && $dados['idCor'] > 0  
            && is_numeric($dados['idTipoVeiculo']) && $dados['idTipoVeiculo'] > 0  
            && is_numeric($dados['idCliente']) && $dados['idCliente'] > 0  
        ){  
            // Validação para verificar se o veículo já está estacionado
            $estacionado = selectByEstacionadoAndPlaca($dados['placa']);

            if(is_bool($estacionado) && $estacionado == false) {
                // Chamando a model e passando os dados para inserir Veículo
                $resposta = insertVeiculo($dados);
    
                // Validação para verificar o retorno do BD
                if(is_numeric($resposta) && $resposta > 0) 
                    return $resposta;
                elseif(is_bool($resposta) && $resposta == false)
                    return MESSAGES['error']['Insert'][0];
            } else 
                return MESSAGES['error']['Insert'][0];

        }

    } else 
        return MESSAGES['error']['Data'][0];

}

/**
 * Função responsável por listar todos os veiculos e suas movimentações
 * @author Thales Santos
 * @param Void
 * @return Array Dados encontrados ou uma mensagem de erro
 */
function listaVeiculos() {
    // Chamando a model que lista os veiculos
    $resposta = selectAllVeiculos();

    // Validação para verificar o retorno do BD
    if(is_array($resposta)) 
        return $resposta;
    elseif(is_bool($resposta) && $resposta == false)
        return MESSAGES['error']['Select'][0];
}

/**
 * Função responsável por listar todos os veiculos que tiveram a saida registrada e suas movimentações
 * @author Thales Santos
 * @param Void
 * @return Array Dados encontrados ou uma mensagem de erro
 */
function listaVeiculosSaida() {
    // Chamando a model que lista os veiculos
    $resposta = selectBySaida();

    // Validação para verificar o retorno do BD
    if(is_array($resposta)) 
        return $resposta;
    elseif(is_bool($resposta) && $resposta == false)
        return MESSAGES['error']['Select'][0];
}




/**
 * Função responsável por listar todos os veiculos estacionados e suas movimentações
 * @author Thales Santos
 * @param Void
 * @return Array Dados encontrados ou uma mensagem de erro
 */
function listaVeiculosEstacionados() {
        // Chamando a model que lista os veiculos estacionados
        $resposta = selectByEstacionado();

        // Validação para verificar o retorno do BD
        if(is_array($resposta)) 
            return $resposta;
        elseif(is_bool($resposta) && $resposta == false)
            return MESSAGES['error']['Select'][0];
}

/**
 * Função responsável por listar todos os veiculos de determinado tipo
 * @author Thales Santos
 * @param Int $id ID do tipo de veiculo
 * @return Array Dados encontrados ou uma mensagem de erro
 */
function listaVeiculosPorTipo($id) {
    // Validação para verificar se o id informado é válido
    if(is_numeric($id) && $id > 0) {
        // Chamando a model e passando o id do tipo de veiculo
        $resposta = selectByTipo($id);

        // Validação para verificar o retorno do BD
        if(is_array($resposta)) 
            return $resposta;
        else 
            return MESSAGES['error']['Select'][0];
    } else
        return MESSAGES['error']['IDs'][0];
}

/**
 * Função responsável por listar todos os veiculo por Placa
 * @author Thales selectAllMovimentacoes
 * @param String $placa Placa do veiculo
 * @return Array Dados encontrados ou uma mensagem de erro
 */
function listaVeiculosPorPlaca($placa) {
    // Validação para verificar se a placa informada é válida
    if(!empty($placa) && strlen($placa) >= 7 && strlen($placa) <= 8) {
        // Chamando a model e passando a placa do veiculo
        $resposta = selectByPlaca($placa);

        // Validação para verificar o retorno do BD
        if(is_array($resposta)) 
            return $resposta;
        else 
            return MESSAGES['error']['Select'][0];
    } else
        return MESSAGES['error']['IDs'][0];
}

/**
 * Função responsável por listar todos os veiculos estacionados por placa
 * @author Thales Santos
 * @param String $placa Placa do veiculo
 * @return Array Dados encontrados ou uma mensagem de erro
 */
function listaVeiculosEstacionadosPorPlaca($placa) {
    // Validação para verificar se a placa informada é válida
    if(!empty($placa) && strlen($placa) >= 7 && strlen($placa) < 10) {
        // Chamando a model e passando a placa do veiculo
        $resposta = selectByEstacionadoAndPlaca($placa);

        // Validação para verificar o retorno do BD
        if(is_array($resposta)) 
            return $resposta;
        else 
            return MESSAGES['error']['Select'][0];
    } else
        return MESSAGES['error']['IDs'][0];
}

/**
 * Função responsável por listar todos os veiculos estacionados por placa
 * @author Thales Santos
 * @param Int $id Tipo do veiculo
 * @return Array Dados encontrados ou uma mensagem de erro
 */
function listaVeiculosEstacionadosPorTipo($id) {
    // Validação para verificar se o id informado é válido
    if(is_numeric($id) && $id > 0) {
        // Chamando a model e passando o id do tipo de veiculo
        $resposta = selectByEstacionadoAndTipo($id);

        // Validação para verificar o retorno do BD
        if(is_array($resposta)) 
            return $resposta;
        else 
            return MESSAGES['error']['Select'][0];
    } else
        return MESSAGES['error']['IDs'][0];
}





?>