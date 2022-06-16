<?php
/**
 * Objetivo: Arquivo de funções que manipularão o BD
 * Autor: Thales Santos
 * Data: 03/06/2022
 * Versão: 1.0
 */

// Import do arquivo responsável pela Conexão do BD 
require_once('conexaoMySQL.php');

/**
 * Função responsável por inserir novo Corredor
 * @author Thales Santos
 * @param Array $dados Informações do corredor: ID do Setor que o corredor pertencerá, ativo (bool) e nome.
 * @return Bool True se foi inserido e false caso de errado.
 */
function insertCorredor($dados) {
    // Abrindo a conexão com o BD
    $conexao = conexaoMySQL();

    // Variável de ambiente
    $statusResposta = (bool) false;

    // Script SQL para inserir um novo Corredor
    $sql = "INSERT INTO tblCorredor(
                            idSetor,
                            nome,
                            ativo
                    )
                    VALUES(
                            {$dados['idSetor']},
                            '{$dados['nome']}',
                            {$dados['ativo']}
                    )";

    // Validação para verificar se o Script SQL está correto
    if(mysqli_query($conexao, $sql)) {
        // Validação para verificar se foi inserido novo registro
        if(mysqli_affected_rows($conexao))
            $statusResposta = true;
    }

    // Solicitando o fehcamento da conexão com o BD
    fecharConexaoMySQL($conexao);

    return $statusResposta;

}


/**
 * Função responsável por inativar um Corredor
 * @author Thales Santos
 * @param Int $id Id do corredor a ser inativado
 * @return Bool True se foi  inativado, senão, false.
 */
function inactivateCorredor($id) {
    // Abre a conexão com o BD
    $conexao = conexaoMySQL();

    // Variável de ambiente
    $statusResposta = (bool) false;

    // Script SQL para apagar um corredor
    $sql = "UPDATE tblCorredor SET
                    ativo = 0
                WHERE id = {$id}";

    // Validação para verificar se o Script SQL está correto
    if(mysqli_query($conexao, $sql)) {
        // Validação para verificar se o registro foi apagado
        if(mysqli_affected_rows($conexao))
            $statusResposta = true;
    }

    // Solicitando o fehcamento da conexão com o BD
    fecharConexaoMySQL($conexao);

    return $statusResposta;
}


/**
 * Função reponsável por atualizar um Corredor
 * @author Thales Santos
 * @param Array $dados Informações do corredor: nome, IDs: Corredor a ser atualizado, Setor que ele pertencerá e status
 * @return Bool True se foi atualizado, senão, false.
 */
function updateCorredor($dados) {
    // Abrindo conexão com o BD
    $conexao = conexaoMySQL();

    // Variável de ambiente
    $statusResposta = (bool) false;

    // Script SQL para atualizar um Corredor
    $sql = "UPDATE tblCorredor SET
                idSetor = {$dados['idSetor']},
                nome    = '{$dados['nome']}',
                ativo   = {$dados['ativo']}
            WHERE id    = {$dados['id']}";

    // Validação para verificar se o Script SQL está correto
    if(mysqli_query($conexao, $sql)) {
        // Validação para verificar se houve a atualização do registro
        if(mysqli_affected_rows($conexao))
            $statusResposta = true;
    }

    // Solicitando o fehcamento da conexão com o BD
    fecharConexaoMySQL($conexao);

    return $statusResposta;
}

/**
 * Função responsável por listar todos os Corredores
 * @param Void
 * @return Array Dados encontrados ou false se não existirem dados
 */
function selectAllCorredores() {
    // Abrindo conexão com o BD
    $conexao = conexaoMySQL();

    // Script SQL para listar todos os Corredores
    $sql = "SELECT 
                tblCorredor.id,
                tblCorredor.nome AS codigo,
                tblCorredor.ativo AS status,
                
                tblPiso.nome AS piso,
                tblSetor.nome AS setor
                
                FROM tblCorredor
                    INNER JOIN tblSetor
                        ON tblCorredor.idSetor = tblSetor.id
                    INNER JOIN tblPiso 
                        ON tblSetor.idPiso = tblPiso.id";

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

                "localizacao" => array(
                    "piso" => $resultado['piso'],
                    "setor" => $resultado['setor']
                )
            );

            $contador++;
        }

    }

    // Solitando o fechamento da conexão com o BD
    fecharConexaoMySQL($conexao);
        
    // Retornando os dados encontrados ou false
    return isset($arrayDados) ? $arrayDados : false;
}


