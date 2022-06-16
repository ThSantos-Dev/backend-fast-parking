<?php
// __________________________________________________________________
//   Objetivo: Arquivo de funções que manipularão o BD
//   Autor: Vívian Guimarães Vaz
//   Data: 02/06/2022
//   Versão: 1.0
// ____________________________________________________________________

//Import do arquivo responsável 
require_once('conexaoMySQL.php');

/**
 *  //função para inserir o nome do piso
 * 
 * @author Vívian Guimarães Vaz
 * @param String  nome do piso :piso1, piso2, piso3
 * @return Bool se der retornará um buleano 
 */
 function insertPiso($dados){

    //abrir conexão com o BD
    $conexao = conexaoMySQL();

    //declaração de variável para ultilizar no return desta função 
    $resposta = (bool) false;

    // Script SQL para inserir os dados no BD
    $sql = "insert into tblPiso (nome, ativo)
    values (
                   '{$dados['nome']}',
                   {$dados['ativo']}
           );";

    //valiação para verificar se o script MSQL está correto
    if(mysqli_query($conexao,$sql)){

        //validação para verificar se a linha foi acrscentada o BD
        if(mysqli_affected_rows($conexao)){
            $resposta = true;
        }
    }

    //fechamento da conexão com o BD
    fecharConexaoMySQL($conexao);
        return $resposta;
 }
    //  $dados = array(
    //      "nome" => "TESTE",
    //      "ativo" => 1
    //  );
    //  echo(insertPiso($dados));



/**
 *  função para para fazer o update dos dados através do id
 * 
 * @author Vívian Guimarães Vaz
 * @param void
 * @return bool se der retornará um buleano 
 */
function updatePiso($dados){

    //abrindo conexão com o BD
    $conexao = conexaoMySQL();

    //variável de ambiente para retornar dados para a função
    $resposta =(bool) false;

    //script SQL para inserir os dados no BD
    $sql = "
            update tblPiso set
            
            nome = '{$dados['nome']}',
            ativo = {$dados['ativo']}
            where id ={$dados['id']}
            ";
           // die($sql);

    //validção para verificar se o script está correto
    if(mysqli_query($conexao,$sql)){

        //validação paara verificar se a linha foi alterada
        if(mysqli_affected_rows($conexao))
            $resposta = true;
    }

    //solicitação para o fehcamento da conexão com o BD
    fecharConexaoMySQL($conexao);
    return $resposta;
}


     $dados= array(
   "nome" => "01010",
     "id"   => 4,
    "ativo" =>1
 );

// echo '<pre>';
// echo json_encode(updatePiso($dados));
// echo '</pre>';
// die;



/**
 *  função para listar dados 
 * 
 * @author Vívian Guimarães Vaz
 * @param void
 * @return bool se der retornará um buleano 
 */ 
function selectAllPiso(){

    // abrindo conexão com o BD
    $conexao = conexaoMySQL();

    //Script para listar os pisos (andares) 
    $sql = "select * from tblPiso";

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

// print_r(selectAllPiso());




/**
 *  função para listar dados por id 
 * 
 * @author Vívian Guimarães Vaz
 * @param void
 * @return bool se der retornará um buleano 
 */ 
function selectByIdPiso($id) {
    // Abrindo conexão com o BD
    $conexao = conexaoMySQL();

    // Script SQL para listar todos os pisos
    $sql = "SELECT 
                tblPiso.id,
                tblPiso.nome AS codigo,
                tblPiso.ativo AS status
                FROM tblPiso
                   
                WHERE tblPiso.id = {$id}";
                    
    $resposta = mysqli_query($conexao, $sql);

    // Validação para verificar se houve retorno do BD
    if($resposta) {
        // Convertendo os dados obtidos em Array
        if($resultado = mysqli_fetch_assoc($resposta)) {
            // Montando um array personalizado
            $arrayDados = array(
                "id"        => $resultado['id'],
                "codigo"    => $resultado['codigo'],
                "status"    => $resultado['status'] ,

            );
        }

    }

    // Solitando o fechamento da conexão com o BD
    fecharConexaoMySQL($conexao);
        
    // Retornando os dados encontrados ou false
    return isset($arrayDados) ? $arrayDados : false;    
}

//echo json_encode(selectAllPiso());

/**
 *  função para listar todos os dados ativos  
 * 
 * @author Vívian Guimarães Vaz
 * @param void
 * @return bool se der retornará um buleano 
 */ 
function selectAllPisoAtivated() {
    // Abrindo conexão com o BD
    $conexao = conexaoMySQL();

    // Script SQL para listar todos os Pisoa ativos 
    $sql = "SELECT 
                tblPiso.id,
                tblPiso.nome AS codigo,
                tblPIso.ativo AS status,
                
                tblPiso.nome AS piso

                
                FROM tblPiso
                    
                   
            WHERE tblPiso.ativo = 1";
                
    $resposta = mysqli_query($conexao, $sql);

    // Validação para verificar se houve retorno do BD
    if($resposta) {
        // Convertendo os dados obtidos em Array
        $contador = 0;
        while($resultado = mysqli_fetch_assoc($resposta)) {
            // Montando um array personalizado
            $arrayDados[$contador] = array(
                "id"        => $resultado['id'],
                "codigo"    => $resultado['codigo'],
                "status"    => $resultado['status'],

            );

            $contador++;
        }

    }

    // Solitando o fechamento da conexão com o BD
    fecharConexaoMySQL($conexao);
        
    // Retornando os dados encontrados ou false
    return isset($arrayDados) ? $arrayDados : false;
}

//echo json_encode(selectAllPisoAtivated());



/**
 *  função para listar todos os dados Inativos 
 * 
 * @author Vívian Guimarães Vaz
 * @param void
 * @return bool se der retornará um buleano 
 */ 
function selectAllPisoInativated() {
    // Abrindo conexão com o BD
    $conexao = conexaoMySQL();

    // Script SQL para listar todos os Pisoa desativados
    $sql = "SELECT 
                tblPiso.id,
                tblPiso.nome AS codigo,
                tblPIso.ativo AS status,
                
                tblPiso.nome AS piso

                
                FROM tblPiso
                    
                   
            WHERE tblPiso.ativo = 0";
                
    $resposta = mysqli_query($conexao, $sql);

    // Validação para verificar se houve retorno do BD
    if($resposta) {
        // Convertendo os dados obtidos em Array
        $contador = 0;
        while($resultado = mysqli_fetch_assoc($resposta)) {
            // Montando um array personalizado
            $arrayDados[$contador] = array(
                "id"        => $resultado['id'],
                "codigo"    => $resultado['codigo'],
                "status"    => $resultado['status'],

            );

            $contador++;
        }

    }

    // Solitando o fechamento da conexão com o BD
    fecharConexaoMySQL($conexao);
        
    // Retornando os dados encontrados ou false
    return isset($arrayDados) ? $arrayDados : false;
}

//echo json_encode(selectAllPisoInativated());
 
 ?>