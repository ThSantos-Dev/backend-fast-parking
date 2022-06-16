<?php 
/**
 * Objetivo: Arquivo de funções que manipularão o BD
 * Autor: Thales Santos
 * Data: 06/06/2022
 * Versão: 1.0
 */

// Import do arquivo responsável pela Conexão do BD 
require_once('conexaoMySQL.php');


/**
 * Função responsável por inserir novo Preco
 * @author Thales Santos
 * @param Array $dados Informações do preço ( preços: primeira e demais horas. ID do Tipo do veículo)
 * @param Bool True se inseriu, senão, false
 */
function insertPreco($dados)  {
    // Abrindo conexão com o BD
    $conexao = conexaoMySQL();

    // Variável de ambiente
    $statusResposta = (bool) false;

    // Script SQL para inserir novo Preco
    $sql = "INSERT INTO tblPreco(
                            primeiraHora,
                            demaisHoras,
                            idTipoVeiculo
                        )
                        VALUES(
                            {$dados['primeiraHora']},
                            {$dados['demaisHoras']},
                            {$dados['idTipoVeiculo']}
                        )
    ";

    // Validação para verificar se o Script SQL está correto
    if(mysqli_query($conexao, $sql)){
        // Validação para verificar se houve a inserção 
        if(mysqli_affected_rows($conexao))
            $statusResposta = true;
    }

    // Solicitando o fechamento da conexão com o BD
    fecharConexaoMySQL($conexao);

    // Retonando o status da solicitação
    return $statusResposta;

}

/**
 * Função responsável por atualizar um preço
 * @author Thales Santos
 * @param  Array $dados Informações do preço (preços: primeira e demais horas. ID do Tipo do veículo)
 * @return Bool True se atualizou, senão, false
 */
function updatePreco($dados) {
   // Abrindo conexão com o BD
   $conexao = conexaoMySQL();

   // Variável de ambiente
   $statusResposta = (bool) false;

   // Script SQL para atualizar um Preco
   $sql = "UPDATE tblPreco SET
                primeiraHora    = {$dados['primeiraHora']},
                demaisHoras     = {$dados['demaisHoras']},
                idTipoVeiculo   = {$dados['idTipoVeiculo']}
            WHERE id = {$dados['id']}";

   // Validação para verificar se o Script SQL está correto
   if(mysqli_query($conexao, $sql)){
       // Validação para verificar se houve a atualização 
       if(mysqli_affected_rows($conexao)) 
           $statusResposta = true;
   }

   // Solicitando o fechamento da conexão com o BD
   fecharConexaoMySQL($conexao);

   // Retonando o status da solicitação
   return $statusResposta;
}

/**
 * Função responsável por apagar um preço
 * @author Thales Santos
 * @param Int ID do preço a ser apagado
 * @return Bool True se apagou, senão, false
 */
function deletePreco($id) {
    // Abrindo conexão com o BD 
    $conexao = conexaoMySQL();

    // Variável de ambiente
    $statusResposta = (bool) false;

    // Script SQL para apagar um Preco
    $sql = "DELETE FROM tblPreco
                WHERE id = {$id}";

       // Validação para verificar se o Script SQL está correto
   if(mysqli_query($conexao, $sql)){
    // Validação para verificar se o registro foi apagado 
    if(mysqli_affected_rows($conexao))
        $statusResposta = true;
    }

    // Solicitando o fechamento da conexão com o BD
    fecharConexaoMySQL($conexao);

    // Retonando o status da solicitação
    return $statusResposta;
}

/**
 * Função responsável por listar todos os Precos
 * @author Thales Santos
 * @param Void
 * @return Array Dados encontrados
 */
function selectAllPrecos() {
    // Abrindo conexão com o BD
    $conexao = conexaoMySQL();

    // Script SQL para listar Todos os Precos
    $sql = "SELECT
                tblPreco.id,
                tblPreco.primeiraHora,
                tblPreco.demaisHoras,
                tblPreco.idTipoVeiculo,

                tblTipoVeiculo.nome AS veiculo

                FROM tblPreco
                    INNER JOIN tblTipoVeiculo
                        ON tblPreco.idTipoVeiculo = tblTipoVeiculo.id";
    
    $resposta = mysqli_query($conexao, $sql);
   
    // Validação para verificar se houve retorno
    if($resposta) {
        // Convertendo os dados obtidos em  array
        $contador = 0;
        while($resultado = mysqli_fetch_assoc($resposta)) {
            // Montando um array personalizado com os dados obtidos
            $arraydados[$contador] = array(
                "id" => $resultado['id'],

                "precos" => array(
                    "primeiraHora" => $resultado['primeiraHora'],
                    "demaisHoras"  => $resultado['demaisHoras']
                ),

                "veiculo" => array(
                    "tipo" => $resultado['veiculo'],
                    "idTipoVeiculo"   => $resultado['idTipoVeiculo'],
                )
            );

         // Incrementando o contador para que não haja sobrescrita dos dados
         $contador++;
        }
    }


    // Solitando o fechamento da conexão com o BD
    fecharConexaoMySQL($conexao);

    // Retornando os dados encontrados ou false
    return isset($arraydados) ? $arraydados : false;
}

/**
 * Função responsável por verificar se há preço cadastrado para um tipo de veículo
 * @author Thales Santos
 * @param Int $idTipoVeiculo ID do tipo do veículo
 * @return Bool 
 */
function verifyTypePreco($idTipoVeiculo) {
    // Abrindo conexão com o BD
    $conexao = conexaoMySQL();

    // Script SQL para verificar se o ID Tipo de Veículo já pertence a um preço
    $sql = "SELECT * FROM tblPreco 
                WHERE idTipoVeiculo = {$idTipoVeiculo}";
    
    $resposta = mysqli_query($conexao, $sql);
   
    // Validação para verificar se houve retorno
    if($resposta) {
        // Convertendo os dados obtidos em  array
        $contador = 0;
        while($resultado = mysqli_fetch_assoc($resposta)) {
            // Montando um array personalizado com os dados obtidos
            $arraydados[$contador] = array(
                "id" => $resultado['id']
            );

         // Incrementando o contador para que não haja sobrescrita dos dados
         $contador++;
        }
    }


    // Solitando o fechamento da conexão com o BD
    fecharConexaoMySQL($conexao);

    // Retornando os dados encontrados ou false
    return isset($arraydados) ? true : false;

}

 ?>