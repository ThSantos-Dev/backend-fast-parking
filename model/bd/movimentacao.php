<?php
/**
 * Objetivo: Arquivo de funções que manipularão o BD
 * Autor: Thales Santos
 * Data: 02/06/2022
 * Versão: 1.0
 */

// Import do arquivo responsável pela Conexão do BD 
require_once('conexaoMySQL.php');

/** 
 *   Função responsável por criar Moviementação (entrada do veículo) 
 *   @author Thales Santos 
 *   @param Array $dados Informações da movimentação 
 *                       (id do veículo e vaga).
 *   @return Int ID da movimentação ou false
 * */
function insertMovimentacao($dados)
{
    // Abrindo conexão com o BD
    $conexao = conexaoMySQL();

    // Script SQL para inserir uma Movimentação (entrada)
    $sql = "INSERT INTO tblMovimentacao(
                        dataEntrada,
                        horaEntrada,
                        idVaga,
                        idVeiculo
                    )
                    VALUES(
                         curdate(),
                         curtime(),
                         {$dados['idVaga']},
                         {$dados['idVeiculo']}
                    )";

    // Validação para verificar se o Script está correto
    if (mysqli_query($conexao, $sql)) {
        // Validação para verificar se houve inserção no BD
        if (mysqli_affected_rows($conexao))
            $idMovimentacao = mysqli_insert_id($conexao);
    }

    // Solicitando o fechamento da conexão 
    fecharConexaoMySQL($conexao);

    // Retornando o status da solicitação
    return isset($idMovimentacao) ? $idMovimentacao : false;
}


/**
 * Função reponsável por apagar uma Moviementação
 * @author Thales Santos 
 * @param Int ID da movimentação 
 * @return Bool True se foi apagado, senão, false.
 */
function deleteMovimentacao($id) {
    // Abre conexão com o BD
    $conexao = conexaoMySQL();

    // Variável de ambiente
    $statusResposta = (bool) false;

    // Script SQL para apagar uma movimentação
    $sql = "DELETE FROM tblMovimentacao
                WHERE id = {$id}";
    
    // Validação para verificar se o Script SQL está correto
    if(mysqli_query($conexao, $sql)) {
        // Validação para verificar se o registro foi apagado
        if(mysqli_affected_rows($conexao))
            $statusResposta = true;
    }

    // Solicitando o fechamento da conexão com o BD
    fecharConexaoMySQL($conexao);

    // Retornando o status da solicitação
    return $statusResposta;
}


/**
 * Função responsável por alterar uma Moviementação (saída do veículo)
 * @author Thales Santos
 * @param Array $dados Informações da movimentação (Data/Hora saída e id da movimentação)
 * @return Bool True se foi registrada a saída, senão, false.
 */
function updateMovimentacao($dados){
    // Abrindo conexão com o BD
    $conexao = conexaoMySQL();

    // Variável de ambiente
    $statusResposta = (bool) false;

    // Script SQL para atualizar o registro da movimentação
    $sql = "UPDATE tblMovimentacao SET 
                dataSaida = '{$dados['dataSaida']}',
                horaSaida = '{$dados['horaSaida']}',
                valor     = {$dados['valor']}

            WHERE id = {$dados['id']}";

    // Validação para verificar se o Script SQL está correto
    if (mysqli_query($conexao, $sql)) {
        // Validação para verificar se houve a atualização do registro
        if (mysqli_affected_rows($conexao))
            $statusResposta = true;
    }


    // Solicitando o fehcamento da conexão com o BD
    fecharConexaoMySQL($conexao);

    // Retornando o status da solicitação
    return $statusResposta;
}


/**
 * Função responsável por listar todas as Movimentações 
 * @author Thales Santos 
 * @param Void 
 * @return Array Dados encontrados no BD ou false
 */
