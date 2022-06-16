<?php
// Import do arquivo autoload, que fara as instancias do slim
require_once('vendor/autoload.php');

// Criando um objeto do slim chamado app
$app = new \Slim\App();


// Import do arquivo de configurações do projeto
require_once('../module/config.php');

// Import das controller do projeto
require_once('../controller/controllerVeiculo.php');

/**_______________           ENDPOINTS           _______________ **/
/**
 * EndPoint: Responsável por trazer uma lista como TODOS os veículos cadastrados com suas respectiva movimentação
 * @author Thales Santos
 * @param Void
 * @return JSON Dados encontrados
 */
$app->get('/veiculo', function($request, $response, $args) {
    // Chamando a controller para listar os veículos
    $veiculos = listaVeiculos();

    // Validação para verificar se há dados a serem retornados
    if(!empty($veiculos) && !isset($veiculos['idErro'])){
        // Criando um JSON com os dados dos veículos
        $dadosJSON = createJSON($veiculos);

        // Retornando os dados para o cliente
        return $response->write($dadosJSON)
                        ->withHeader('Content-Type', 'application/json')
                        ->withStatus(200);
    } else {
        // Retornad
        return $response->write('{"mensagem": "Não há dados cadastrados", "Erro": '. $veiculos .'}')
                        ->withHeader('Content-Type', 'application/json')
                        ->withStatus(400);
    }
});

/**
 * EndPoint: Responsável por trazer uma lista como TODOS os veículos  que tiveram a saída registrada com suas respectiva movimentação
 * @author Thales Santos
 * @param Void
 * @return JSON Dados encontrados
 */
$app->get('/veiculo/saida', function($request, $response, $args) {
    // Chamando a controller para listar os veículos
    $veiculos = listaVeiculosSaida();

    // Validação para verificar se há dados a serem retornados
    if(!empty($veiculos) && !isset($veiculos['idErro'])){
        // Criando um JSON com os dados dos veículos
        $dadosJSON = createJSON($veiculos);

        // Retornando os dados para o cliente
        return $response->write($dadosJSON)
                        ->withHeader('Content-Type', 'application/json')
                        ->withStatus(200);
    } else {
        // Retornad
        return $response->write('{"mensagem": "Não há dados cadastrados", "Erro": '. $veiculos .'}')
                        ->withHeader('Content-Type', 'application/json')
                        ->withStatus(400);
    }
});

/**
 * EndPoint: Responsável por listar veiculos por TIPO (carro, moto, etc...)
 * @author Thales Santos
 * @param Int $id ID do tipo do veiculo
 * @return JSON Dados encontrados
 */
$app->get('/veiculo/tipo/{id}', function($request, $response, $args){
    // Validação para verificar se o id informado é um ID válido
    if(is_numeric($args['id']) && $args['id'] > 0){
        // Recuperando o ID informado
        $id = $args['id'];

        // Chamando a função da controller para listar os veículos cadastrados por TIPO
        $veiculos = listaVeiculosPorTipo($id);

        // Validação para verificar se há veículos deste tipo
        if(!empty($veiculos) && !isset($veiculos['idErro'])){
            // Criando um JSON com os dados encontrados
            $dadosJSON = createJSON($veiculos);

            // Retornando os dados para o cliente
            return $response->write($dadosJSON)
                            ->withHeader('Content-Type', 'application/json')
                            ->withStatus(200);
        } else {
            // Criando um JSON com a mensagem de erro
            $dadosJSON = createJSON($veiculos);

            // Retornando uma mensagem de erro para o cliente 
            return $response->write('{"message": "Não veículos deste tipo no momento", "Erro": ' . $dadosJSON . '}')
                            ->withHeader('Content-Type', 'application/json')
                            ->withStatus(400);
        }
    } else 
        // Retorna um erro que significa que o cliente passou dados errados
        return $response->write('{"message": "É obrigatório informar um ID com um formato válido (número)."}')
                        ->withHeader('Content-Type', 'application/json')
                        ->withStatus(404);
    
});

/**
 * EndPoint: Responsável por listar buscar um veiculo pela Placa
 * @author Thales Santos
 * @param String $placa Placa do veiculo
 * @return JSON Dados encontrados
 */
$app->get('/veiculo/placa/{placa}', function($request, $response, $args) {

    // Validação para verificar se a placa foi informada
    if(is_string($args['placa'])){
        // Resgatando a placa 
        $placa = trim($args['placa']);

        // Chamando a função da controller para listar os veículos pela placa
        $veiculos = listaVeiculosPorPlaca($placa);

        // Validação para verificar se há algum veiculo cadastrado com a placa informada
        if(is_array($veiculos) && !isset($veiculos['idErro'])) {
            // Criando um JSON com os dados
            $dadosJSON = createJSON($veiculos);

            // Retornando os dados para o cliente
            return $response->write($dadosJSON)
                            ->withHeader('Content-Type', 'application/json')
                            ->withStatus(200);
        } else{
            // Criando um JSON com a mensagem de erro
            $dadosJSON = createJSON($veiculos);

            // Retornando uma mensagem de erro para o cliente
            return $response->write('{"message": "Não foi possível localizar o veículo.", "Erro": ' . $dadosJSON .'}')
                            ->withHeader('Content-Type', 'application/json')
                            ->withStatus(400);
        }
    } else {
        // Retorna um erro que significa que o cliente passou dados errados
        return $response->write('{"message": "É obrigatório informar uma placa no formato válido."}')
                        ->withHeader('Content-Type', 'application/json')
                        ->withStatus(404);
    }
});

