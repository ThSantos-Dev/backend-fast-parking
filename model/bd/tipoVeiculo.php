<?php
// __________________________________________________________________
//   Objetivo: Arquivo de funções que manipularão o BD
//   Autor: Vívian Guimarães Vaz
//   Data: 02/06/2022
//   Versão: 1.0
// ____________________________________________________________________
 
// Import do arquivo responsável pela Conexão do BD 
require_once('conexaoMySQL.php');


/**
 * função para inserir o tipo de veiculo 
 * 
 * @author Vívian Guimarães Vaz
 * @param String nome - retornar qual o tipo de veículo ex: carro, moto, vam
 * @return Bool se der retornará um buleano 
 */
function insertTipoVeiculo($nome){

    // abrindo conexão com o BD
    $conexao = conexaoMySQL();

    // Declaração de variável  para utilizar no return dessa função
    $resposta = (bool) false;

     // Script SQL para inserir os dadso no BD
     $sql = "insert into tblTipoVeiculo (nome)
     values (

                '" . $nome . "'
            );";
    

    //validação para veificar se o script SQL está correto
    if (mysqli_query($conexao, $sql)) {

        // Validação para verificar se uma linha foi afetada (acrescentada) no BD
        if (mysqli_affected_rows($conexao)){
            $resposta = true;
            }
    }

     // fechamento da conexão do banco
     fecharConexaoMySQL($conexao);
     return $resposta;

}

//$nome = 'van';
//insertTipoVeiculo($nome);


/**
 *  função para para fazer o update dos dados através do id
 * 
 * @author Vívian Guimarães Vaz
 * @param void
 * @return bool se der retornará um buleano 
 */
function updateTipoVeiculo($dados){


    //abrindo conexao com BD
    $conexao = conexaoMySQL();

    //variável de ambiente para o return da função
    $resposta = (bool) false;

    //script SQL para inserir os dados do BD
    $sql= "
            update tblTipoVeiculo set
                    
            nome = '{$dados['nome']}'
            
            where id={$dados['id']} ";

       

    //validação para verificar se o sript está correto
    if(mysqli_query($conexao,$sql)){

        //validção para verificar se uma linha foi alterada
        if(mysqli_affected_rows($conexao))
            $resposta = true;
    }

    // Solicita o fechamento da conexão com o BD
    fecharConexaoMySQL($conexao);
        return $resposta;       

}

// $dados= array(
//     "nome" => "iate",
//     "id"   => 13
 
// );

// echo '<pre>';
// echo json_encode(updateTipoVeiculo($dados));
// echo '</pre>';
// die;



/**
 *  função para listar dados 
 * 
 * @author Vívian Guimarães Vaz
 * @param void
 * @return bool se der retornará um buleano 
 */ 
function selectAllTipoVeiculo(){

    // abrindo conexão com o BD
    $conexao = conexaoMySQL();

    //Script para listar os topos de veiculos ex: moto, carro, caminhão
    $sql = "select * from tblTipoVeiculo";

    //criação da variável para array
    $resposta = mysqli_query($conexao,$sql);

    if($resposta){

        $cont = 0;
        while($dados = mysqli_fetch_assoc($resposta))
        {
            //criando um array com os dados do BD
            $arrayDados[$cont] = array(

                "id"    => $dados['id'],
                "nome"  => $dados['nome']
            );
            $cont++;
        }

            
    }  

        //encerrando a conexão com o banco 
        fecharConexaoMySQL($conexao);
        

        if(isset($arrayDados))
            return $arrayDados;
        else 
            return false;

 }

//print_r(selectAllTipoVeiculo());
 



/**
 *  função para listar dados por id 
 * 
 * @author Vívian Guimarães Vaz
 * @param void
 * @return bool se der retornará um buleano 
 */ 
function selectByIdTipoVeiculo($id) {
    // Abrindo conexão com o BD
    $conexao = conexaoMySQL();

    // Script SQL para listar todos os tipos de veiculos
    $sql = "SELECT 
                tblTipoVeiculo.id,
                tblTipoVeiculo.nome AS tipo
               
                FROM tblTipoVeiculo
                   
                WHERE tblTipoVeiculo.id = {$id}";
                    
    $resposta = mysqli_query($conexao, $sql);

    // Validação para verificar se houve retorno do BD
    if($resposta) {
        // Convertendo os dados obtidos em Array
        if($resultado = mysqli_fetch_assoc($resposta)) {
            // Montando um array personalizado
            $arrayDados = array(
                "id"        => $resultado['id'],
                "tipo"    => $resultado['tipo']
                

            );
        }

    }

    // Solitando o fechamento da conexão com o BD
    fecharConexaoMySQL($conexao);
        
    // Retornando os dados encontrados ou false
    return isset($arrayDados) ? $arrayDados : false;    
}







?>