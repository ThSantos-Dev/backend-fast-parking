<?php
// Import do arquivo autoload, que fara as instancias do slim
require_once('vendor/autoload.php');

// Criando um objeto do slim chamado app
$app = new \Slim\App();


// Import do arquivo de configurações do projeto
require_once('../module/config.php');

// Import das controller do projeto
require_once('../controller/controllerMovimentacao.php');
require_once('../controller/controllerCliente.php');
require_once('../controller/controllerVeiculo.php');
require_once('../controller/controllerVaga.php');

/**_______________           ENDPOINTS           _______________ **/

/**
 * EndPoint: Responsável por registrar a entrada de um cliente
 * @author Thales Santos
 * @param JSON informações do cliente que serão resgatadas do corpo da requisição
 * @return JSON Informações da entrada ou mensagem de erro
 */
$app->post('/movimentacao/entrada', function ($request, $response, $args) {
    // Regatando o cabeçalho para saber o tipo de conteúdo que foi enviado é JSON
    $contentTypeHeader = $request->getHeaderLine('Content-Type');

    // Validação para verificar se o conteúdo é JSON
    if($contentTypeHeader == 'application/json') {
        //  Convertendo o corpo da requisição e transformando em um Array 
        $dadosBody = $request->getParsedBody();

        // Validação para verificar se há dados para registrar a Entrada
        if(!empty($dadosBody)) {
            // Realizando o cadastro do cliente
            $idCliente = inserirCliente($dadosBody['cliente']);

            // Validando se o cliente doi cadastrado
            if(is_numeric($idCliente) && $idCliente > 0) {
                // Montando Array com os dados do cliente e veiculo
                $dadosVeiculo = array(
                    "idCliente"     => $idCliente,
                    "idCor"         => $dadosBody['veiculo']['idCor'],
                    "idTipoVeiculo" => $dadosBody['veiculo']['idTipoVeiculo'],

                    "placa"         => $dadosBody['veiculo']['placa'],
                    "fabricante"    => $dadosBody['veiculo']['fabricante'],
                    "modelo"        => $dadosBody['veiculo']['modelo']
                );

                // Ralizando o cadastro do veiculo
                $idVeiculo = inserirVeiculo($dadosVeiculo);

                // Verificando se o veiculo foi cadastrado
                if(is_numeric($idVeiculo) && $idVeiculo > 0) {
                    
                    // Trocando o status da vaga selecionada para Ocupado
                    $ocuparVaga = ocuparVaga($dadosBody['idVaga']);


                    // Verificando se a vaga teve o status atualizado
                    if(is_bool($ocuparVaga) && $ocuparVaga == true) {

                        // Montando Array com os dados para registrar a entrada
                        $dadosEntrada = array(
                            "idVeiculo" => $idVeiculo,
                            "idVaga" => $dadosBody['idVaga']
                        );

                        // Realizando o registro da entrada
                        $resposta = registrarEntrada($dadosEntrada);

                        // Validando se houve o retorno do registro cadastrado ou se é uma mensagem de erro
                        if(is_array($resposta) && !isset($resposta['idErro'])) {
                            // Tranformando os dados em um JSON para retornar ao cliente
                            $dadosJSON = createJSON($resposta);

                            return $response->write($dadosJSON)
                                            ->withHeader('Content-Type', 'application/json')
                                            ->withStatus(201);
                        } else {
                            // Retornando uma mensagem de erro para o cliente
                            $dadosJSON = createJSON($idCliente);

                            return $response->write('{"message": "Erro ao registrar a entrada.", "Erro": ' . $dadosJSON .'}')
                                            ->withHeader('Content-Type', 'application/json')
                                            ->withStatus(400);
                        }
                    } else {
                        // Retornando uma mensagem de erro para o cliente
                        $dadosJSON = createJSON($ocuparVaga);

                        return $response->write('{"message": "Erro ao reservar a vaga.", "Erro": ' . $dadosJSON .'}')
                                        ->withHeader('Content-Type', 'application/json')
                                        ->withStatus(400);
                    }
                } else {
                    return $response->write('{"message": "Erro ao cadastrar o veículo."}')
                                    ->withHeader('Content-Type', 'application/json')
                                    ->withStatus(400);
                }
            } elseif(is_array($idCliente) && isset($idCliente['idErro']) ) {
                // Retornando uma mensagem de erro para o cliente
                $dadosJSON = createJSON($idCliente);

                return $response->write('{"message": "Erro ao cadastrar o cliente.", "Erro": ' . $dadosJSON .'}')
                                ->withHeader('Content-Type', 'application/json')
                                ->withStatus(400);
            }
        } else 
            return $response->write('{ "message": "Não há dados para registrar a entrada."}')
                            ->withHeader('Content-Type', 'application/json')
                            ->withStatus(400);

    } else 
        return $response->write('{ "message": "O formato do Content-Type não é válido para essa requisição."}')
                        ->withHeader('Content-Type', 'application/json')
                        ->withStatus(400);
});