/**
 * EndPoint: Responsável por trazer uma lista com os veículos ESTACIONADOS
 * @author Thales Santos
 * @param Void
 * @return JSON 
 */
$app->get('/veiculo/estacionados', function($request, $response, $args){
    // Chamando a função da controller para listar os veículos ESTACIONADOS
    $veiculos = listaVeiculosEstacionados();

    // Validação para verificar se há veículos estacionados
    if(!empty($veiculos) && !isset($veiculos['idErro'])){
        // Criando um JSON com os dados encontrados
        $dadosJSON = createJSON($veiculos);

        // Retornando os dados para o cliente
        return $response->write($dadosJSON)
                        ->withHeader('Content-Type', 'application/json')
                        ->withStatus(200);
    } else {
        // Criando um JSON com a mensagem de erro
        $dadosJSON = createJSON($veiculos);

        // Retornando uma mensagem de erro para o cliente 
        return $response->wirte('{"message": "Não veículos estacionados no momento", "Erro": ' . $dadosJSON . '}')
                        ->withHeader('Content-Type', 'application/json')
                        ->withStatus(400);

    }
});

/**
 * EndPoint: Responsável por buscar veiculo ESTACIONADO pela PLACA específica
 * @author Thales Santos
 * @param String $placa Placa do veiculo
 * @return JSON Dados encontrados
 */
$app->get('/veiculo/estacionados/placa/{placa}', function($request, $response, $args){
    // Validação para verificar se a placa foi informada
    if(is_string($args['placa'])){
        // Resgatando a placa 
        $placa = trim($args['placa']);

        // Chamando a função da controller para listar os veículos estacionados pela placa
        $veiculos = listaVeiculosEstacionadosPorPlaca($placa);

        // Validação para verificar se há algum veiculo cadastrado com a placa informada
        if(is_array($veiculos) && !isset($veiculos['idErro'])) {
            // Criando um JSON com os dados
            $dadosJSON = createJSON($veiculos);

            // Retornando os dados para o cliente
            return $response->write($dadosJSON)
                            ->withHeader('Content-Type', 'application/json')
                            ->withStatus(200);
        } else{
            // Criando um JSON com a mensagem de erro
            $dadosJSON = createJSON($veiculos);

            // Retornando uma mensagem de erro para o cliente
            return $response->write('{"message": "Não foi possível localizar o veículo.", "Erro": ' . $dadosJSON .'}')
                            ->withHeader('Content-Type', 'application/json')
                            ->withStatus(400);
        }
    } else {
        // Retorna um erro que significa que o cliente passou dados errados
        return $response->write('{"message": "É obrigatório informar uma placa no formato válido."}')
                        ->withHeader('Content-Type', 'application/json')
                        ->withStatus(404);
    }
});

/**
 * EndPoint: Responsável por trazer uma lista de veiculos ESTACIONADOS por TIPO
 * @author Thales Santos
 * @param Int $id ID do tipo do veiculo
 */
$app->get('/veiculo/estacionados/tipo/{id}', function($request, $response, $args){
    // Validação para verificar se o id informado é um ID válido
    if(is_numeric($args['id']) && $args['id'] > 0){
        // Recuperando o ID informado
        $id = $args['id'];

        // Chamando a função da controller para listar os veículos cadastrados por TIPO
        $veiculos = selectByEstacionadoAndTipo($id);

        // Validação para verificar se há veículos deste tipo
        if(!empty($veiculos) && !isset($veiculos['idErro'])){
            // Criando um JSON com os dados encontrados
            $dadosJSON = createJSON($veiculos);

            // Retornando os dados para o cliente
            return $response->write($dadosJSON)
                            ->withHeader('Content-Type', 'application/json')
                            ->withStatus(200);
        } else {
            // Criando um JSON com a mensagem de erro
            $dadosJSON = createJSON($veiculos);

            // Retornando uma mensagem de erro para o cliente 
            return $response->write('{"message": "Não veículos deste tipo no momento", "Erro": ' . $dadosJSON . '}')
                            ->withHeader('Content-Type', 'application/json')
                            ->withStatus(400);
        }
    } else 
        // Retorna um erro que significa que o cliente passou dados errados
        return $response->write('{"message": "É obrigatório informar um ID com um formato válido (número)."}')
                        ->withHeader('Content-Type', 'application/json')
                        ->withStatus(404);
});






// Inicializando a API
$app->run();

?>