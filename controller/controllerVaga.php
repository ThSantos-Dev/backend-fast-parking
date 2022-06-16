<?php
/*****************************************************************************
 * Objetivo: Arquivo responsável pela manipulação de dados de Vaga (estrutura)
 *              Obs(Este arquivo fará ponte entre a API e a MODEL)
 * Autor: Thales
 * Data: 07/06/2022
 * Versão: 1.0
 */

// Import do arquivo de Modelagem de Vaga
require_once(SRC . 'model/bd/vaga.php');

/**
 * Função responsável por tratar os dados para inserção de Vaga
 * @author Thales Santos
 * @param Array $dados Informações da vaga: código, ativo e IDs: corredor e tipo de veículo
 * @return Bool True se foi inserido, senão um Array com uma mensagem de erro
 */
function inserirVaga($dados) {
    // Validação para verificar se os dados foram passados
    if(!empty($dados)) {
        // Validação para verificar se os campos obrigatórios foram informados: código, IDs: corredor, ativo e tipo de veículo e se são válidos
        if(is_numeric($dados['idCorredor']) && $dados['idCorredor'] > 0 && is_bool($dados['ativo']) && is_numeric($dados['idTipoVeiculo']) && $dados['idTipoVeiculo'] > 0 && is_string($dados['codigo'])){

            // Montando um array com os dados de acordo com o Model
            $vaga = array(
                "idCorredor"    => $dados['idCorredor'],
                "ocupada"       => 0,
                "ativo"         => $dados['ativo'],
                "idTipoVeiculo" => $dados['idTipoVeiculo'],
                "codigo"        => $dados['codigo']
            );

            // Chamando a model responsável por inserir nova vaga
            // Validando o retorno do BD
            if(insertVaga($vaga))
                return true;
            else 
                return MESSAGES['error']['Insert'][0];
        } else 
            return MESSAGES['error']['Data'][1];
    } else 
        return MESSAGES['error']['Data'][0];
}


/**
 * Função responsável por tratar os dados para atualização de Vaga
 * @author Thales Santos
 * @param Array $dados Informações da vaga: código, ativo, ocupada IDs: corredor, status e tipo de veículo
 * @return Bool True se foi inserido, senão um Array com uma mensagem de erro
 */
function atualizarVaga($dados) {
    // Validação para verificar se os dados foram passados
    if(!empty($dados)) {
        // Validação para verificar se os campos obrigatórios foram informados: código, IDs: vaga, corredor, ativo e tipo de veículo e se são válidos
        if(
            is_numeric($dados['id']) && $dados['id'] > 0 &&
            is_numeric($dados['idCorredor']) && $dados['idCorredor'] > 0 &&
            is_numeric($dados['idTipoVeiculo']) && $dados['idTipoVeiculo'] > 0 &&
            is_string($dados['codigo']) && is_bool($dados['ativo']) && is_bool($dados['ocupada'])
        ){
            // Montando um array com os dados de acordo com o Model
            $vaga = array(
                "id"            => $dados['id'],
                "idCorredor"    => $dados['idCorredor'],
                "ativo"         => $dados['ativo'],
                "ocupada"       => $dados['ocupada'],
                "idTipoVeiculo" => $dados['idTipoVeiculo'],
                "codigo"        => $dados['codigo']
            );

            // Chamando a model responsável por atualizar vaga
            // Validando o retorno do BD
            if(updateVaga($vaga))
                return true;
            else 
                return MESSAGES['error']['Update'][0];
        }else {
            return MESSAGES['error']['Data'][0];
        }
    } else 
        return MESSAGES['error']['Data'][0];
}

/**
 * Função responsável por tratar os dados para inativar uma Vaga
 * @author Thales Santos
 * @param Int $id ID da vaga a ser inativada
 * @return Bool True se foi inativada, senão, Array com uma mensagem de erro.
 */
function inativarVaga($id) {
    // Validação para verificar se o id informado é válido
    if(is_numeric($id) && $id > 0) {
        // Validando o retorno  do BD
        if(inactivateVaga($id))
            return true;
        else
            return MESSAGES['error']['Update'][0];
    } else
        return MESSAGES['error']['IDs'][0]; 
}