/**
 * EndPoint: Responsável por registrar a saída de um cliente
 * @author Thales Santos
 * @param Int $id ID da movimentação
 * @return JSON Informações da saída com o valor que o cliente deverá pagar
 */
$app->get('/movimentacao/saida/{id}', function($request, $response, $args) {
    // Validação para verificar se o ID informado é válido
    if(is_numeric($args['id']) && $args['id'] > 0){
        // Resgatando o ID da movimentação que será registrada a saída
        $id = $args['id'];

        // Verificando se já foi registrada movimentação com o ID informado
        $dadosMovimentacao = buscaMovimentacao($id);
        if(is_array($dadosMovimentacao)) {
            // Verificando se os campos data/hora saida existem e se possuem conteúdo
            if(empty($dadosMovimentacao['saida']['data']) && empty($dadosMovimentacao['saida']['horario'])){
                // Chamando a controller para calcular o valor que o cliente deverá pagar
                $dadosSaida = registrarSaida($id);

                // Verificando o retorno da controller
                if(is_array($dadosSaida) && !isset($dadosSaida['idErro'])) {   

                    // Desocupando a vaga
                    $desocupou = desocuparVaga($dadosMovimentacao['vaga']['id']);

                    // Verificando se a vaga foi desocupada
                    if(is_bool($desocupou) && $desocupou == true) {
                        // Criando um JSON com os dados  atualizados
                        $dadosJSON = createJSON($dadosSaida);

                        // Retornando os dadosSaida para o cliente
                        return $response->write($dadosJSON)
                                        ->withHeader('Content-Type', 'application/json')
                                        ->withStatus(200);


                    } else {
                        // Retornando uma mensagem de erro para o cliente
                        return $response->write('{"message": "Erro ao desocupar a vaga"}')
                                        ->withHeader('Content-Type', 'application/json')
                                        ->withStatus(400);

                    }                    
                } else  {
                    // Criando um JSON com a mensagem de erro
                    $dadosJSON = createJSON($dadosMovimentacao);

                    return $response->write('{"message": "Não foi possível gerar saída.", "Erro":'. $dadosJSON . '}')
                                    ->withHeader('Content-Type', 'application/json')
                                    ->withStatus(400);
                }  
            } else {
                // Retornando uma mensagem de erro para o cliente
                return $response->write('{"message": "A movimentação informada já teve sua saída registrada."}')
                                ->withHeader('Content-Type', 'application/json')
                                ->withStatus(400);
            }
        } else {
            // Retornando uma mensagem de erro para o cliente
            return $response->write('{"message": "O ID informado não existe na base de dados."}')
                            ->withHeader('Content-Type', 'application/json')
                            ->withStatus(400);
        }
    } else {
        // Retorna um erro que significa que o cliente passou dados errados
        return $response->write('{"message": "É obrigatório informar um ID com um formato válido (número)."}')
                        ->withHeader('Content-Type', 'application/json')
                        ->withStatus(404);
    }

});




$app->run();

?>