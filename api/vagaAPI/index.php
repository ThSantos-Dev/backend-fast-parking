<?php
// Import do arquivo autoload, que fara as instancias do slim
require_once('vendor/autoload.php');

// Criando um objeto do slim chamado app
$app = new \Slim\App();


// Import do arquivo de configurações do projeto
require_once('../module/config.php');

// Import das controller do projeto
require_once('../controller/controllerVaga.php');

/**_______________           ENDPOINTS           _______________ **/
/**
 * EndPoint: Responsável por inserir nova Vaga
 * @author Thales Santos
 * @param JSON Dados da vaga
 * @return StatusCode 201 para inserida ou 400 para erro
 */
$app->post('/vaga', function($request, $response, $args) {
    // Regatando o cabeçalho para saber o tipo de conteúdo que foi enviado é JSON
    $contentTypeHeader = $request->getHeaderLine('Content-Type');

    // Validação para verificar se o conteúdo é JSON
    if($contentTypeHeader == 'application/json') {
        //  Convertendo o corpo da requisição e transformando em um Array 
        $dadosBody = $request->getParsedBody();

        // Validação para verificar se há dados para inserir vaga
        if(!empty($dadosBody)) {
            // Chamando a função da controller para criar a vaga
            $resposta = inserirVaga($dadosBody);

            // Validação para verificar se o registro foi criado
            if(is_bool($resposta) && $resposta == true) {
                // Retornando uma mensagem de sucesso para o cliente
                return $response->write('{"message": "Vaga criada com sucesso!"}')
                                ->withHeader('Content-Type', 'application/json')
                                ->withStatus(201);
            }elseif(is_array($resposta) && isset($resposta['idErro'])) {
                // Criando um JSON com a mensagem de erro
                $dadosJSON = createJSON($resposta);

                // Retornando uma mensagem de erro para o cliente
                return $response->write('{"message": "Não foi possível criar a vaga", "Erro": '. $dadosJSON .'}')
                                ->withHeader('Content-Type', 'application/json')
                                ->withStatus(400);
            }
        }else 
            return $response->write('{ "message": "Não há dados para criar a vaga."}')
                            ->withHeader('Content-Type', 'application/json')
                            ->withStatus(400);
    }else
        return $response->write('{ "message": "O formato do Content-Type não é válido para essa requisição."}')
                        ->withHeader('Content-Type', 'application/json')
                        ->withStatus(400);
});

/**
 * EndPoint: Responsável por atualizar uma Vaga
 * @author Thales Santos
 * @param JSON Dados da vaga
 * @return StatusCode 201 para inserida ou 400 para erro
 */
$app->put('/vaga/{id}', function($request, $response, $args) {
    // Validação para verificar se o ID passado é válido
    if(is_numeric($args['id']) && $args['id'] > 0){
        // Recuperando o ID informado
        $id = $args['id'];

        // Regatando o cabeçalho para saber o tipo de conteúdo que foi enviado é JSON
        $contentTypeHeader = $request->getHeaderLine('Content-Type');

        // Validação para verificar se o conteúdo é JSON
        if($contentTypeHeader == 'application/json') {
            //  Convertendo o corpo da requisição e transformando em um Array 
            $dadosBody = $request->getParsedBody();

            // Validação para verificar se há dados para atualizar a vaga
            if(!empty($dadosBody)) {
                // Montando um array com os dados
                $vaga = array(
                    "id" => $id,
                    "idCorredor" => $dadosBody['idCorredor'],
                    "idTipoVeiculo" => $dadosBody['idTipoVeiculo'],
                    
                    "codigo" => $dadosBody['codigo'],
                    "ativo" => $dadosBody['ativo'],
                    "ocupada" => $dadosBody['ocupada']
                );

                // Chamando a função da controller para criar a vaga
                $resposta = atualizarVaga($vaga);

                // Validação para verificar se o registro foi atualizado
                if(is_bool($resposta) && $resposta == true) {
                    // Retornando uma mensagem de sucesso para o cliente
                    return $response->write('{"message": "Vaga atualizada com sucesso!"}')
                                    ->withHeader('Content-Type', 'application/json')
                                    ->withStatus(200);
                }elseif(is_array($resposta) && isset($resposta['idErro'])) {
                    // Criando um JSON com a mensagem de erro
                    $dadosJSON = createJSON($resposta);

                    // Retornando uma mensagem de erro para o cliente
                    return $response->write('{"message": "Não foi possível atualizar a vaga", "Erro": '. $dadosJSON .'}')
                                    ->withHeader('Content-Type', 'application/json')
                                    ->withStatus(400);
                }
            }else 
                return $response->write('{ "message": "Não há dados para atualizar a vaga."}')
                                ->withHeader('Content-Type', 'application/json')
                                ->withStatus(400);
        }else
            return $response->write('{ "message": "O formato do Content-Type não é válido para essa requisição."}')
                            ->withHeader('Content-Type', 'application/json')
                            ->withStatus(400);


    } else 
        return $response->write('{ "message": "É obrigatório informar um ID válido."}')
                        ->withHeader('Content-Type', 'application/json')
                        ->withStatus(400);
});