/**
 * Função responsável por tratar os dados para ativar uma Vaga
 * @author Thales Santos
 * @param Int $id ID da vaga a ser ativada
 * @return Bool True se foi ativada, senão, Array com uma mensagem de erro.
 */
function ativarVaga($id) {
    // Validação para verificar se o id informado é válido
    if(is_numeric($id) && $id > 0) {
        // Validando o retorno  do BD
        if(activateVaga($id))
            return true;
        else
            return MESSAGES['error']['Update'][0];
    } else
        return MESSAGES['error']['IDs'][0]; 
}

/**
 * Função responsável por tratar os dados para ocupar uma Vaga (alteração de atributo)
 * @author Thales Santos
 * @param Int $id ID da vaga a ser ocupada
 * @return Bool True se foi apagado, senão, Array com uma mensagem de erro.
 */
function ocuparVaga($id) {
    // Validação para verificar se o id informado é válido
    if(is_numeric($id) && $id > 0) {
        // Validando o retorno  do BD
        if(toOccupyVaga($id))
            return true;
        else
            return MESSAGES['error']['Update'][0];
    } else
        return MESSAGES['error']['IDs'][0]; 
}
/**
 * Função responsável por tratar os dados para desocupar uma Vaga (alteração de atributo)
 * @author Thales Santos
 * @param Int $id ID da vaga a ser desocupada
 * @return Bool True se foi apagado, senão, Array com uma mensagem de erro.
 */
function desocuparVaga($id) {
    // Validação para verificar se o id informado é válido
    if(is_numeric($id) && $id > 0) {
        // Validando o retorno  do BD
        if(vacateVaga($id))
            return true;
        else
            return MESSAGES['error']['Update'][0];
    } else
        return MESSAGES['error']['IDs'][0]; 
}


/**
 * Função responsável por buscar uma vaga pelo ID
 * @author Thales Santos
 * @param Int $id ID da vaga
 * @return Array Dados encontrados ou Mensagem de erro
 */
function buscarVaga($id) {
    // Validação para verificar se o id informado é válido
    if(is_numeric($id) && $id > 0) {
        // Chamando o arquivo de Model responsável pela busca de Vaga por ID
        $resposta = selectByIdVaga($id);

        // Validação para verificar o retorno do BD
        if(is_array($resposta) && count($resposta) > 0) 
            return $resposta;
        elseif(is_bool($resposta) && $resposta == false)
            return MESSAGES['error']['Select'][0];
    } else 
        return MESSAGES['error']['IDs'][0];

}

/**
 * Função responsável por retornar todos as vagas
 * @author Thales Santos
 * @param Void
 * @return Array Dados encontrados ou Mensagem de erro
 */
function listaVagas() {
    // Chamando a model responsável pela listagem das vagas e validando o seu retorno
    $resposta = selectAllVagas();
    
    // Validação para verificar se há dados retornados
    if(is_array($resposta)) 
        return $resposta;
    elseif(is_bool($resposta) && $resposta == false) 
        return MESSAGES['error']['Select'][0];
}


/**
 * Função responsável por listar as vagas por determinado tipo de Status (Ocupadas = 1, Livres = 0)
 * @author Thales Santos
 * @param Int $status Livres = 0 e Ocupadas = 1
 * @return Array Dados encontrados ou Mensagem de erro
 */
function listaVagasPorStatus($status) {
    // Validação para verificar se o Status é válido
    if(is_bool($status) || is_numeric($status)) {
        // Chamando a função da Model que faz a listagem por status
        $resposta = selectByStatusVaga($status);
        
        // Validando o retorno do BD
        if(is_array($resposta) && count($resposta) > 0)
            return $resposta;
        else 
            return MESSAGES['error']['Select'][0]; 

    } else 
        return MESSAGES['error']['IDs'][0];
}

/**
 * Função responsável por listar as vagas por Tipo de Veículo
 * @author Thales Santos
 * @param Int $id Tipo do veículo desejado
 * @return Array Dados encontrados ou com uma Mensagem de erro
 */
