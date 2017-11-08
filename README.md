# COM212Final

Repositpório trabalho final de Gerencia de Projetos

Documentos - Todos os documentos do projeto

SISCOOG - Implementação do SISCOOG feito em Laravel

## Mandamentos para este projeto

* **Nunca dê um commit na master - fique atento a que Release estamos!**
* **Antes de começar a programar de um pull do projeto!**
* **Depois que terminar de push do projeto!**

## Como programar

Depois de clonar o projeto entre na pasta SISCOOG

1) Renomeie o arquivo `.env.example´ para `.env` (este arquivo se encontra na raiz)
    * Abra o arquivo e mude as credenciais do banco de acordo com o que vc tem ai
        * Se vc tinha um banco da versão anterior (Release01) exclua e crie um novo
2)  Abra o terminal (prompt) e digite `composer update` (isso vai demorar um pouco)
3) Depois entre com o comando `php artisan migrate` e `php artisan db:seed` para criar as tabelas e popular o banco
4) Pronto agora vc pode desenvolver o projeto sem medo
