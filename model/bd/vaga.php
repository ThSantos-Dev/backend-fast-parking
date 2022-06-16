<?php

/**
 * Objetivo: Arquivo de funções que manipularão o BD
 * Autor: Thales Santos
 * Data: 03/06/2022
 * Versão: 2.0
 */

// Import do arquivo responsável pela Conexão do BD 
require_once('conexaoMySQL.php');

/**
 * Função responsável por inserir nova Vaga
 * @author Thales Santos
 * @param Array $dados Informações da vaga: código, status e IDs: corredor, tipo da veículo
 * @return Bool True se foi inserido, senão, false.
 */
function insertVaga($dados)
{
    // Abrindo a conexão com o BD
    $conexao = conexaoMySQL();

    // Variável de ambiente
    $statusResposta = (bool) false;

    // Script SQL para inserir nova Vaga
    $sql = "INSERT INTO tblVaga(
                            idCorredor,
                            ativo,
                            ocupada,
                            idTipoVeiculo,
                            codigo
                        )
                        VALUES(
                            {$dados['idCorredor']},
                            {$dados['ativo']},
                            {$dados['ocupada']},
                            {$dados['idTipoVeiculo']},
                            '{$dados['codigo']}')";

    // Validação para verificar se o Script SQL está correto
    if (mysqli_query($conexao, $sql)) {
        // Validação para verificar se houve a inserção 
        if (mysqli_affected_rows($conexao))
            $statusResposta = true;
    }

    // Solicitando o fechamento da conexão com o BD
    fecharConexaoMySQL($conexao);

    // Retonando o status da solicitação
    return $statusResposta;
}

/**
 * Função responsável por atualizar os dados de uma Vaga
 * @author Thales Santos
 * @param Array $dados Informações da vaga: código, IDs: vaga, corredor, status da vaga, tipo da veículo
 * @return Bool True se foi inserido, senão, false.
 */
function updateVaga($dados)
{
    // Abrindo a conexão com o BD
    $conexao = conexaoMySQL();

    // Variável de ambiente
    $statusResposta = (bool) false;

    // Script SQL para inserir nova Vaga
    $sql = "UPDATE tblVaga SET
                    idCorredor      = {$dados['idCorredor']},
                    ativo           = {$dados['ativo']},
                    idTipoVeiculo   = {$dados['idTipoVeiculo']},
                    codigo          = '{$dados['codigo']}'
                WHERE id = {$dados['id']}";

    // Validação para verificar se o Script SQL está correto
    if (mysqli_query($conexao, $sql)) {
        // Validação para verificar se houve a inserção 
        if (mysqli_affected_rows($conexao))
            $statusResposta = true;
    }

    // Solicitando o fechamento da conexão com o BD
    fecharConexaoMySQL($conexao);

    // Retonando o status da solicitação
    return $statusResposta;
}

/**
 * Função responsável por inativar uma Vaga
 * @author Thales Santos
 * @param Int $id Id da vaga a ser inativada
 * @return Bool True se foi inativada , senão, false.
 */
function inactivateVaga($id)
{
    // Abre a conexão com o BD
    $conexao = conexaoMySQL();

    // Variável de ambiente
    $statusResposta = (bool) false;

    // Script SQL para inativar uma vaga
    $sql = "UPDATE tblVaga SET
                ativo = 0    
            WHERE id = {$id}";

    // Validação para verificar se o Script SQL está correto
    if (mysqli_query($conexao, $sql)) {
        // Validação para verificar se o registro foi alterado
        if (mysqli_affected_rows($conexao))
            $statusResposta = true;
    }

    // Solicitando o fechamento da conexão com o BD
    fecharConexaoMySQL($conexao);

    return $statusResposta;
}

/**
 * Função responsável por ativar uma Vaga
 * @author Thales Santos
 * @param Int $id Id da vaga a ser ativada
 * @return Bool True se foi ativada , senão, false.
 */
function activateVaga($id)
{
    // Abre a conexão com o BD
    $conexao = conexaoMySQL();

    // Variável de ambiente
    $statusResposta = (bool) false;

    // Script SQL para inativar uma vaga
    $sql = "UPDATE tblVaga SET
                ativo = 1   
            WHERE id = {$id}";

    // Validação para verificar se o Script SQL está correto
    if (mysqli_query($conexao, $sql)) {
        // Validação para verificar se o registro foi alterado
        if (mysqli_affected_rows($conexao))
            $statusResposta = true;
    }

    // Solicitando o fechamento da conexão com o BD
    fecharConexaoMySQL($conexao);

    return $statusResposta;
}