function listaVagasPorTipoVeiculo($id) {
        // Validação para verificar se o ID tipo veiculo é válido
        if(is_numeric($id) && $id > 0) {
            // Chamando a função da Model que faz a listagem por status
            $resposta = selectByTipoVaga($id);
            
            // Validando o retorno do BD
            if(is_array($resposta) && count($resposta) > 0)
                return $resposta;
            else 
                return MESSAGES['error']['Select'][0]; 
    
        } else 
            return MESSAGES['error']['IDs'][0];
}


/**
 * Função responsável por listar as vagas por Tipo de veículo e status (livre, ocupada)
 * @author Thales Santos
 * @param Array $dados Informações da busca: id do tipo de veículo e status (livres = 0 e Ocupadas = 1)
 * @param Array $dados Dados encontrados
 */
function listaVagasPorStatusETipoVeiculo($dados) {
    // Validação para verificar se o Status (Livres = 1, Ocupadas = 0) e Id Tipo Veiculo informado é um ID válido
    if(
        is_numeric($dados['idTipoVeiculo']) && $dados['idTipoVeiculo'] > 0
        && is_bool($dados['ocupada']) || is_numeric($dados['ocupada'])
    ) { 
        // Verificando se ocupada é um booleano e false, alterando seu valor para 1 ou 0
        $dados['ocupada'] == false || $dados['ocupada'] == 0 ? $dados['ocupada'] = 0 : $dados['ocupada'] = 1;

        // Chamando a função da Model que faz a listagem por status
        $resposta = selectByStatusAndTipoVaga($dados);
        
        // Validando o retorno do BD
        if(is_array($resposta) && count($resposta) > 0)
            return $resposta;
        else 
            return MESSAGES['error']['Select'][0]; 

    } else 
        return MESSAGES['error']['IDs'][0];
}

/**
 * Função reponsável por retornar a quantidade de vagas do estacionamento
 * @author Thales Santos
 * @param Void
 * @return Int Quantidade de vagas
 */
function quantidadeVagas() {
    // Chamando a model responsável por retornar a quantidade de vagas encontradas
    $quantidade = countVagas();

    // Validação para verificar se houve uma quantidade retornada
    if(is_numeric($quantidade))
        return $quantidade;
    else 
        return MESSAGES['error']['Select'][0];

}


/**
 * Função responsável por retornar a quantidade de vagas livres ou ocupadas
 * @author Thales Santos
 * @param Tinyint $status 0 para livres e 1 para ocupadas
 * @return Int Quantidade de vagas
 */
function quantidadeVagasPorStatus($status) {
    // Validação para verificar se o $status informado é válido
    if(is_numeric($status) && ($status == 0 || $status == 1)){
        // Chamando a model responsável por retornar a quantidade de vagas encontradas
        $quantidade = countVagasStatus($status);

        // Validação para verificar se houve uma quantidade retornada
        if(is_numeric($quantidade))
            return $quantidade;
        else 
            return MESSAGES['error']['Select'][0];

    } else
        return MESSAGES['error']['Data'][1];
}

/**
 * Função responsável por retornar a quantidade de vagas livres ou oucpadas de acordo com o tipo de veículo
 * @author Thales Santos
 * @param Array $dados Dados da busca: status (0 livres, 1 oucpadas) e id do tipo de veículo desejado
 * @return Int Quantidade de vagas
 */
function quantidadeVagasPorStatusETipoVeiculo($dados) {
    // Validação para verificar se foram passados dados para a pesquisa
    if(!empty($dados)){
        // Validação para verificar se os campos obrigatórios foram preenchidos
        if(is_numeric($dados['status']) && ($dados['status'] == 0 || $dados['status'] == 1) && is_numeric($dados['idTipoVeiculo']) && $dados['idTipoVeiculo'] > 0){
            // Chamando a model responsável por retornar a quantidade de vagas encontradas
            $quantidade = countVagasStatusAndTipo($dados);

            // Validação para verificar se houve uma quantidade retornada
            if(is_numeric($quantidade))
                return $quantidade;
            else 
                return MESSAGES['error']['Select'][0];
        } else
            return MESSAGES['error']['Data'][1];
    } else 
        return MESSAGES['error']['Data'][0];
}


?>