<?php
// Import do arquivo autoload, que fara as instancias do slim
require_once('vendor/autoload.php');

// Criando um objeto do slim chamado app
$app = new \Slim\App();


// Import do arquivo de configurações do projeto
require_once('../module/config.php');

// Import das controller do projeto
require_once('../controller/controllerRelatorio.php');


/**_______________           ENDPOINTS           _______________ **/
$app->get('/relatorio', function($request, $response, $args){
    // Chamando a função da controller que gera um relatorio completo com todos os rendimentos
    // Criando um JSON com os Dados obtidos
    $relatorio = createJSON(geraRelatorio());
        
    // Retornando o relatorio para o cliente
    return $response->write($relatorio)
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(200);
});














// Inicializando a API
$app->run();


?>