/**
 * Função responsável por ocupar uma Vaga (alterar ocupado para 1)
 * @author Thales Santos
 * @param Int $id Id da vaga a ser ocupada
 * @return Bool True se foi ativada , senão, false.
 */
function toOccupyVaga($id)
{
    // Abre a conexão com o BD
    $conexao = conexaoMySQL();

    // Variável de ambiente
    $statusResposta = (bool) false;

    // Script SQL para ocupar uma vaga
    $sql = "UPDATE tblVaga SET
                ocupada = 1   
            WHERE id = {$id}";

    // Validação para verificar se o Script SQL está correto
    if (mysqli_query($conexao, $sql)) {
        // Validação para verificar se o registro foi alterado
        if (mysqli_affected_rows($conexao))
            $statusResposta = true;
    }

    // Solicitando o fechamento da conexão com o BD
    fecharConexaoMySQL($conexao);

    return $statusResposta;
}

/**
 * Função responsável por desocupar uma Vaga (alterar ocupado para 0)
 * @author Thales Santos
 * @param Int $id Id da vaga a ser desocupada
 * @return Bool True se foi desocupada , senão, false.
 */
function vacateVaga($id)
{
    // Abre a conexão com o BD
    $conexao = conexaoMySQL();

    // Variável de ambiente
    $statusResposta = (bool) false;

    // Script SQL para desocupar uma vaga
    $sql = "UPDATE tblVaga SET
                ocupada = 0   
            WHERE id = {$id}";

    // Validação para verificar se o Script SQL está correto
    if (mysqli_query($conexao, $sql)) {
        // Validação para verificar se o registro foi alterado
        if (mysqli_affected_rows($conexao))
            $statusResposta = true;
    }

    // Solicitando o fechamento da conexão com o BD
    fecharConexaoMySQL($conexao);

    return $statusResposta;
}


/**
 * Função responsável por listar TODAS as Vagas
 * @author Thales Santos
 * @param Void
 * @return Array Dados encontrados
 */
function selectAllVagas()
{
    // Abrindo a conexão com o BD
    $conexao = conexaoMySQL();

    // Script SQL para listar todas as vagas
    $sql = "SELECT
                tblVaga.id,
                tblVaga.idTipoVeiculo,
                tblVaga.codigo AS codigo,
                tblVaga.ocupada,
                tblVaga.ativo,
       
                tblTipoVeiculo.nome AS tipo,

                tblCorredor.nome AS corredor,

                tblSetor.nome AS setor,

                tblPiso.nome AS piso,

                upper(concat_ws('-', tblPiso.nome, tblSetor.nome, tblCorredor.nome, tblVaga.codigo)) as sigla

                FROM tblVaga
                    INNER JOIN tblTipoVeiculo
                        ON tblVaga.idTipoVeiculo = tblTipoVeiculo.id

                    INNER JOIN tblCorredor
                       ON tblVaga.idCorredor = tblCorredor.id
                   INNER JOIN tblSetor
                       ON tblCorredor.idSetor = tblSetor.id
                   INNER JOIN tblPiso
                       ON tblSetor.idPiso = tblPiso.id";

    $resposta = mysqli_query($conexao, $sql);

    // Validação para verificar se houve retorno
    if ($resposta) {
        // Convertendo os dados obtidos em  array
        $contador = 0;
        while ($resultado = mysqli_fetch_assoc($resposta)) {
            // Montando um array personalizado com os dados obtidos
            $arrayDados[$contador] = array(
                "id" => $resultado['id'],

                "codigo" => $resultado['codigo'],
                "sigla" => $resultado['sigla'],
                "ocupada" => $resultado['ocupada'] == 0 ? false : true,
                "ativo" => $resultado['ativo'] == 0 ? false : true,
                "tipo" => $resultado['tipo'],

                "localizacao" => array(
                    "corredor" => $resultado['corredor'],
                    "setor" => $resultado['setor'],
                    "piso" => $resultado['piso']
                )
            );

            // Incrementando o contador para que não haja sobrescrita dos dados
            $contador++;
        }
    }


    // Solitando o fechamento da conexão com o BD
    fecharConexaoMySQL($conexao);

    // Retornando os dados encontrados ou false
    return isset($arrayDados) ? $arrayDados : false;
}

/**
 * Função responsável por buscar dados de uma Vaga pelo ID
 * @author Thales Santos
 * @param Int $id ID da vaga
 * @return Array Dados encontrados ou false
 */
