<h1 align="center">
Mini E-commerce
</h1>

<h3 align="center">
Simulação de um e-commerce, desde a listagem de produtos até a finalização da compra.
</h3>

## Sobre
Neste projeto além de PHP e Laravel, também foram utilizados os seguintes conhecimentos:
- Arquitetura limpa
- SOLID
- Código limpo
- Testes unitários
- Eloquent
- Javascript


## Rodando projeto
### Pré-requisitos
- Git
- Docker

### Passo a Passo
- 1- Clonar o repositório
```
https://github.com/nepogabriel/mini-ecommerce-laravel.git
```

- 2- Entre no diretório 
```bash
cd nome-do-diretorio
```

- 3- Configure variáveis de ambiente
```bash
cp .env.example .env
```

- 4- Instale as dependências
```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs
```

- 5- Inicie o container
```bash
./vendor/bin/sail up -d
```

- 6- Acesse o container
```bash
docker exec -it mini-ecommerce-laravel-laravel.test-1 bash
```
OU
```bash
docker exec -it {nome-diretorio}-laravel.test-1 bash
```

- 7- Dentro do container execute para gerar uma chave do laravel
```bash
php artisan key:generate
```

- 8- Dentro do container execute para criar as tabelas do banco de dados
```bash
php artisan migrate
```

- **Observação:** Caso apresente erro ao criar as tabelas do banco de dados, tente os comandos abaixo e execute novamente o comando para criação das tabelas. 
``` bash
# Primeiro comando
docker exec -it {nome-diretorio}-laravel.test-1 bash

# Segundo comando
composer update
```

- 9- Este projeto usa seeders, dentro do container use o comando abaixo
``` bash
php artisan db:seed --class=ProductSeeder
```

- 10- Para os testes unitários, dentro do container rode
``` bash
php artisan test
```

- 11- Link de acesso
```
http://localhost:8787/
```

### Banco de dados
- Porta externa: 33009
- Porta interna: 3306
- Banco de dados: bd_mini_ecommerce
- Usuário: root
- Senha:

## 👥 Contribuidor
Gabriel Ribeiro.
🌐 https://linkedin.com/in/gabriel-ribeiro-br/
