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

//inporte do arqquivo de modelagem do Setor
require_once(SRC.'model/bd/setor.php');


/**
 *Função responsável por tratar os dados para inserção do nome do Setor
 *@author Vívian Guimaraes Vaz
 *@param Array $dados Informações do  Setor - nome, ativo e idPiso
 *@return Bool True se foi inserido, se não Array com uma mensagem de erro
 */
function inserirSetor($dados){

    //validação para verificar se há conteúdo para inserção do Setor 
    if(!empty($dados)){

        // Validação para verificar se o campo obrigatório 'Nome', 'idPiso', 'Ativo' foi informado
        if(!empty($dados['nome']) && !empty($dados['ativo']) && !empty($dados['idPiso']) ){

             // Validação para verificar se o ID do setor é válido
             if(is_numeric($dados['idPiso']) && $dados['idPiso'] > 0) {

                // Chamando a model e passando os dados 
                if(insertSetor($dados))
                    return true;
                else
                    return MESSAGES['error']['Insert'][0];
             }else
                 return MESSAGES['error']['IDs'][0];
        }else 
            return MESSAGES['error']['Data'][1];
    }else
      return MESSAGES['error']['Data'][0];    
}

//print_r(inserirSetor($dados));

/**
 *Função responsável por tratar os dados para atualizar do setor
 *@author Vívian Guimaraes Vaz
 *@param Array $dados Informações do  Setor - nome, ativo e idPiso
 *@return Bool True se foi atualizado, se não Array com uma mensagem de erro
 */
function atualizarSetor($dados) {

    // Validação para verificar se há conteúdo para atualização de Setor
    if(!empty($dados)){

        if(is_numeric($dados['id']) && $dados['id'] > 0){

            // Validação para verificar se o campo obrigatório 'Nome' e 'idPIso' foi informado
            if(!empty($dados['nome']) && !empty($dados['idPiso']) && !empty($dados['ativo'])){

                // Validação para verificar se o ID do Piso é válido
                if(is_numeric($dados['idPiso']) && $dados['idPiso'] > 0) {

                     // Montando um array com os dados de acordo com o Model
                     $Setor = array(

                        "idPiso" => $dados['idPiso'],
                        "nome"    => $dados['nome'],
                        "ativo"   => $dados['ativo'],
                        "id"   => $dados['id']
                    );
                
                // Chamando a model e passando os dados 
                if(updateSetor($Setor))
                     return true;
                 else
                    return MESSAGES['error']['Insert'][0];
                
                } else
                     return MESSAGES['error']['IDs'][0] . " ID do Setor é inválido";

             }else 
                 return MESSAGES['error']['Data'][1];
        
        } else 
             return MESSAGES['error']['IDs'][0] . " ID do Piso é inválido";

    }else
      return MESSAGES['error']['Data'][0];
}

$dados= array(
    "nome"      => "violeta",
      "id"      => 13,
      "idPiso"  => 4,
      "ativo"   =>1
     
  );
// print_r(atualizarSetor($dados));





/**
 *Função responsável por retornar os dados do Setor cadastado 
 *@author Vívian Guimaraes Vaz
 *@param void
 *@return dados encontrados ou uma menssagem de erro
 */
function listaSetor() {
    // Chamando a função responsável por retornar os dados de todos os Corredores
    $resposta = selectAllSetor();

    // Validação para verificar se houve retorno de dados por parte do BD
    if(is_array($resposta) && count($resposta) > 0)  
        return $resposta;
    elseif(is_bool($resposta) && $resposta == false) 
        return MESSAGES['error']['Select'][0];
}


//print_r(listaSetor());

/**
 *Função responsável por retornar os dados do Setor por id
 *@author Vívian Guimaraes Vaz
 *@param int -$id id do corredor
 *@return dados encontrados ou uma menssagem de erro
 */
function buscaSetor($id) {
    // Validação para verificar se o ID informado é um ID válido
    if(is_numeric($id) && $id > 0) {
        // Chamando a model para busca de corredor por ID 
        $resposta = selectByIdSetor($id);

        // Validação para verificar o retorno do BD
        if(is_array($resposta)) 
            return $resposta;
        else
            return MESSAGES['error']['Data'][0];
    }
}


//print_r(buscaSetor(15));


/**
 * Função responsável por retornar os dados de todos os setores ativos
 * @author Vívian Gamães Vaz
 * @param Void
 * @return Array Dados encontrados ou uma mensagem de erro
 *  */ 
function listaSetoresAtivos() {
    // Chamando a função responsável por retornar os dados de todos os Corredores
    $resposta = selectAllSetorAtivated();

    // Validação para verificar se houve retorno de dados por parte do BD
    if(is_array($resposta) && count($resposta) > 0)  
        return $resposta;
    elseif(is_bool($resposta) && $resposta == false) 
        return MESSAGES['error']['Select'][0];
}


//print_r(listaSetoresAtivos());

/**
 * Função responsável por retornar os dados de todos os Corredores inativos
 * @author Vívian Guimarães Vaz
 * @param Void
 * @return Array Dados encontrados ou uma mensagem de erro
 *  */ 
function listaSetoresInativos() {
    // Chamando a função responsável por retornar os dados de todos os Corredores
    $resposta = selectAllSetorInativated();

    // Validação para verificar se houve retorno de dados por parte do BD
    if(is_array($resposta) && count($resposta) > 0)  
        return $resposta;
    elseif(is_bool($resposta) && $resposta == false) 
        return MESSAGES['error']['Select'][0];
}


//print_r(listaSetoresInativos());








?>