/**
 * EndPoint: Responsável por listar TODAS as Vagas
 * @author Thales Santos
 * @param Void
 * @return JSON Dados encontrados
 */
$app->get('/vaga', function($request, $response, $args) {
    // Chamando a função da controller que lista TODAS as Vagas
    $vagas = listaVagas();

    // Validação para verificar se há vagas a serem retornadas
    if(is_array($vagas) && !isset($vagas['idErro'])){
        // Criando um JSON com os dados retornados
        $dadosJSON = createJSON($vagas);

        // Retornando os dados encontrados para o cliente
        return $response->write($dadosJSON)
                        ->withHeader('Content-Type', 'application/json')
                        ->withStatus(200);
    }else {
        // Criando um JSON com a mensagem de erro
        $dadosJSON = createJSON($vagas);

        // Retornando uma mensagem de erro para o cliente
        return $response->write($dadosJSON)
                        ->withHeader('Content-Type', 'application/json')
                        ->withStatus(400);
    }
});


/**
 * EndPoint: Responsável por listar as vagas Ocupadas
 * @author Thales Santos
 * @param Void
 * @return JSON Dados encontrados
 */
$app->get('/vaga/ocupadas', function($request, $response, $args) {
    // Chamando a função da controller para listar as vagas Ocupadas
    $vagas = listaVagasPorStatus(true);

    // Validação para verificar se há vagas ocupadas
    if(is_array($vagas) && !isset($vagas['idErro'])) {
        // Criando um JSON com os dados
        $dadosJSON = createJSON($vagas);

        // Retornando os dados para o cliente
        return $response->write($dadosJSON)
                        ->withHeader('Content-Type', 'application/json')
                        ->withStatus(200);
    }else{
        // Criando um JSON com a mensagem de erro
        $dadosJSON = createJSON($vagas);

        // Retornando uma mensagem de erro para o cliente
        return $response->write('{"message": "Não há vagas ocupadas.", "Erro": '. $dadosJSON .'}')
                        ->withHeader('Content-Type', 'application/json')
                        ->withStatus(400);
    }
});
/**
 * EndPoint: Responsável por listar as vagas Livres
 * @author Thales Santos
 * @param Void
 * @return JSON Dados encontrados
 */
$app->get('/vaga/livres', function($request, $response, $args) {
    // Chamando a função da controller para listar as vagas Ocupadas
    $vagas = listaVagasPorStatus(0);

    // Validação para verificar se há vagas ocupadas
    if(is_array($vagas) && !isset($vagas['idErro'])) {
        // Criando um JSON com os dados
        $dadosJSON = createJSON($vagas);

        // Retornando os dados para o cliente
        return $response->write($dadosJSON)
                        ->withHeader('Content-Type', 'application/json')
                        ->withStatus(200);
    }else{
        // Criando um JSON com a mensagem de erro
        $dadosJSON = createJSON($vagas);

        // Retornando uma mensagem de erro para o cliente
        return $response->write('{"message": "Não há vagas livres.", "Erro": '. $dadosJSON .'}')
                        ->withHeader('Content-Type', 'application/json')
                        ->withStatus(400);
    }
});

/**
 * EndPoint: Responsável por listar as vagas por tipo de Veículo
 * @author Thales Santos
 * @param Int $id ID do tipo do veículo
 * @return JSON Dados encontrados 
 */
$app->get('/vaga/tipo/{id}', function($request, $response, $args){
    // Validação para verificar se o ID do tipo do veículo foi passado
    if(is_numeric($args['id']) && $args['id'] > 0){
        // Resgatando o ID do tipo do veículo
        $id = $args['id'];

        // Chamando a função da controller para listar as vagas pelo tipo de veículo
        $vagas = listaVagasPorTipoVeiculo($id);

        // Validando se há vagas para o tipo de veículo especifícado
        if(is_array($vagas) && !isset($vagas['idErro'])){
            // Criando um JSON com os dados
            $dadosJSON = createJSON($vagas);

            // Retornando os dados para o cliente
            return $response->write($dadosJSON)
                            ->withHeader('Content-Type', 'application/json')
                            ->withStatus(200);
        } else {
            // Criando um JSON com a mensagem de erro
            $dadosJSON = createJSON($vagas);

            // Retornando uma mensagem de erro para o cliente
            return $response->write('{"message": "Não há vagas para o veículo especifícado.", "Erro": '. $dadosJSON . '}')
                            ->withHeader('Content-Type', 'application/json')
                            ->withStatus(400);
        }
    } else 
        return $response->write('{"message": "É obrigatório informar um ID válido."}')
                        ->withHeader('Content-Type', 'application/json')
                        ->withStatus(400);

});

