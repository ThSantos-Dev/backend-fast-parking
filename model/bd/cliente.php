<?php
/**
 * Objetivo: Arquivo de funções que manipularão o BD
 * Autor: Thales Santos
 * Data: 02/06/2022
 * Versão: 1.0
 */

// Import do arquivo responsável pela Conexão do BD 
require_once('conexaoMySQL.php');

/** Função responsável por inserir um cliente
 * @author Thales Santos.
 * @param Array $dados Informações do cliente (nome e telefone).
 * @return Int Se der certo retorna o Id do cliente, senão, false.
 */
function insertCliente($dados) {
    // Abrindo conexão com o BD
    $conexao = conexaoMySQL();

    // Variável de ambiente
    $idCliente      = (int) 0;

    // Script para inserir novo cliente
    $sql = "INSERT INTO tblCliente (nome, telefone)
                VALUES ('{$dados['nome']}', '{$dados['telefone']}')";

    // Validando se o Script SQL estpa correto
    if(mysqli_query($conexao, $sql)) {
        // Validação para verificar se uma linha foi afetada no BD
        if(mysqli_affected_rows($conexao))
            // Resgatando o id do cliente
            $idCliente = mysqli_insert_id($conexao);
    }

    // Solicitando o fehcamento da conexão com o BD
    fecharConexaoMySQL($conexao);

    // Validando se o id do cliente foi retornado
    return $idCliente > 0 ? $idCliente : false;
}

?>