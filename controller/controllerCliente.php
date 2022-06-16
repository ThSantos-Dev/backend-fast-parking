<?php
/*****************************************************************************
 * Objetivo: Arquivo responsável pela manipulação de dados de Cliente
 *              Obs(Este arquivo fará ponte entre a API e a MODEL)
 * Autor: Thales
 * Data: 06/06/2022
 * Versão: 1.0
 */

// Import do arquivo de Configurações
require_once('../module/config.php');

/**
 * Função responsável por tratar os dados para inserção de Cliente
 * @author Thales Santos
 * @param Array $dados Informações do Cliente - nome e telefone
 * @return Int ID do cliente inserido ou Array com uma mensagem de erro
 */
 function inserirCliente($dados) {
    // Validação para verificar se há conteúdo para inserção de Cliente
    if(!empty($dados)){
        // Validação para verificar se o campo obrigatório 'Nome' foi informado
        if(!empty($dados['nome'])){
            // Import do arquivo de Modelagem de Cliente
            require_once(SRC . 'model/bd/cliente.php');

            // Chamando a model e passando os dados
            $resultado = insertCliente($dados);

            // Verificando se o retorno é um numérico (id)
            if(is_numeric($resultado))
                return $resultado;    
            elseif(is_bool($resultado) && $resultado == false)
                return MESSAGES['error']['Insert'][0];
            
        } else 
            return MESSAGES['error']['Data'][1];
    } else
        return MESSAGES['error']['IDs'][0];

 }



?>