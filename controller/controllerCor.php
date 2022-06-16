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

//inporte do arqquivo de modelagem da Cor
require_once(SRC .'model/bd/cor.php');




//   Função responsável por tratar os dados para inserção de Cor
//   @author Vívian Guimaraes Vaz
//   @param Array $dados Informações da Cor - nome 
//   @return Bool True se foi inserido, se não Array com uma mensagem de erro
function inserirCor($nome){

    //validação para verificar se há conteúdo para a inserção da cor
    if (!empty($nome)){

        //validação para verificar se o campo obrigatório 'Nome' foi informado
        if(!empty($nome)){
             //chamando a model e passando a cor 
             if (insertCor($nome))
                return true;
             else 
                return MESSAGES['error']['Insert'][0];

        }else
            return MESSAGES['error']['Data'][1];   
    }else
         return MESSAGES['error']['Data'][0];
}


//echo inserirCor("purpura");


/**
 * Função responsável por tratar os dados para atuzalização de cores
 * @author Vívian Guimarães Vaz
 * @param Array $nome- nome da cor 
 * @return Bool True se o registro foi atualizado ou um Array com uma mensagem de erro
 */
function atualizarCor($dados){

    // Validação para verificar se há conteúdo para atualização de Cor
    if(!empty($dados)){

       // Validação para verificar se o id está correto
       if(is_numeric($dados['id']) && $dados['id'] > 0){

            // Validação para verificar se o campo obrigatório 'Nome'  foi informado
            if(!empty($dados['nome'])){

               // Chamando a model e passando os dados 
               if(updateCor($dados))
                    return true;
                else
                    return MESSAGES['error']['Insert'][0];

           }else
               return MESSAGES['error']['IDs'][0] . " ID da Cor é inválido";
       } else 
               return MESSAGES['error']['Data'][1];
   } else
        return MESSAGES['error']['Data'][0];
}

    $dados= array(
    "nome" => "violeta",
      "id"   => 13
     
  );

//echo (atualizarCor($dados));



/**
* Função responsável por retornar as cores cadastradas 
* @author Vívian Guimarães Vaz
* @param Array void
* @return Bool as cores encontradas ou mnessagem de erro
*/
function listaCor() {
   // Chamando a função responsável por retornar o nome das cores
   $resposta = selectAllCor();

   // Validação para verificar se houve retorno de dados por parte do BD
   if(is_array($resposta) && count($resposta) > 0)  
       return $resposta;
   elseif(is_bool($resposta) && $resposta == false) 
       return MESSAGES['error']['Select'][0];
}
//print_r(listaCor());













?>