function selectByIdVaga($id)
{
    // Abrindo conexão com o BD
    $conexao = conexaoMySQL();

    // Script SQL para listar todas as vagas
    $sql = "SELECT
                tblVaga.id,
                tblVaga.idTipoVeiculo,
                tblVaga.codigo AS codigo,
                tblVaga.ocupada AS status,
                tblVaga.ativo,

                tblTipoVeiculo.nome AS tipo,

                tblCorredor.nome AS corredor,

                tblSetor.nome AS setor,

                tblPiso.nome AS piso,

                upper(concat_ws('-', tblPiso.nome, tblSetor.nome, tblCorredor.nome, tblVaga.codigo)) as sigla

                FROM tblVaga
                    INNER JOIN tblTipoVeiculo
                        ON tblVaga.idTipoVeiculo = tblTipoVeiculo.id
                    
                    INNER JOIN tblCorredor
                        ON tblVaga.idCorredor = tblCorredor.id
                    INNER JOIN tblSetor
                        ON tblCorredor.idSetor = tblSetor.id
                    INNER JOIN tblPiso
                        ON tblSetor.idPiso = tblPiso.id
            WHERE tblVaga.id = {$id}";

    $resposta = mysqli_query($conexao, $sql);

    // Validação para verificar se houve retorno
    if ($resposta) {
        // Convertendo os dados obtidos em  array
        if ($resultado = mysqli_fetch_assoc($resposta)) {
            // Montando um array personalizado com os dados obtidos
            $arrayDados = array(
                "id" => $resultado['id'],

                "codigo"    => $resultado['codigo'],
                "sigla"     => $resultado['sigla'],
                "status"    => $resultado['status'],
                "ativo"     => $resultado['ativo'],
                "tipo"      => $resultado['tipo'],

                "localizacao" => array(
                    "corredor"  => $resultado['corredor'],
                    "setor"     => $resultado['setor'],
                    "piso"      => $resultado['piso']
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
 * Função responsável por listar as vagas por Status - Ocupadas / Livres
 * @author Thales Santos
 * @param Bool False se quiser vagas livres e True se as vagas ocupadas
 * @return Array Dados encontrados
 */
function selectByStatusVaga($livre)
{
    // Abrindo conexão com o BD
    $conexao = conexaoMySQL();

    // Script SQL para listar todas as vagas por status
    $sql = "SELECT
                tblVaga.id,
                tblVaga.idTipoVeiculo,
                tblVaga.codigo,
                tblVaga.ocupada,
                tblVaga.ativo,
                
                tblTipoVeiculo.nome AS tipo,

                tblCorredor.nome AS corredor,

                tblSetor.nome AS setor,

                tblPiso.nome AS piso,

                upper(concat_ws('-', tblPiso.nome, tblSetor.nome, tblCorredor.nome, tblVaga.codigo)) as sigla

                FROM tblVaga
                    INNER JOIN tblTipoVeiculo
                        ON tblVaga.idTipoVeiculo = tblTipoVeiculo.id
                    
                    INNER JOIN tblCorredor
                        ON tblVaga.idCorredor = tblCorredor.id

                    INNER JOIN tblSetor
                        ON tblCorredor.idSetor = tblSetor.id
                        
                    INNER JOIN tblPiso
                        ON tblSetor.idPiso = tblPiso.id

            WHERE tblVaga.ocupada = {$livre}
                AND tblCorredor.ativo = 1
                AND tblSetor.ativo = 1
                AND tblPiso.ativo = 1";
    
    $resposta = mysqli_query($conexao, $sql);

    // Validação para verificar se houve retorno
    if ($resposta) {
        // Convertendo os dados obtidos em  array
        $contador = 0;
        while ($resultado = mysqli_fetch_assoc($resposta)) {
            // Montando um array personalizado com os dados obtidos
            $arrayDados[$contador] = array(
                "id" => $resultado['id'],

                "codigo" => $resultado['codigo'],
                "sigla" => $resultado['sigla'],
                "ocupada" => $resultado['ocupada'],
                "ativo" => $resultado['ativo'],
                "tipo" => $resultado['tipo'],

                "localizacao" => array(
                    "corredor" => $resultado['corredor'],
                    "setor" => $resultado['setor'],
                    "piso" => $resultado['piso']
                )
            );

            // Incrementando o contador para que não haja sobrescrita dos dados
            $contador++;
        }
    }


    // Solitando o fechamento da conexão com o BD
    fecharConexaoMySQL($conexao);

    // Retornando os dados encontrados ou false
    return isset($arrayDados) ? $arrayDados : false;
}


/**
 * Função responsável por listar as vagas por Tipo - Carro / Moto
 * @author Thales Santos
 * @param Int $id ID que representa o Tipo da vaga 
 * @return Array Dados encontrados
 */
function selectByTipoVaga($id)
{
    // Abrindo conexão com o BD
    $conexao = conexaoMySQL();

    // Script SQL para listar todas as vagas por tipo
    $sql = "SELECT
                tblVaga.id,
                tblVaga.idTipoVeiculo,
                tblVaga.codigo,
                tblVaga.ocupada,
                tblVaga.ativo,

                tblTipoVeiculo.nome AS tipo,
       
                tblCorredor.nome AS corredor,

                tblSetor.nome AS setor,

                tblPiso.nome AS piso,

                upper(concat_ws('-', tblPiso.nome, tblSetor.nome, tblCorredor.nome, tblVaga.codigo)) as sigla

                FROM tblVaga
                    INNER JOIN tblTipoVeiculo
                        ON tblVaga.idTipoVeiculo = tblTipoVeiculo.id
                    
                    INNER JOIN tblCorredor
                       ON tblVaga.idCorredor = tblCorredor.id
                   INNER JOIN tblSetor
                       ON tblCorredor.idSetor = tblSetor.id
                   INNER JOIN tblPiso
                       ON tblSetor.idPiso = tblPiso.id
            WHERE tblVaga.idTipoVeiculo = {$id}";

    $resposta = mysqli_query($conexao, $sql);

    // Validação para verificar se houve retorno
    if ($resposta) {
        // Convertendo os dados obtidos em  array
        $contador = 0;
        while ($resultado = mysqli_fetch_assoc($resposta)) {
            // Montando um array personalizado com os dados obtidos
            $arrayDados[$contador] = array(
                "id"         => $resultado['id'],

                "codigo"    => $resultado['codigo'],
                "sigla"     => $resultado['sigla'],
                "ocupada"    => $resultado['ocupada'] == 0 ? false : true,
                "ativo"    => $resultado['ativo'] == 0 ? false : true,
                "tipo"      => $resultado['tipo'],

                "localizacao" => array(
                    "corredor"  => $resultado['corredor'],
                    "setor"     => $resultado['setor'],
                    "piso"      => $resultado['piso']
                )
            );

            // Incrementando o contador para que não haja sobrescrita dos dados
            $contador++;
        }
    }


    // Solitando o fechamento da conexão com o BD
    fecharConexaoMySQL($conexao);

    // Retornando os dados encontrados ou false
    return isset($arrayDados) ? $arrayDados : false;
}

/** 
 * Função responsável por listar as vagar por Tipo e Status
 * @author Thales Santos
 * @param Array $dados Informações da busca: 
 *                          Ocupada - 0 para  livres e 1 para  ocupadas
 * @return Array Dados encontrados ou false caso não haja resultados
*/
function selectByStatusAndTipoVaga($dados) {
    // Abrindo conexão com o BD
    $conexao = conexaoMySQL();

    // Script SQL para listar todas as vagas por tipo
    $sql = "SELECT
                tblVaga.id,
                tblVaga.idTipoVeiculo,
                tblVaga.codigo,
                tblVaga.ocupada,
                tblVaga.ativo,
                
                tblTipoVeiculo.nome AS tipo,

                tblCorredor.nome AS corredor,

                tblSetor.nome AS setor,

                tblPiso.nome AS piso,

                upper(concat_ws('-', tblPiso.nome, tblSetor.nome, tblCorredor.nome, tblVaga.codigo)) as sigla

                FROM tblVaga
                    INNER JOIN tblTipoVeiculo
                        ON tblVaga.idTipoVeiculo = tblTipoVeiculo.id
                    
                    INNER JOIN tblCorredor
                        ON tblVaga.idCorredor = tblCorredor.id

                    INNER JOIN tblSetor
                        ON tblCorredor.idSetor = tblSetor.id
                        
                    INNER JOIN tblPiso
                        ON tblSetor.idPiso = tblPiso.id

            WHERE tblVaga.ocupada = {$dados['ocupada']}
                AND tblVaga.idTipoVeiculo = {$dados['idTipoVeiculo']}
                AND tblCorredor.ativo = 1
                AND tblSetor.ativo = 1
                AND tblPiso.ativo = 1";

    $resposta = mysqli_query($conexao, $sql);

    // Validação para verificar se houve retorno
    if ($resposta) {
        // Convertendo os dados obtidos em  array
        $contador = 0;
        while ($resultado = mysqli_fetch_assoc($resposta)) {
            // Montando um array personalizado com os dados obtidos
            $arrayDados[$contador] = array(
                "id"         => $resultado['id'],

                "codigo"    => $resultado['codigo'],
                "sigla"     => $resultado['sigla'],
                "ocupada"   => $resultado['ocupada'],
                "ativo"     => $resultado['ativo'],
                "tipo"      => $resultado['tipo'],

                "localizacao" => array(
                    "corredor"  => $resultado['corredor'],
                    "setor"     => $resultado['setor'],
                    "piso"      => $resultado['piso']
                )
            );

            // Incrementando o contador para que não haja sobrescrita dos dados
            $contador++;
        }
    }

    
    // Solitando o fechamento da conexão com o BD
    fecharConexaoMySQL($conexao);

    // Retornando os dados encontrados ou false
    return isset($arrayDados) ? $arrayDados : false;

}

/**
 * Função responsável por retornar a quantidade total de vagas
 * @author Thales Santos
 * @param Void
 * @return Int Quantidade de vagas ou false
 */
function countVagas() {
    // Abrindo a conexão com o BD
    $conexao = conexaoMySQL();

    // Script SQL para contar todas as vagas
    $sql = "SELECT COUNT(*) AS quantidade
                FROM tblVaga
            WHERE tblVaga.ativo = 1";

    // Executando o Script no BD
    $resposta = mysqli_query($conexao, $sql);

    // Validando p retorno do BD
    if($resposta) {
        // Armazenando a quantidade em uma variável
        if($resultado = mysqli_fetch_assoc($resposta))
            $quantidade = $resultado['quantidade'];
    }

    // Solicitando o fechamento da conexão com o BD
    fecharConexaoMySQL($conexao);

    // Retornando a quantidade de vagas ou false
    return isset($quantidade) ? $quantidade : false;
}

/**
 * Função responsável por retornar a quantidade de vagas Ocupadas ou Livres
 * @author Thales Santos
 * @param Tinyint 0 para livres e 1 para ocupadas
 * @return Int Quantidade de vagas ou false
 */
function countVagasStatus($status) {
    // Abrindo a conexão com o BD
    $conexao = conexaoMySQL();

    // Script SQL para contar todas as vagas livres ou ocupadas
    $sql = "SELECT COUNT(*) AS quantidade
                FROM tblVaga
            WHERE tblVaga.ativo = 1
                AND tblVaga.ocupada = {$status}";

    // Executando o Script no BD
    $resposta = mysqli_query($conexao, $sql);

    // Validando p retorno do BD
    if($resposta) {
        // Armazenando a quantidade em uma variável
        if($resultado = mysqli_fetch_assoc($resposta))
            $quantidade = $resultado['quantidade'];
    }

    // Solicitando o fechamento da conexão com o BD
    fecharConexaoMySQL($conexao);

    // Retornando a quantidade de vagas ou false
    return isset($quantidade) ? $quantidade : false;
}

/**
 * Função responsável por retornar a quantidade de vagas de acordo com status (ocupadas ou livres) e tipo de veículo
 * @author Thales Santos
 * @param Array $dados Status desejado (0 livres, 1 ocupadas) e tipo de veículo (ID do Tipo de veículo desejado)
 * @return Int Quantidade de vagas ou false
 */
function countVagasStatusAndTipo($dados) {
    // Abrindo a conexão com o BD
    $conexao = conexaoMySQL();

    // Script SQL para contar todas as vagas livres ou ocupadas de acordo com o tipo de veículo
    $sql = "SELECT COUNT(*) AS quantidade
                FROM tblVaga
            WHERE tblVaga.ativo = 1
                AND tblVaga.ocupada = {$dados['status']}
                AND tblVaga.idTipoVeiculo = {$dados['idTipoVeiculo']}";

    // Executando o Script no BD
    $resposta = mysqli_query($conexao, $sql);

    // Validando p retorno do BD
    if($resposta) {
        // Armazenando a quantidade em uma variável
        if($resultado = mysqli_fetch_assoc($resposta))
            $quantidade = $resultado['quantidade'];
    }

    // Solicitando o fechamento da conexão com o BD
    fecharConexaoMySQL($conexao);

    // Retornando a quantidade de vagas ou false
    return isset($quantidade) ? $quantidade : false;
}