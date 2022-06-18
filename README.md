# FastParking - o nosso estacionamento!

<p>Projeto didático para avaliação final das disciplinas de Programação Back-End e Banco de Dados.</p>
<p>Situação proposta: clique <a href="https://drive.google.com/file/d/1jgq9LnjaaRcYqNkKb-qTChYUCX8PYdmd/view?usp=sharing">aqui</a> para visualizar.</p>
<p>Documentação da API: <a href="https://documenter.getpostman.com/view/18027456/Uz5NitA7">FastParking - API</a> | Em desenvolvimento.</p>

## Vídeo demonstrativo:

<p>Clique no vídeo ou no link abaixo:</p>

[![https://www.youtube.com/watch?v=nnMWSYeTCns](https://img.youtube.com/vi/nnMWSYeTCns/0.jpg)](https://www.youtube.com/watch?v=nnMWSYeTCns)

<p>Vídeo demonstrativo, é utilizada a ferramenta do Postman para teste da API. Clique <a href="https://www.youtube.com/watch?v=nnMWSYeTCns">aqui</a>.</p>

## Desenvolvedores:

<ul>
  <li>Thales Santos - <a href="https://github.com/ThSantos-Dev">GitHub</a>.</li>
  <li>Vivian Guimarães - <a href="https://github.com/ViviGuimaraes">GitHub</a>.</li>
</ul>

## Tecnologias utilizadas:

<ul>
  <li>PHP / Slim Framework v3</li>
  <li>MySQL</li>
</ul>

## Ferramentas utilizadas:

<ul>
  <li>Visual Studio Code - Editor de código</li>
  <li>Postman - Testes da API</li>
  <li>MySQL Workbench - Manipulação do Banco de Dados e Modelo Lógico</li>
  <li>BRModelo 3.0 - Modelo Conceitual do Banco</li>
</ul>

## Instalação:

<ol>
   <li>Baixe o arquivo - Padrão em formato ZIP</li>
   <li>Mova a pasta descompactada para o local do servidor APACHE - Versão utilizada: 2.4</li>
   <li>Vá até a pasta 'sql' e importe o arquivo 'backup.sql' - Versão MySQL 8.0</li>
   <li>Em 'module/config.php' altere o caminho da constante 'SRC' de acordo com a sua máquina.</li>
   <li>Vá até 'model/bd/conexaoMySQL.php' e altera constante DB_SERVER para o local do Banco.</li>
   <li>Inicie o servidor Apache.</li>
   <li>Acesse a documentação no Postman e seja feliz!</li>
</ol>