/**
 * Função responsável por buscar informações de um corredor pelo ID
 * @author Thales Santos
 * @param Int $id ID do corredor
 * @return Array Dados encontrados ou False
 */
function selectByIdCorredor($id) {
    // Abrindo conexão com o BD
    $conexao = conexaoMySQL();

    // Script SQL para listar todos os Corredores
    $sql = "SELECT 
                tblCorredor.id,
                tblCorredor.nome AS codigo,
                tblCorredor.ativo AS status,
                
                tblPiso.nome AS piso,
                tblSetor.nome AS setor
                
                FROM tblCorredor
                    INNER JOIN tblSetor
                        ON tblCorredor.idSetor = tblSetor.id
                    INNER JOIN tblPiso 
                        ON tblSetor.idPiso = tblPiso.id
            WHERE tblCorredor.id = {$id}";

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

                "localizacao" => array(
                    "piso" => $resultado['piso'],
                    "setor" => $resultado['setor']
                )
            );
        }

    }

    // Solitando o fechamento da conexão com o BD
    fecharConexaoMySQL($conexao);
        
    // Retornando os dados encontrados ou false
    return isset($arrayDados) ? $arrayDados : false;    
}


/**
 * Função responsável por listar todos os Corredores
 * @param Void
 * @return Array Dados encontrados ou false se não existirem dados
 */
function selectAllCorredoresAtivated() {
    // Abrindo conexão com o BD
    $conexao = conexaoMySQL();

    // Script SQL para listar todos os Corredores
    $sql = "SELECT 
                tblCorredor.id,
                tblCorredor.nome AS codigo,
                tblCorredor.ativo AS status,
                
                tblPiso.nome AS piso,
                tblSetor.nome AS setor
                
                FROM tblCorredor
                    INNER JOIN tblSetor
                        ON tblCorredor.idSetor = tblSetor.id
                    INNER JOIN tblPiso 
                        ON tblSetor.idPiso = tblPiso.id
            WHERE tblCorredor.ativo = 1";

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

                "localizacao" => array(
                    "piso" => $resultado['piso'],
                    "setor" => $resultado['setor']
                )
            );

            $contador++;
        }

    }

    // Solitando o fechamento da conexão com o BD
    fecharConexaoMySQL($conexao);
        
    // Retornando os dados encontrados ou false
    return isset($arrayDados) ? $arrayDados : false;
}

/**
 * Função responsável por listar todos os Corredores
 * @param Void
 * @return Array Dados encontrados ou false se não existirem dados
 */
function selectAllCorredoresInativated() {
    // Abrindo conexão com o BD
    $conexao = conexaoMySQL();

    // Script SQL para listar todos os Corredores
    $sql = "SELECT 
                tblCorredor.id,
                tblCorredor.nome AS codigo,
                tblCorredor.ativo AS status,
                
                tblPiso.nome AS piso,
                tblSetor.nome AS setor
                
                FROM tblCorredor
                    INNER JOIN tblSetor
                        ON tblCorredor.idSetor = tblSetor.id
                    INNER JOIN tblPiso 
                        ON tblSetor.idPiso = tblPiso.id
            WHERE tblCorredor.ativo = 0";

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

                "localizacao" => array(
                    "piso" => $resultado['piso'],
                    "setor" => $resultado['setor']
                )
            );

            $contador++;
        }

    }

    // Solitando o fechamento da conexão com o BD
    fecharConexaoMySQL($conexao);
        
    // Retornando os dados encontrados ou false
    return isset($arrayDados) ? $arrayDados : false;
}
?>