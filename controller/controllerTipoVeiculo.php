<?php
// ______________________________________________________________
// Objetivo: Arquivo responsável pela manipulação de dados de contatos
//            Obs(Este arquivo fará ponte entre a VIEW e a MODEL)
// Autor: Vívian Guimaães Vaz
//Data: 10/006/2022
//versão: 1.0
//________________________________________________________________________

//inportação do arquivo de configuração do projeto 
require_once('../module/config.php');

//inporte do arqquivo de modelagem do tipo de veiculo
require_once(SRC.'model/bd/tipoVeiculo.php');


function inserirTipoVeiculo($nome){

    //validação para verificar se há conteúdo para inserção do tipo do veiculo
    if(!empty($nome)){

        //validação para informar se o campo obrigatório 'nome foi informado'
        if(!empty($nome)){
            //chamar a model e passar a cor 
            if(insertTipoVeiculo($nome))
                return true;
            else 
                return MESSAGES['error']['Insert'][0];
        }else
            return MESSAGES['error']['Data'][1]; 
    }else
     return MESSAGES['error']['Data'][0];
}

$nome = "canoa";

//echo (inserirTipoVeiculo($nome));


/**
 * Função responsável por tratar os dados para atuzalização do tipo de veiculos
 * @author Vívian Guimarães Vaz
 * @param Array $nome- nome da cor 
 * @return Bool True se o registro foi atualizado ou um Array com uma mensagem de erro
 */
function atualizarTipoVeiculo($dados){

    // Validação para verificar se o id está correto
    if(is_numeric($dados['id']) && $dados['id'] > 0){

            // Validação para verificar se o campo obrigatório 'Nome'  foi informado
            if(!empty($dados['nome'])){

            // Chamando a model e passando os dados 
            if(updateTipoVeiculo($dados))
                    return true;
                else
                    return MESSAGES['error']['Insert'][0];

            }else
                return MESSAGES['error']['IDs'][0] . " ID do tipo de veiculo é inválido";
        } else 
                return MESSAGES['error']['Data'][1];
}

$dados= array(
    "nome"      => "violeta",
      "id"      => 16
     
     
  );

//print_r(atualizarTipoVeiculo($dados));




/**
 * Função responsável por retornar os tipo de veiculos cadastradas 
 * @author Vívian Guimarães Vaz
 * @param Array void
 * @return Bool as cores encontradas ou mnessagem de erro
 */
function listaTipoVeiculo() {
    // Chamando a função responsável por retornar o nome das cores
    $resposta = selectAllTipoVeiculo();

    // Validação para verificar se houve retorno de dados por parte do BD
    if(is_array($resposta) && count($resposta) > 0)  
        return $resposta;
    elseif(is_bool($resposta) && $resposta == false) 
        return MESSAGES['error']['Select'][0];
}

//print_r(listaTipoVeiculo());


/**
 * Função responsável por buscar informações do tipo de veiculo pelo ID
 * @author Vívian Guimarães Vaz
 * @param Int $id ID do tipo de veiculo
 * @return Array Dados encontrados ou mensagem de erro
 */
function buscaTipoVeiculo($id) {
    // Validação para verificar se o ID informado é um ID válido
    if(is_numeric($id) && $id > 0) {
        // Chamando a model para busca de corredor por ID 
        $resposta = selectByIdTipoVeiculo ($id);

        // Validação para verificar o retorno do BD
        if(is_array($resposta)) 
            return $resposta;
        else
            return MESSAGES['error']['Data'][0];
    }
}

//print_r(buscaTipoVeiculo(10));
?>