<?php
// Import do arquivo autoload, que fara as instancias do slim
require_once('vendor/autoload.php');

// Criando um objeto do slim chamado app
$app = new \Slim\App();


// Import do arquivo de configurações do projeto
require_once('../module/config.php');

// Import das controller do projeto
require_once('../controller/controllerPreco.php');

/**_______________           ENDPOINTS           _______________ **/

/**
 * EndPoint: Responsável por criar novo Preço
 * @author Thales Santos
 * @param JSON Dados do preço: valores (primeira e demais horas) e ID do tipo de veículo
 * @return StatusCode 201 para inserido ou 400 para erro
 */
$app->post('/preco', function($request, $response, $args){
    // Regatando o cabeçalho para saber o tipo de conteúdo que foi enviado é JSON
    $contentTypeHeader = $request->getHeaderLine('Content-Type');

    // Validação para verificar se o conteúdo é JSON
    if($contentTypeHeader == 'application/json') {
        //  Convertendo o corpo da requisição e transformando em um Array 
        $dadosBody = $request->getParsedBody();

        // Validação para verificar se há dados para registrar a Entrada
        if(!empty($dadosBody)) {
            // Chamando a função da controller para inserir novo Preço
            $resposta = inserirPreco($dadosBody);

            // Validação para verifar se foi realizado o inserção do registro
            if(is_bool($resposta) && $resposta == true) {
                return $response->write('{"message": "Registro inserido com sucesso."}')
                                ->withHeader('Content-Type', 'application/json')
                                ->withStatus(201);

            } else {
                // Criando um JSON com a mensagem de erro
                $dadosJSON = createJSON($resposta);

                // Retornando uma mensagem de erro para o cliente
                return $response->write('{ "message": "Não foi possível inserir os dados no BD.", "Erro": ' . $dadosJSON .'}')
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
 * EndPoint: Responsável por atualizar um Preço
 * @author Thales Santos
 * @param Int $id ID do Preço a ser atualizado
 * @param JSON Dados do preço: valores (primeira e demais horas) e ID do tipo de veículo
 * @return StatusCode 200 para atualizado ou 400 para erro
 */
$app->put('/preco/{id}', function($request, $response, $args){
    // Validação para verificar se o id informado é válido
    if(is_numeric($args['id']) && $args['id'] > 0){
        // Resgatando o ID
        $id = $args['id'];

        // Regatando o cabeçalho para saber o tipo de conteúdo que foi enviado é JSON
        $contentTypeHeader = $request->getHeaderLine('Content-Type');

        // Validação para verificar se o conteúdo é JSON
        if($contentTypeHeader == 'application/json') {
            //  Convertendo o corpo da requisição e transformando em um Array 
            $dadosBody = $request->getParsedBody();

            // Validação para verificar se há dados para atualizar o Preço
            if(!empty($dadosBody)) {
                // Montando um array com os dados
                $preco = array(
                    "id" => $id,
                    "idTipoVeiculo" => $dadosBody['idTipoVeiculo'],

                    "primeiraHora" => $dadosBody['primeiraHora'],
                    "demaisHoras" => $dadosBody['demaisHoras']
                );

                // Chamando a função da controller para criar o Preço
                $resposta = atualizarPreco($preco);


                // Validação para verificar se o registro foi atualizado
                if(is_bool($resposta) && $resposta == true) {
                    // Retornando uma mensagem de sucesso para o cliente
                    return $response->write('{"message": "Preço atualizada com sucesso!"}')
                                    ->withHeader('Content-Type', 'application/json')
                                    ->withStatus(200);
                }elseif(is_array($resposta) && isset($resposta['idErro'])) {
                    // Criando um JSON com a mensagem de erro
                    $dadosJSON = createJSON($resposta);

                    // Retornando uma mensagem de erro para o cliente
                    return $response->write('{"message": "Não foi possível atualizar o Preço", "Erro": '. $dadosJSON .'}')
                                    ->withHeader('Content-Type', 'application/json')
                                    ->withStatus(400);
                }
            }else 
                return $response->write('{ "message": "Não há dados para atualizar o Preço."}')
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
 * EndPoint: Responsável por apagar um Preço
 * @author Thales Santos
 * @param Int $id ID do Preço a ser apagado
 * @return StatusCode 200 para apagado ou 400 para erro
*/
$app->delete('/preco/{id}', function($request, $response, $args) {
    // Validação para verificar se o id informado é válido
    if(is_numeric($args['id']) && $args['id'] > 0) {
        // Recuperando o ID informado
        $id = $args['id'];

        // Chamando a função da controller para apagar o Preço
        $resposta = excluirPreco($id);

        // Vallidação para verificar se o registro foi apagado
        if(is_bool($resposta) && $resposta == true) {
            // Retornando uma mensagem de sucesso para o cliente
            return $response->write('{ "message": "Registro apagado com sucesso."}')
                            ->withHeader('Content-Type', 'application/json')
                            ->withStatus(200);

        } else{
            // Criando um JSON com a mensagem de erro
            $dadosJSON = createJSON($resposta);

            // Retornando uma mensagem de erro para o cliente
            return $response->write('{ "message": "Não foi possível apagar o registro.", "Erro": ' . $dadosJSON . '}')
                            ->withHeader('Content-Type', 'application/json')
                            ->withStatus(400);
        }
    } else
        return $response->write('{ "message": "É obrigatório informar um ID válido."}')
                        ->withHeader('Content-Type', 'application/json')
                        ->withStatus(400);
});


/**
 * EndPoint: Responsável por listar os Preços cadastrados
 * @author Thales Santos
 * @param Void
 * @return JSON Preços encontrados
 */
$app->get('/preco', function($request, $response, $args){
    // Chamando a função da controller para listar os Preços
    $dados = listaPrecos();

    // Validando o retorno do BD
    if(is_array($dados) && !isset($dados['idErro'])) {
        // Criando um JSON com os dados
        $dadosJSON = createJSON($dados);

        // Retornando os dados para o cliente
        return $response->write($dadosJSON)
                        ->withHeader('Content-Type', 'application/json')
                        ->withStatus(200);
    } else {
        // Criando um JSON com a mensagem de erro
        $dadosJSON = createJSON($dados);

        // Retornando uma mensagem de erro para o cliente
        return $response->write('{ "message": "Não foi possível listar os Preços.", "Erro": ' . $dadosJSON . '}')
                        ->withHeader('Content-Type', 'application/json')
                        ->withStatus(400);
    }
});











// Inicializando a API
$app->run();

?>