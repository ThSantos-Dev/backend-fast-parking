<?php
/*****************************************************************************
 * Objetivo: Arquivo responsável pela manipulação de dados de Preço
 *              Obs(Este arquivo fará ponte entre a API e a MODEL)
 * Autor: Thales
 * Data: 06/06/2022
 * Versão: 1.0
 */

// Import do arquivo de Configurações
require_once('../module/config.php');

// Import do arquivo de Modelagem de Preço
require_once(SRC . 'model/bd/preco.php');

/**
 * Função responsável por tratar os dados para inserção de Preço
 * @author Thales Santos
 * @param Array $dados Informações do Preço: Valor da primeira e demais horas e ID do tipo de veículo
 */
function inserirPreco($dados) {
    // Validação para verificar se foi passado conteúdo para inserção
    if(!empty($dados)){
        // Validação para verificar se os campos obrigatórios foram preenchidos (Valores: primeira e demais horas e ID do tipo de veículo)
        if(is_numeric($dados['primeiraHora']) && $dados['primeiraHora'] > 0 && is_numeric($dados['demaisHoras']) && $dados['demaisHoras'] > 0 && is_numeric($dados['idTipoVeiculo']) && $dados['idTipoVeiculo'] > 0){
            // Validação para verificar se o preço do tipo de veículo informado já existe
            $existe = verifyTypePreco($dados['idTipoVeiculo']);

            if($existe) 
                return MESSAGES['error']['Insert'][0];

            // Chamando a model e passando os dados para inserção de Preço
            $resposta = insertPreco($dados);

            // Validação para verificar o retorno da model
            if($resposta) 
                return true;
            else 
                return MESSAGES['error']['Insert'][0];
        } else 
            return MESSAGES['error']['Data'][1];

    } else
        return MESSAGES['error']['Data'][0];
}
/**
 * Função responsável por tratar os dados para atualização de Preço
 * @author Thales Santos
 * @param Array $dados Informações do Preço: Valor da primeira e demais horas e ID do tipo de veículo
 */
function atualizarPreco($dados) {
    // Validação para verificar se foi passado conteúdo para inserção
    if(!empty($dados)){
        // Validação para verificar se os campos obrigatórios foram preenchidos (Valores: primeira e demais horas e ID do tipo de veículo)
        if(is_numeric($dados['primeiraHora']) && $dados['primeiraHora'] > 0 && is_numeric($dados['demaisHoras']) && $dados['demaisHoras'] > 0 && is_numeric($dados['idTipoVeiculo']) && $dados['idTipoVeiculo'] > 0){
            // Chamando a model e passando os dados para inserção de Preço
            // Validação para verificar o retorno da model
            if(updatePreco($dados)) 
                return true;
            else 
                return MESSAGES['error']['Update'][0];
        } else 
            return MESSAGES['error']['Data'][1];

    } else
        return MESSAGES['error']['Data'][0];
}

/**
 * Função responsável por tratar os dados para excluir um preço
 * @author Thales Santos
 * @param Int ID do Preço a ser apagado
 * @return Bool True se foi apagado ou Array com mensagem de erro
 */
function excluirPreco($id) {
    // Validação para verificar se o id informado é válido
    if(is_numeric($id) && $id > 0) {
        // Chamando a model que apaga um Preço
        // Validação para verificar o retorno do BD
        if(deletePreco($id)) 
            return true;
        else 
            return MESSAGES['error']['Delete'][0];    
    } else
        return MESSAGES['error']['IDs'][0];
}

/**
 * Função responsável por listar os dados de Preço
 * @author Thales Santos
 * @param Void
 * @return Array Dados encontrados ou false caso não haja dados
 */
function listaPrecos() {
    // Chando a model que lista os Preços
    $resposta = selectAllPrecos();

    // Validando o retorno do BD
    if(is_array($resposta) && count($resposta) > 0)
        return $resposta;
    elseif(is_bool($resposta) && $resposta == false)  
        return MESSAGES['error']['Select'][0];
}

?>