function selectAllMovimentacoes() {
       // Abrindo conexão com o BD
       $conexao = conexaoMySQL();

       // Script SQL para buscar uma Movimentação pelo ID
       $sql = "SELECT 
                   tblMovimentacao.id,
                   tblMovimentacao.dataEntrada,
                   tblMovimentacao.horaEntrada,
                   tblMovimentacao.dataSaida,
                   tblMovimentacao.horaSaida,
                   tblMovimentacao.valor,
   
                   tblVeiculo.placa,
                   tblVeiculo.fabricante,
                   tblVeiculo.modelo,
                   
                   tblCor.nome AS cor,
   
                   tblTipoVeiculo.nome AS tipo,
   
                   tblCliente.nome AS cliente,
                   tblCliente.telefone,
   
                   upper(concat_ws('-', tblPiso.nome, tblSetor.nome, tblCorredor.nome, tblVaga.codigo)) as sigla,
   
                   tblVaga.codigo AS codigo,
       
                   tblCorredor.nome AS corredor,
   
                   tblSetor.nome AS setor,
   
                   tblPiso.nome AS piso
               
               FROM tblMovimentacao
                   INNER JOIN tblVeiculo 
                       ON tblMovimentacao.idVeiculo = tblVeiculo.id
                   INNER JOIN tblCor
                       ON tblVeiculo.idCor = tblCor.id
                   INNER JOIN tblTipoVeiculo
                       ON tblVeiculo.idTipoVeiculo = tblTipoVeiculo.id
   
                   INNER JOIN tblCliente
                       ON tblVeiculo.idCliente = tblCliente.id
                   
                   INNER JOIN tblVaga
                       ON tblMovimentacao.idVaga = tblVaga.id
   
                   INNER JOIN tblCorredor
                       ON tblVaga.idCorredor = tblCorredor.id
                   INNER JOIN tblSetor
                       ON tblCorredor.idSetor = tblSetor.id
                   INNER JOIN tblPiso
                       ON tblSetor.idPiso = tblPiso.id";
   
   
       $resposta = mysqli_query($conexao, $sql);
   
       // Validação para verificar se houve retorno
       if($resposta) {
           // Convertendo os dados obtidos em  array
           $contador = 0;
           while($resultado = mysqli_fetch_assoc($resposta)) {
               // Montando um array personalizado com os dados obtidos
               $arraydados[$contador] = array(
                   "id" => $resultado['id'],
                   "valor" => $resultado['valor'],
   
                   "cliente" => array(
                       "nome" => $resultado['cliente'],
                       "telefone" => $resultado['telefone']
                   ),
   
                   "veiculo" => array(
                       "placa" => $resultado['placa'],
                       "fabricante" => $resultado['fabricante'],
                       "modelo" => $resultado['modelo'],
                       "cor" => $resultado['cor'],
                       "tipo" => $resultado['tipo']
                   ),
   
                   "vaga" => array(
                       "codigo" => $resultado['codigo'],
                       "sigla" => $resultado['sigla'],
   
                       "localizacao" => array(
                           "corredor" => $resultado['corredor'],
                           "setor" => $resultado['setor'],
                           "piso" => $resultado['piso']
                       )
                   ),
   
   
                   "entrada" => array(
                       "data" => $resultado['dataEntrada'],
                       "horario" => $resultado['horaEntrada']
                   ),
                   "saida" => array(
                       "data" => $resultado['dataSaida'],
                       "horario" => $resultado['horaSaida']
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
 * Função responsável por buscar uma Moviementação por ID
 * @author Thales Santos 
 * @param Int ID da moviementação
 * @return Array Dados encontrados na busca ou false
 */
function selectByIdMovimentacao($id){
    // Abrindo conexão com o BD
    $conexao = conexaoMySQL();

    // Script SQL para buscar uma Movimentação pelo ID
    $sql = "SELECT 
                tblMovimentacao.id,
                date_format(tblMovimentacao.dataEntrada, '%d/%m/%Y') as dataEntrada,
                date_format(tblMovimentacao.dataSaida, '%d/%m/%Y') as dataSaida,
                tblMovimentacao.horaEntrada,
                tblMovimentacao.horaSaida,
                tblMovimentacao.idVaga,
                tblMovimentacao.valor,

                tblVeiculo.placa,
                tblVeiculo.fabricante,
                tblVeiculo.modelo,
                
                tblCor.nome AS cor,

                tblTipoVeiculo.nome AS tipo,

                tblCliente.nome AS cliente,
                tblCliente.telefone,

                upper(concat_ws('-', tblPiso.nome, tblSetor.nome, tblCorredor.nome, tblVaga.codigo)) as sigla,

                tblVaga.codigo AS codigo,
    
                tblCorredor.nome AS corredor,

                tblSetor.nome AS setor,

                tblPiso.nome AS piso
            
            FROM tblMovimentacao
                INNER JOIN tblVeiculo 
                    ON tblMovimentacao.idVeiculo = tblVeiculo.id
                INNER JOIN tblCor
                    ON tblVeiculo.idCor = tblCor.id
                INNER JOIN tblTipoVeiculo
                    ON tblVeiculo.idTipoVeiculo = tblTipoVeiculo.id

                INNER JOIN tblCliente
                    ON tblVeiculo.idCliente = tblCliente.id
                
                INNER JOIN tblVaga
                    ON tblMovimentacao.idVaga = tblVaga.id

                INNER JOIN tblCorredor
                    ON tblVaga.idCorredor = tblCorredor.id
                INNER JOIN tblSetor
                    ON tblCorredor.idSetor = tblSetor.id
                INNER JOIN tblPiso
                    ON tblSetor.idPiso = tblPiso.id
                
            WHERE tblMovimentacao.id = {$id}";


    $resposta = mysqli_query($conexao, $sql);

    // Validação para verificar se houve retorno
    if($resposta) {
        // Convertendo os dados obtidos em  array
        if($resultado = mysqli_fetch_assoc($resposta)) {
            // Montando um array personalizado com os dados obtidos
            $dados = array(
                "id" => $resultado['id'],
                "valor" => $resultado['valor'],

                "cliente" => array(
                    "nome" => $resultado['cliente'],
                    "telefone" => $resultado['telefone']
                ),

                "veiculo" => array(
                    "placa" => $resultado['placa'],
                    "fabricante" => $resultado['fabricante'],
                    "modelo" => $resultado['modelo'],
                    "cor" => $resultado['cor'],
                    "tipo" => $resultado['tipo']
                ),

                "vaga" => array(
                    "id" => $resultado['idVaga'],
                    "codigo" => $resultado['codigo'],
                    "sigla" => $resultado['sigla'],

                    "localizacao" => array(
                        "corredor" => $resultado['corredor'],
                        "setor" => $resultado['setor'],
                        "piso" => $resultado['piso']
                    )
                ),


                "entrada" => array(
                    "data" => $resultado['dataEntrada'],
                    "horario" => $resultado['horaEntrada']
                ),
                "saida" => array(
                    "data" => $resultado['dataSaida'],
                    "horario" => $resultado['horaSaida']
                )
            );
        }
    }


    // Solitando o fechamento da conexão com o BD
    fecharConexaoMySQL($conexao);

    // Retornando os dados encontrados ou false
    return isset($dados) ? $dados : false;
}

/**
 * Função responsável por calcular o valor que o cliente deverá pagar no momento de sua saída
 * @author Thales Santos
 * @param Array $id ID da movimentação
 * @return Array Dados atualizados com os valores atualizados 
 */
function calculateOutput($id) {
    // Abrindo a conexão com o BD
    $conexao = conexaoMySQL();

    // Script SQL para calcular o valor que o cliente deve pagar
    $sql = "
        SELECT 
                tblMovimentacao.id,
                tblMovimentacao.dataEntrada,
                curdate() AS dataSaida,
				tblMovimentacao.horaEntrada,               
                curtime() AS horaSaida,
                datediff(curdate(), tblMovimentacao.dataEntrada) AS dias,
                timediff(curtime(), tblMovimentacao.horaEntrada) AS horas,
                                
                IF (
					 datediff(curdate(), tblMovimentacao.dataEntrada) > 0,
                     70 * datediff(curdate(), tblMovimentacao.dataEntrada),																			
                    IF(
						hour(timediff(tblMovimentacao.horaEntrada, curtime())) > 0 & minute(timediff(tblMovimentacao.horaEntrada, curtime())) > 0, 					
						tblPreco.demaisHoras * hour(timediff(tblMovimentacao.horaEntrada, curtime())) + tblPreco.primeiraHora, 		
                    
						IF(																			
							hour(timediff(tblMovimentacao.horaEntrada, curtime())) = 0 & minute(timediff(tblMovimentacao.horaEntrada, curtime())) < 60,				
							tblPreco.primeiraHora,													
							null																	
						)																
					)
                ) as valor,
                
                
                tblVeiculo.placa,
                tblVeiculo.fabricante,
                tblVeiculo.modelo,
                
                tblCor.nome as cor,
                tblTipoVeiculo.nome as tipo,
                tblCliente.nome as cliente,
                tblCliente.telefone,
                
                upper(concat_ws('-', tblPiso.nome, tblSetor.nome, tblCorredor.nome, tblVaga.codigo)) as sigla,
                tblVaga.codigo as codigo,
                
                tblCorredor.nome as corredor,
                tblSetor.nome as setor,
                tblPiso.nome as piso
                FROM tblMovimentacao
                    INNER JOIN tblVeiculo 
                        ON tblMovimentacao.idVeiculo = tblVeiculo.id
                        
                    INNER JOIN tblCor
                        ON tblVeiculo.idCor = tblCor.id
                        
                    INNER JOIN tblTipoVeiculo
                        ON tblVeiculo.idTipoVeiculo = tblTipoVeiculo.id
					
                    INNER JOIN tblPreco
						ON tblTipoVeiculo.id = tblPreco.idTipoVeiculo
                    
                    INNER JOIN tblCliente
                        ON tblVeiculo.idCliente = tblCliente.id
                    
                    INNER JOIN tblVaga
                        ON tblMovimentacao.idVaga = tblVaga.id
                    INNER JOIN tblCorredor
                        ON tblVaga.idCorredor = tblCorredor.id
                    INNER JOIN tblSetor
                        ON tblCorredor.idSetor = tblSetor.id
                    INNER JOIN tblPiso
                        ON tblSetor.idPiso = tblPiso.id
                    
                WHERE tblMovimentacao.id = {$id};";
    
    $resposta = mysqli_query($conexao, $sql);

    // Validação para verificar se houve retorno do BD
    if($resposta) {
        // Convertendo os dados obtidos em  array
        if($resultado = mysqli_fetch_assoc($resposta)) {
            // Montando um array personalizado com os dados obtidos
            $arraydados = array(
                "id" => $resultado['id'],
                "valor" => $resultado['valor'],


                "cliente" => array(
                    "nome" => $resultado['cliente'],
                    "telefone" => $resultado['telefone']
                ),

                "veiculo" => array(
                    "placa" => $resultado['placa'],
                    "fabricante" => $resultado['fabricante'],
                    "modelo" => $resultado['modelo'],
                    "cor" => $resultado['cor'],
                    "tipo" => $resultado['tipo']
                ),

                "vaga" => array(
                    "codigo" => $resultado['codigo'],
                    "sigla" => $resultado['sigla'],

                    "localizacao" => array(
                        "piso" => $resultado['piso'],
                        "setor" => $resultado['setor'],
                        "corredor" => $resultado['corredor']
                    )
                ),

                "entrada" => array(
                    "data" => $resultado['dataEntrada'],
                    "horario" => $resultado['horaEntrada']
                ),
                "saida" => array(
                    "data" => $resultado['dataSaida'],
                    "horario" => $resultado['horaSaida']
                ),
                "permanencia" => array(
                    "dias" => $resultado['dias'],
                    "horas" => $resultado['horas'],
                )
            );
        }
    }

       
    // Solitando o fechamento da conexão com o BD
    fecharConexaoMySQL($conexao);

    // Retornando os dados encontrados ou false
    return isset($arraydados) ? $arraydados : false;
}

// echo "Calculo de saida: " . json_encode(calculateOutput(4));