/**
 * EndPoint: Responsável por listar as Vagas Ocupadas de um tipo especifíco de Veiculo
 * @author Thales Santos
 * @param Int $id Id do tipo de veículo
 * @return JSON Dados encontrados
 */
$app->get('/vaga/ocupadas/tipo/{id}', function($request, $response, $args){
    // Validação para verificar se o id informado é válido
    if(is_numeric($args['id']) && $args['id'] > 0){
        // Montando um Array com dados de busca
        $dados = array(
            "idTipoVeiculo" => $args['id'],
            "ocupada" => 1
        );

        // Chamando a função da controller para listar as vagas ocupadas de um tipo especifíco de Veiculo
        $vagas = listaVagasPorStatusETipoVeiculo($dados);

        // Validação para verificar se há vagas ocupadas para o tipo de veiculo especificado
        if(is_array($vagas) && !isset($vagas['idErro'])) {
            // Criando um JSON com os dados 
            $dadosJSON = createJSON($vagas);

            // Retornando os dados para o cliente
            return $response->write($dadosJSON)
                            ->withHeader('Content-Type', 'application/json')
                            ->withStatus(200);
        } else {
            // Criando um JSON com a mensagem de erro
            $dadosJSON = createJSON($vagas);

            // Retornando a mensagem de erro para o cliente
            return $response->write('{"message": "Não há vagas ocupadas para o tipo de veículo especifícado", "Erro": ' . $dadosJSON .'}')
                            ->withHeader('Content-Type', 'application/json')
                            ->withStatus(400);
        }

    }else
        return $response->write('{ "message": "É obrigatório informar um ID válido."}')
                        ->withHeader('Content-Type', 'application/json')
                        ->withStatus(400);
});

/**
 * EndPoint: Responsável por listar as Vagas Livres de um tipo especifíco de Veiculo
 * @author Thales Santos
 * @param Int $id Id do tipo de veículo
 * @return JSON Dados encontrados
 */
$app->get('/vaga/livres/tipo/{id}', function($request, $response, $args){
    // Validação para verificar se o id informado é válido
    if(is_numeric($args['id']) && $args['id'] > 0){
        // Montando um Array com dados de busca
        $dados = array(
            "idTipoVeiculo" => $args['id'],
            "ocupada" => 0
        );

        // Chamando a função da controller para listar as vagas livres de um tipo especifíco de Veiculo
        $vagas = listaVagasPorStatusETipoVeiculo($dados);

        // Validação para verificar se há vagas livres para o tipo de veiculo especificado
        if(is_array($vagas) && !isset($vagas['idErro'])) {
            // Criando um JSON com os dados 
            $dadosJSON = createJSON($vagas);

            // Retornando os dados para o cliente
            return $response->write($dadosJSON)
                            ->withHeader('Content-Type', 'application/json')
                            ->withStatus(200);
        } else {
            // Criando um JSON com a mensagem de erro
            $dadosJSON = createJSON($vagas);

            // Retornando a mensagem de erro para o cliente
            return $response->write('{"message": "Não há vagas livres para o tipo de veículo especifícado", "Erro": ' . $dadosJSON .'}')
                            ->withHeader('Content-Type', 'application/json')
                            ->withStatus(400);
        }

    }else
        return $response->write('{ "message": "É obrigatório informar um ID válido."}')
                        ->withHeader('Content-Type', 'application/json')
                        ->withStatus(400);
});

/**
 * EndPoint: Responsável por retornar a quantidade de vagas por status e tipos
 * @author Thales Santos
 * @param Void
 * @return JSON Dados encontrados
 */
$app->get('/vaga/quantidade', function($request, $response, $args){
    // Montando um array com a quantidade de vagas
    $dados = array(
        "total" => quantidadeVagas(),

        "totalLivres" => quantidadeVagasPorStatus(0),
        "totalOcupadas" => quantidadeVagasPorStatus(1),

        "tipoVeiculo" => array(
            "carro" => array(
                "livres" => quantidadeVagasPorStatusETipoVeiculo(["status" => 0, "idTipoVeiculo" => 8]),
                "ocupadas" => quantidadeVagasPorStatusETipoVeiculo(["status" => 1, "idTipoVeiculo" => 8])
            ),
            "moto" => array(
                "livres" => quantidadeVagasPorStatusETipoVeiculo(["status" => 0, "idTipoVeiculo" => 7]),
                "ocupadas" => quantidadeVagasPorStatusETipoVeiculo(["status" => 1, "idTipoVeiculo" => 7])
            )
        )
    );

    /**
     * FALTA GERAR A QUANTIDADE DE VAGAS POR TIPO DE VEÍCULO DINAMICAMENTE
     *              SELECTALLTIPOVEICULO - FUNÇÃO QUE ESTÁ COM A VIVIAN
     */

    //  Criando um JSON com os dados gerados
    $dadosJSON = createJSON($dados);

    //  Retornando os dados gerados para o cliente
    return $response->write($dadosJSON)
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(200);
});




// Inicializando a API
$app->run();

?>