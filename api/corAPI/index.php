<?php
// ______________________________________________________________
// Objetivo: Arquivo responsável pela manipulação da API
//            Obs(Este arquivo fará ponte entre a VIEW e a MODEL)
// Autor: Vívian Guimaães Vaz
//Data: 14/06/2022
//versão: 1.0
//________________________________________________________________________



    //import do arquivo autoload, que fara as instancias do slim
    require_once('vendor/autoload.php');


    //Criando um objeto do slim chamado app, para configurar os EndPoints
    $app = new \Slim\App();

      //import da controller de cor, que fará a busca de dados
      require_once('../module/config.php');
      require_once('../controller/controllerCor.php');
   
/**
 * EndPoint: Responsável por listar as cores
 * @author Vívian Guimarães Vaz
 * @param JSON Dados da cor 
 * @return StatusCode 201 para inserido ou 400 para erro
 */
    $app->get('/cor', function($request, $response, $args){


        //solicita os dados para a controller
        if($dados = listaCor())
        {
            //Realiza a conversão do array de dados em formato JSON
            if($dadosJSON = createJSON($dados))
            {
                //Caso exista dados a serem retornados, informamamos o statusCode 200 e 
                //enviamos um JSON com todos os dados encontrados
                return $response    ->withStatus(200)
                                    ->withHeader('Content-Type', 'application/json')
                                    ->write($dadosJSON);
            }

        }else{
            
            //retorna um statusCode que significa que a requisição foi aceita, porém sem
            //conteudo de retorno 
            return $response    ->withStatus(204);
        }

    });

/**
 * EndPoint: Responsável por inserir uma nova cor 
 * @author Vívian Guimarães Vaz
 * @param JSON Dados da cor 
 * @return StatusCode 201 para inserido ou 400 para erro
 */
$app->post('/cor', function($request, $response, $args){


    // Resgatando o cabeçalho para saber o tipo de conteúdo que foi enviado é JSON
    $contentTypeHeader = $request->getHeaderLine('Content-Type');

    // Validação para verificar se o conteúdo é JSON
    if($contentTypeHeader == 'application/json') {

        

        //  Convertendo o corpo da requisição e transformando em um Array 
        $dadosBody = $request->getParsedBody();

        // Validação para verificar se há dados para registrar a Entrada
        if(!empty($dadosBody)) {

             
            
            // Chamando a função da controller para inserir nova cor
            $resposta = inserirCor($dadosBody['nome']);
            
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

        }else 
        return $response->write('{ "message": "Não há dados para registrar a entrada."}')
                        ->withHeader('Content-Type', 'application/json')
                        ->withStatus(400);

    }else 
        return $response->write('{ "message": "O formato do Content-Type não é válido para essa requisição."}')
                        ->withHeader('Content-Type', 'application/json')
                        ->withStatus(400);

});

/**
 * EndPoint: Responsável por atualizar as cores 
 * @author Vívian Guimarães Vaz
 * @param JSON Dados da cor 
 * @return StatusCode 201 para inserido ou 400 para erro
 */
$app->put('/cor/{id}', function($request, $response, $args){


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


             // Validação para verificar se há dados para atualizar a cor
             if(!empty($dadosBody)) {

                $dados= array(
                    "nome" => $dadosBody['nome'],
                    "id"   => $id

                );

                 $resposta=atualizarCor($dados);

                 // Validação para verificar se o registro foi atualizado
                if(is_bool($resposta) && $resposta == true) {
                    // Retornando uma mensagem de sucesso para o cliente
                    return $response->write('{"message": "Cor atualizada com sucesso!"}')
                                    ->withHeader('Content-Type', 'application/json')
                                    ->withStatus(200);


                }elseif(is_array($resposta) && isset($resposta['idErro'])) {
                    // Criando um JSON com a mensagem de erro
                    $dadosJSON = createJSON($resposta);

                    // Retornando uma mensagem de erro para o cliente
                    return $response->write('{"message": "Não foi possível atualizar a cor", "Erro": '. $dadosJSON .'}')
                                    ->withHeader('Content-Type', 'application/json')
                                    ->withStatus(400);
                }

             }else 
                    return $response->write('{ "message": "Não há dados para atualizar a cor."}')
                                    ->withHeader('Content-Type', 'application/json')
                                    ->withStatus(400);


        }else
                return $response->write('{ "message": "O formato do Content-Type não é válido para essa requisição."}')
                                ->withHeader('Content-Type', 'application/json')
                                ->withStatus(400);

    }else 
        return $response->write('{ "message": "É obrigatório informar um ID válido."}')
                        ->withHeader('Content-Type', 'application/json')
                        ->withStatus(400);  
});

$app->run();
    
?>