<?php
/*****************************************************************************
 * Objetivo: Arquivo responsável pela manipulação de dados de Movimentação (entrada / saida)
 *              Obs(Este arquivo fará ponte entre a API e a MODEL)
 * Autor: Thales
 * Data: 08/06/2022
 * Versão: 1.0
 */

// Import do arquivo de Configurações
require_once('../module/config.php');

// Import do arquivo de Modelagem de Movimentação
require_once(SRC . 'model/bd/movimentacao.php');

/**
 * Função responsável por registrar uma Entrada
 * @author Thales Santos
 * @param Array $dados Dados: id do veículo e da vaga
 * @return Array Dados da entrada gerada ou mensagem de erro
 */
function registrarEntrada($dados) {
    // Validação para verificar se há dados para inserção
    if(!empty($dados)){
        // Validação para verificar se os ids foram passados e se são válidos
        if(
            is_numeric($dados['idVeiculo']) && $dados['idVeiculo'] > 0
            && is_numeric($dados['idVaga']) && $dados['idVaga'] > 0
        ) {

            // Chamando a model para inserir a Movimentação
            $resposta = insertMovimentacao($dados);
                        
            if(is_numeric($resposta) && $resposta > 0) {
                // Chamando a model para buscar as informações de registro
                $dados = selectByIdMovimentacao($resposta);

                // Validando o retorno do BD
                if(is_array($dados)) 
                    return $dados;
                elseif(is_bool($dados) && $dados == false)
                    return MESSAGES['error']['IDs'][1];
            }
            else
                return MESSAGES['error']['Insert'][0];
        } else
            return MESSAGES['error']['IDs'][0];

    } else 
        return MESSAGES['error']['Data'][0];

}

/**
 * Função responsével por registrar uma saida
 * @author Thales Santos
 * @param Int $id ID da movimentação 
 * @return Array Dados atualizados ou mensagem de erro
 */
function registrarSaida($id) {
    // Validação para verificar se o id informado é válido
    if(is_numeric($id) && $id > 0) {
        // Chamando a model que realiza o cálculo de quanto o cliente deverá pagar
        $resposta = calculateOutput($id);
        
        // Validação para verificar o retorno do BD
        if(is_array($resposta)) {
            // Montando um array com os dados de acordo com o Model
            $dados = array(
                "id"        => $resposta['id'],    
                "dataSaida" => $resposta['saida']['data'],
                "horaSaida" => $resposta['saida']['horario'],
                "valor"     => $resposta['valor']
            );

            // Atualizando o registro com a data/hora de saída e o valor que cliente pagou
           $atualizou = updateMovimentacao($dados);

           if($atualizou) 
                return $resposta;
            else
                return MESSAGES['error']['Update'][0];
        }
        elseif(is_bool($resposta) && $resposta == false)
            return MESSAGES['error']['IDs'][1];
    } else
        return MESSAGES['error']['IDs'][0];
}

/**
 * Função responsável por buscar uma movimentação pelo ID 
 * @author Thales Santos
 * @param Int $id ID da movimentação
 * @return Array Dados da movimentação
 */
function buscaMovimentacao($id) {
    // Validação para verificar se o id informado é válido
    if(is_numeric($id) && $id > 0) {
        // Chamando a model para buscar o registro
        $resposta = selectByIdMovimentacao($id);

        // Validando o retorno do BD 
        if(is_array($resposta)) 
            return $resposta;
        elseif(is_bool($resposta) && $resposta == false) 
            return false; 
    } else
        return MESSAGES['error']['IDs'][0];
}









?>