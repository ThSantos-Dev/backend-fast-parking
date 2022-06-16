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

//inporte do arqquivo de modelagem do Piso
require_once(SRC.'model/bd/piso.php');



//   Função responsável por tratar os dados para inserção do nome do Piso
//   @author Vívian Guimaraes Vaz
//   @param Array $dados Informações do  Piso - nome 
//   @return Bool True se foi inserido, se não Array com uma mensagem de erro
function inserirPiso($dados){

     //validação para verificar se há conteúdo para inserção Piso
     if(!empty($dados)){

        //validação para informar se o campo obrigatório 'nome foi informado'
        if(!empty($dados['nome']) && !empty($dados['ativo'])){

            //chamar a model e passar o nome do piso 
            if(insertPiso($dados))
                return true;
            else 
                return MESSAGES['error']['Insert'][0];
        }else
            return MESSAGES['error']['Data'][1]; 
     }else
     return MESSAGES['error']['Data'][0];
}

//print_r(inserirPiso($dados));


//   Função responsável por atualizar do dados da PIso
//   @author Vívian Guimaraes Vaz
//   @param Array $dados Informações do  Piso - nome, ativo, 
//   @return Bool True se foi inserido, se não Array com uma mensagem de erro
function atualizarPiso($dados){

     // Validação para verificar se o id está correto
     if(is_numeric($dados['id']) && $dados['id'] > 0){

        //validação para verifcar se há dados para atualizar piso
        if(!empty($dados)){

            //validação do id 
            if(is_numeric($dados['id']) && $dados['id'] > 0){

                //validação para informar se o campo obrigatório 'nome foi informado'
                if(!empty($dados['nome']) && !empty($dados['ativo'])){

                    // Chamando a model e passando os dados 
                    if(updatePiso($dados))
                        return true;
                    else
                        return MESSAGES['error']['Insert'][0];
                }else
                    return MESSAGES['error']['Data'][1];

            }else 
                return MESSAGES['error']['IDs'][0] . " ID do Piso é inválido";
            
        }else
            return MESSAGES['error']['Data'][0];       
    
    }
}

$dados= array(
    "nome"      => "violeta",
      "id"      => 13,
      "ativo"   =>1
     
  );
//print_r(atualizarPiso($dados));



/**
 * Função responsável por retornar os Pisos cadastradas 
 * @author Vívian Guimarães Vaz
 * @param Array void
 * @return Bool as cores encontradas ou mnessagem de erro
 */
function listaPiso() {
    // Chamando a função responsável por retornar o nome do Piso
    $resposta = selectAllPiso();

    // Validação para verificar se houve retorno de dados por parte do BD
    if(is_array($resposta) && count($resposta) > 0)  
        return $resposta;
    elseif(is_bool($resposta) && $resposta == false) 
        return MESSAGES['error']['Select'][0];
}

//print_r(listaPiso());



/**
 * Função responsável por buscar informações do piso pelo ID
 * @author Vívian Guimarães Vaz
 * @param Int $id ID do piso
 * @return Array Dados encontrados ou mensagem de erro
 */
function buscaPiso($id) {
    // Validação para verificar se o ID informado é um ID válido
    if(is_numeric($id) && $id > 0) {
        // Chamando a model para busca de corredor por ID 
        $resposta = selectByIdPiso($id);

        // Validação para verificar o retorno do BD
        if(is_array($resposta)) 
            return $resposta;
        else
            return MESSAGES['error']['IDs'][0];
    }
}

//print_r(buscaPiso(8));

/**
 * Função responsável por retornar os Pisos ativos
 * @author Vívian Guimarães Vaz
 * @param Array void
 * @return Bool as cores encontradas ou mnessagem de erro
 */
function listaPisosAtivos() {
    // Chamando a função responsável por retornar os dados de todos os pisos
    $resposta = selectAllPisoAtivated();

    // Validação para verificar se houve retorno de dados por parte do BD
    if(is_array($resposta) && count($resposta) > 0)  
        return $resposta;
    elseif(is_bool($resposta) && $resposta == false) 
        return MESSAGES['error']['Select'][0];
}

//print_r(listaPisosAtivos());

/**
 * Função responsável por retornar os Pisos desativados
 * @author Vívian Guimarães Vaz
 * @param Array void
 * @return Bool as cores encontradas ou mnessagem de erro
 */
function listaPisosInativos() {
    // Chamando a função responsável por retornar os dados de todos os pisos
    $resposta = selectAllPisoInativated();

    // Validação para verificar se houve retorno de dados por parte do BD
    if(is_array($resposta) && count($resposta) > 0)  
        return $resposta;
    elseif(is_bool($resposta) && $resposta == false) 
        return MESSAGES['error']['Select'][0];
}
print_r(listaPisosInativos());
?>