<?php
/**
 * Objetivo: Arquivo de constantes e variáveis do projeto
 * Autor: Thales Santos
 * Data: 02/06/2022
 * Versão: 1.0
 */


/***************************             VARIÁVEIS E CONSTANTES GLOBAIS DO PROJETO              *********************************** */


// Caminho relativo
// define("SRC", $_SERVER['DOCUMENT_ROOT'] . '/senai/fastparking/');
define("SRC", $_SERVER['DOCUMENT_ROOT'] . '/senai/fastparking/');

define("MESSAGES", array(
        "error"     => array(
            "IDs" => array(
                array(
                    "idErro" => 10,
                    "message" => "O ID informado é inválido." 
                ),
                array(
                    "idErro" => 11,
                    "message" => "O ID informado não existe." 
                )
            ),

            "Data" => array(
                array(
                    "idErro" => 20,
                    "message" => "Não há dados a serem inseridos."
                ),
                array(
                    "idErro" => 21,
                    "message" => "Há campos obrigatórios que não foram preenchidos"
                )
                ),

            "Insert" => array(
                array(
                    "idErro" => 30,
                    "message" => "Falha ao inserir os dados no banco"
                )
            ),

            "Delete" => array(
                array(
                    "idErro" => 40,
                    "message" => "Falha ao excluir o registro."
                )
            ),

            "Select" => array(
                array(
                    "idErro" => 50,
                    "message" => "Não há dados cadastrados."
                )
            ),

            "Update" => array(
                array(
                    "idErro" => 60,
                    "message" => "Falha ao atualizar o registro."
                )
            )
        




        ),
        "success"   => array(
            "Insert" => array(
                array("idErro" => 100, 
                      "message" => "Registro inserido com sucesso!"
                ),
            ),

            "Update" => array(
                array("idErro" => 200,
                      "message" => "Registro atualizado com sucesso!"
                )
            ),

            "Delete" => array(
                array(
                    "idErro" => 300,
                    "message" => "Registro excluído com sucesso!"
                )
            )
        )
));


/***************************             FUNÇÕES GLOBAIS DO PROJETO              *********************************** */

 /**
 * Função para  converter um Array em um formato JSON
 * @author Thales Santos
 * @param Array $arrayDados Array com os dados que serão transformados em JSON
 * @return JSON Contém os dados do array convertidos para JSON
 */
function createJSON($arrayDados){
    // Validação para tratar array sem dados
    if(!empty($arrayDados)) {
        // Configura o padrão da conversão em um formato JSON
        header('Content-Type: application/json');
    
        $dadosJSON = json_encode($arrayDados);
    
        return $dadosJSON;
    } else 
        return false;
}


?>