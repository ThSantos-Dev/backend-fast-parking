<?php
/*******************************************************************************************
 * Objetivo: Arquivo para criar a conexão com o banco de dados MySQL
 * Autor: Thales Santos
 * Data: 02/06/2022
 * Versão: 1.0
 ******************************************************************************************/

//  Constantes para estabelecer a conexão com o BD:
const DB_SERVER = '10.107.134.44'; // 10.107.134.44
const DB_USER = 'root';
const DB_PASSWORD = 'bcd127';
const DB_DATABASE = 'dbEstacionamento';

// Função que realiza a conexão com o MYSQL
function conexaoMySQL() {
    // Abrindo conexão
    $conexao = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);

    // Validando se a conexão foi bem sucedida
    if($conexao) 
        return $conexao;
    else 
        return false;
}

// Função que fecha a conexão com o banco de dados MySQL
function fecharConexaoMySQL($conexao) {
    mysqli_close($conexao);
}

?>