<a name="ancora"></a>
# Sistema de Chat em Tempo Real com Laravel WebSockets
## Conteúdos
- [Sistema de Chat em Tempo Real com Laravel WebSockets](#sistema-de-chat-em-tempo-real-com-laravel-websockets)
	- [Conteúdos](#conteúdos)
	- [Projeto](#projeto)
		- [Linguagens](#linguagens)
		- [Frameworks](#frameworks)
		- [Ferramentas auxiliares](#ferramentas-auxiliares)
	- [Instalação no WSL UBUNTU 20.04](#instalação-no-wsl-ubuntu-2004)
		- [Instalando Javascript e seus managers](#instalando-javascript-e-seus-managers)
		- [Instalando Laravel Jetstream com Inertia.js](#instalando-laravel-jetstream-com-inertiajs)
			- [PHP](#php)
			- [Composer](#composer)
			- [Laravel](#laravel)
		- [Jetstream e Inertia.js](#jetstream-e-inertiajs)
	- [NGINX](#nginx)
	- [MYSQL](#mysql)
	- [Docker](#docker)
		- [Fixando alguns conceitos básicos do Docker: Containeres e Imagens](#fixando-alguns-conceitos-básicos-do-docker-containeres-e-imagens)
		- [Dockerfile e Docker Compose](#dockerfile-e-docker-compose)
		- [Volumes](#volumes)
	- [Conectando ao Banco de Dados](#conectando-ao-banco-de-dados)
	- [Referências](#referências)

## Projeto

A aplicação será um chat em tempo real que permitirá dois usuários se comunicarem por mensagens de texto. Cada conversa ficará separada e indicada com o nome da pessoa com quem o usuário está se comunicando. Caso exista uma nova mensagem não lida, um indicativo visual irá aparecer para informar o usuário. Esse indicativo desaparecerá no momento em que a conversa for aberta.

### Linguagens

* PHP: é uma linguagem interpretada livre, usada originalmente apenas para o desenvolvimento de aplicações presentes e atuantes no lado do servidor, capazes de gerar conteúdo dinâmico na World Wide Web;

* Javascript: é uma linguagem de programação interpretada estruturada, de script em alto nível com tipagem dinâmica fraca e multiparadigma. Juntamente com HTML e CSS, o JavaScript é uma das três principais tecnologias da World Wide Web.
	
### Frameworks

* Laravel: é um framework PHP livre e open-source criado por Taylor B. Otwell para o desenvolvimento de sistemas web que utilizam o padrão MVC;
  * Laravel Jetstream: é um pacote open source mantido pela equipe do Laravel e nos dá a possibilidade de começar uma aplicação já com diversas funcionalidades prontas;

* Node: é um software de código aberto, multiplataforma, baseado no interpretador V8 do Google e que permite a execução de códigos JavaScript fora de um navegador web. A principal característica do Node.js é sua arquitetura assíncrona e orientada por eventos;

* Vue: é um framework JavaScript de código-aberto, focado no desenvolvimento de interfaces de usuário e aplicativos de página única;

  * Vuex: é uma biblioteca de gerenciamento de estado de código aberto para aplicativos Vue.js. Ele foi criado por Evan You, o desenvolvedor por trás do Vue.js, para fornecer um armazenamento centralizado para gerenciamento de estado em aplicativos Vue.js;

* Tailwind CSS: é uma estrutura CSS de código aberto. A principal característica desta biblioteca é que, ao contrário de outros frameworks CSS como o Bootstrap, ela não fornece uma série de classes predefinidas para elementos como botões ou tabelas.
		
### Ferramentas auxiliares

* Composer: é um gerenciador de dependências em nível de aplicativo para a * linguagem de programação PHP que fornece um formato padrão para gerenciar * dependências de software PHP e bibliotecas necessárias;

* NVM: é um gerenciador de versão para node.js, projetado para ser instalado * por usuário e invocado por shell;

* NPM: é um gerenciador de pacotes para o Node.JS npm, Inc. é uma subsidiária * do GitHub, que fornece hospedagem para desenvolvimento de software e * controle de versão com o uso do Git. npm é o gerenciador de pacotes padrão * para o ambiente de tempo de execução JavaScript Node.js;

* Inertia: é uma estratégia ou técnica para desenvolver Aplicações de Página * Única (Single Page Applications, SPA). Ele permite o desenvolvedor utilizar * as frameworks atuais do lado do servidor para construir um SPA moderno sem * a complexidade que vem com ele.

## Instalação no WSL UBUNTU 20.04

Atualize o ubuntu:

~~~bash
sudo apt-get update
~~~

### Instalando Javascript e seus managers

Instalar o nvm (Node Version Manager):

~~~bash
sudo apt install curl 
curl https://raw.githubusercontent.com/creationix/nvm/master/install.sh | bash 
~~~

Rode o comando para verificar se foi realizada a instalação corretamente, o comando não deve retornar nada:

~~~bash
source ~/.bashrc   
~~~

Estando tudo certo instale o node e o npm (Node Package Manager) com o seguinte comando:

~~~bash
nvm install --lts
~~~

Atualize o npm para a última versão com o comando:

~~~bash
npm install -g npm
~~~

Verifique se a instalação foi realizada com sucesso:

~~~bash
node -v
npm -v
nvm -v
~~~

### Instalando Laravel Jetstream com Inertia.js

É necessário já possuir o PHP, Laravel e Composer instalados. Verifique se já possui o php instalado, depois o Laravel e por último o composer:

~~~bash
php -v
laravel -v
composer --version
~~~

Se não possuir siga os passos abaixo.

#### PHP

**incluir aqui instalação do PHP, Laravel e Composer**

#### Composer

Instale o composer localmente com os seguintes comandos:

~~~bash
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"

php -r "if (hash_file('sha384', 'composer-setup.php') === '48e3236262b34d30969dca3c37281b3b4bbe3221bda826ac6a9a62d6444cdb0dcd0615698a5cbe587c3f0fe57a54d8f5') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"

php composer-setup.php

php -r "unlink('composer-setup.php');"
~~~

Este script de instalação irá simplesmente verificar algumas configurações do php.ini, avisar se elas estiverem configuradas incorretamente e, em seguida, baixar o compositor.phar mais recente no diretório atual. As 4 linhas acima irão, em ordem:

1. Baixar o instalador para o diretório atual
2. Verificar o instalador SHA-384 que você também pode verificar aqui
3. Executar o instalador
4. Remover o instalador

Mova o arquivo compositor.phar para o seu caminho global:

~~~bash	
sudo mv composer.phar /usr/local/bin/composer
~~~

Atualize o composer (se necessário):

~~~bash
sudo -H composer self-update
~~~

#### Laravel

Instalando o laravel globalmente com composer

~~~bash
composer global require laravel/installer
~~~

Adicione o Laravel ao caminho global adicionando esta linha ao arquivo .bashrc:

~~~bash
export PATH=~/.composer/vendor/bin:$PATH
~~~

### Jetstream e Inertia.js
Começamos criando um projeto em Laravel com o comando (substitua example-app pelo nome do projeto):

~~~bash	
composer create-project laravel/laravel example-app
~~~

Vá para a pasta criada:

~~~bash
cd example-app
~~~

Use o composer para instalar o Jetstream:

~~~bash
composer require laravel/jetstream
~~~

Então, instale o Inertia com o artisan (interface de Linha de Comando do Laravel, que pode realizar diversas ações em nossas aplicações):

~~~bash
php artisan jetstream:install inertia
~~~

Após instalado é preciso instalar as dependências do projeto com os seguintes comandos:

~~~bash
npm install
npm run build
php artisan migrate -- problema, preciso ter um banco configurado no wsl para poder rodar o migrate
~~~

## NGINX

O Nginx (pronunciado "engine x") é um servidor web de código aberto que também pode ser utilizado como proxy reverso, balanceador de carga, servidor de email proxy HTTP e servidor de cache. Ele foi criado por Igor Sysoev e lançado pela primeira vez em 2004. Desde então, o Nginx se tornou amplamente popular e é usado por muitos sites de alto tráfego, serviços online e aplicativos web.

Verifique se o nginx está instalado, se estiver, esse comando servirá para verificar se ele está ativo:

~~~bash
sudo service nginx status
~~~

Caso não tenha ele instalado você deve instalar com os comandos:

~~~bash
sudo apt update
sudo apt install nginx
~~~

Para iniciar o serviço você deve escrever:

~~~bash
sudo service nginx start
~~~

E para verificar seu status basta usar o primeiro comando novamente:

~~~bash
sudo service nginx status
~~~

## MYSQL

O MySQL é um sistema de gerenciamento de banco de dados relacional (SGBDR) que foi inicialmente lançado em 1995. Ele é um dos sistemas de gerenciamento de banco de dados mais populares e amplamente utilizados no mundo, conhecido por sua confiabilidade, desempenho e facilidade de uso.


## Docker

Para instalar o Docker no WSL (Windows Subsystem for Linux) no Ubuntu, você pode seguir os seguintes passos:

	Observação: Certifique-se de que você tenha o WSL ativado no seu sistema Windows. Você pode ativá-lo nas configurações do Windows.

1. Abra o terminal do Ubuntu no WSL.

2. Atualize o índice de pacotes do sistema:

~~~bash
sudo apt update
~~~

3. Instale pacotes pré-requisitos que permitem ao sistema apt usar pacotes via HTTPS:

~~~bash
sudo apt install apt-transport-https ca-certificates curl software-properties-common
~~~

4. Adicione a chave GPG oficial do Docker:

~~~bash
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /usr/share/
keyrings/docker-archive-keyring.gpg
~~~

5. Adicione o repositório Docker ao seu sistema:

~~~bash
echo "deb [signed-by=/usr/share/keyrings/docker-archive-keyring.gpg] https://download.docker.com/
linux/ubuntu $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null
~~~

6. Atualize novamente o índice de pacotes do sistema para incluir o novo repositório:

~~~bash
sudo apt update
~~~

7. Instale a versão mais recente do Docker:

~~~bash
sudo apt install docker-ce docker-ce-cli containerd.io
~~~

8. Adicione seu usuário ao grupo "docker" para executar comandos Docker sem a necessidade de sudo:

~~~bash
sudo usermod -aG docker $USER
~~~
Após esse comando, saia e entre novamente na sessão do WSL ou reinicie o WSL.

9. Verifique se a instalação foi bem-sucedida executando o seguinte comando:

~~~bash
docker --version
~~~
Agora você deve ter o Docker instalado e pronto para ser usado no seu ambiente WSL Ubuntu. Certifique-se de que o daemon do Docker está em execução antes de tentar usar comandos Docker:

~~~bash
sudo service docker start
~~~
Isso deve permitir que você comece a usar o Docker no seu ambiente WSL.

### Fixando alguns conceitos básicos do Docker: Containeres e Imagens

- **Container**: é o local onde a sua aplicação ficará rodando.

- **Imagem**: É como um snapshot. Outros desenvolvedores com acesso a esta imagem, terão os mesmos recursos que você utiliza e configurou em seu container.

Para que você possa trabalhar com o Docker, é extremamente necessário que você conheça seus principais comandos. Vamos lá!

O primeiro comando é o **_docker ps_** , esse comando irá lhe mostrar quais o containers foram criados e estão rodando.

Um segundo comando, muito importante, é o **_docker images_** , esse comando mostra quais imagens foram criadas.

### Dockerfile e Docker Compose

Durante essa nossa jornada, trabalharemos com um arquivo chamado de Dockerfile.

- **Dockerfile**: "O Dockerfile é um arquivo de texto que contém as instruções necessárias para criar uma nova imagem de contêiner. Essas instruções incluem a identificação de uma imagem existente a ser usada como uma base, comandos a serem executados durante o processo de criação da imagem e um comando que será executado quando novas instâncias da imagem de contêiner forem implantadas.”
(Fonte: www.docker.com)

Vamos então criar um arquivo chamado Dockerfile no projeto.

Por padrão, utilizaremos uma imagem Docker que nos trará o PHP-FPM e o Nginx já configurados. Você poderá encontrar essa imagem acessando https://hub.docker.com¹ e pesquisando por wyveo/nginx-php-fpm.

Em nossa IDE, no arquivo Dockerfile que criamos, inserimos o seguinte código:

~~~yaml
FROM wyveo/nginx-php-fpm:latest
~~~

A instrução **_FROM_** define a imagem de container que será usada durante o processo de criação de nova imagem, wyveo/nginx-php-fpm é o endereço da imagem e _latest_ indica que queremos a versão mais atual dessa imagem.

É necessário explicar que esse código traz uma instalação crua do nginx com PHP-FPM. Por padrão, o nginx, quando instalado dessa forma, mantém seu Document Root no seguinte caminho:

~~~bash
/usr/share/nginx/html
~~~

- **Docker-compose**: O docker-compose é uma ferramenta do Docker que, a partir de diversas especificações, permite subir diversos containeres e relacioná-los através de redes internas.

O docker-compose é uma ferramenta separada do Docker, embora frequentemente usada em conjunto. Enquanto o Docker é utilizado para criar, gerenciar e executar contêineres individuais, o docker-compose é utilizado para definir e executar aplicativos compostos por vários contêineres.

O docker-compose permite que você defina as configurações de vários contêineres em um arquivo YAML (geralmente chamado de docker-compose.yml) e, em seguida, inicie esses contêineres com um único comando. Ele é especialmente útil quando você tem uma aplicação composta por vários serviços, cada um em seu próprio contêiner, e precisa orquestrá-los de maneira eficiente.

Se você não tem o docker-compose instalado, você precisará instalá-lo separadamente. Aqui estão os passos para instalar o docker-compose no WSL (Ubuntu):

1. Baixe a versão mais recente do docker-compose:

~~~bash
sudo curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
~~~

Certifique-se de que o arquivo docker-compose seja executável:

~~~bash
sudo chmod +x /usr/local/bin/docker-compose
~~~

2. Verifique se o docker-compose foi instalado corretamente:

~~~bash
docker-compose --version
~~~

Agora você deverá conseguir usar o comando docker-compose. Este comando é valioso ao lidar com projetos que envolvem vários contêineres, facilitando a definição, execução e gerenciamento desses contêineres como uma aplicação única.

Para isso, vamos iniciar criando um arquivo chamado de docker-compose.yaml.

No arquivo docker-compose, declaramos a seguinte estrutura:

~~~yaml
version: '3'

services:
  laravel-app:
    build: .
    ports:
      - "8080:80"
~~~

_version_: declara a versão do docker compose

_services_: declara quais serviços serão rodados, nesse caso, chamaremos de laravel-app.

_build_: declara o nome da imagem, ou, no caso, se declararmos o ., ele irá “chamar” a imagem declarada no Dockerfile.

_ports_: realiza a liberação das portas. Nesse exemplo, queremos que seja liberada a porta 8080, porém, quando acessada, seja feito um redirecionamento para a porta 80 de nosso container. Logo, toda vez que acessarmos o localhost com a porta 8080 o Docker redirecionará a requisição para a porta 80 do nginx criado no container.

Acessando o nosso terminal, subiremos o container com o comando:

~~~bash
docker-compose up -d
~~~

O docker-compose up irá rodar o docker-compose, baseado em nosso docker-compose.yaml e com o -d o container é inicializado em segundo plano e podemos utilizar o nosso terminal para outros comandos.

Acessamos o nosso browser e já podemos ver o nosso nginx rodando.

Lembando que, em nosso docker-compose.yaml, indicamos que acessaremos a porta 8080 de nossa máquina e essa acessará a porta 80 do nosso container.

Você pode usar os comandos _docker ps_ e _docker images_ para ver o docker rodando.

### Volumes

O Docker possui um mecanismo de gerenciamento de volumes que com ele é possível compartilharmos um volume da nossa máquina com o container.

Em nosso docker-compose.yaml iremos declarar:

~~~yaml
    volumes:
      - ./:/usr/share/nginx
~~~

Quando criamos esse volume, tudo o que estiver em nossa pasta será montado dentro do nosso container, ou seja, tudo o que modificarmos em nossa pasta será compartilhado com o container, porém, caso “matarmos” o container, ainda teremos os arquivos em nossa máquina.

E assim fica o nosso docker-compose.yaml:

~~~yaml
version: '3'

services:
  laravel-app:
    build: .
    ports:
      - "8080:80"
    volumes:
      - ./:/usr/share/nginx
~~~

Vamos testar? Com o comando abaixo subiremos as modificações realizadas em nosso docker-compose.yaml:

~~~bash
docker-compose up -d --build
~~~

Para evitar que tenhamos um erro 404 ou 500 no nginx (pois ele está buscando por padrão a pasta html), criaremos um link simbólico apontando a pasta public de nosso projeto Laravel para html.

Esse link simbólico é criado rodando: ln -s public html em seu terminal. O link simbólico, na verdade, funciona como um atalho, pois toda vez que acessarmos a pasta html na verdade estaremos acessando a pasta public:

~~~bash
ln -s public html
~~~

Note a pasta html:

~~~bash
ls
~~~

Agora, finalmente podemos visualizar a imagem do Laravel sendo executada no navegador.

## Conectando ao Banco de Dados

Agora que já temos o nosso Laravel rodando, iremos realizar algumas declarações em nosso dockercompose.yaml. Criaremos um serviço chamado: 
~~~yaml
mysql-app:
~~~

Nesse serviço vamos declarar que utilizaremos uma imagem do MySQL. Essa imagem pode ser
facilmente encontrada no https://hub.docker.com².

~~~yaml
image: mysql:5.7.22
~~~

O nosso MySQL também utilizará portas:

~~~yaml
ports:
  - "3306:3306"
~~~

Com essa declaração estamos dizendo que, tanto a porta de nossa máquina quanto a porta de nosso
container serão as mesmas.

A imagem do MySQL foi preparada para que possamos trabalhar com variáveis de ambiente. Utilizaremos uma variável de ambiente que cria o banco de dados com uma senha, facilitando todo
o trabalho.

~~~yaml
environment:
  MYSQL_DATABASE: laravel
  MYSQL_ROOT_PASSWORD: laravel
~~~

Dando prosseguimento, para que essas máquinas possam conversar entre si, é necessário que
compartilhemos uma rede interna:

~~~yaml
networks:
  - app-network
~~~

Esse serviço deve ser criado em nosso _laravel-app_ e em nosso _mysql-app_.

Declaramos, também, fora dos serviços a criação da rede propriamente dita:

~~~yaml
networks:
  app-network:
    driver: bridge
~~~

Esse é o resultado final:

~~~yaml
version: '3'

services:
  laravel-app:
    build: .
    ports:
      - "8080:80"
    volumes:
      - ./:/usr/share/nginx
    networks:
      - app-network

  mysql-app:
    image: mysql:5.7.22
    ports:
      - "3306:3306"
    environment:
      MYSQL_DATABASE: laravel
      MYSQL_ROOT_PASSWORD: laravel
    networks:
      - app-network

networks:
  app-network:
    driver: bridge
~~~

Pronto para testar? Primeiro, vamos derrubar nosso container:

~~~bash
docker-compose down
~~~

Em seguida, subimos novamente:

~~~bash
docker-compose up -d --build
~~~

Agora, para que o Laravel possa se conectar com o container do MySQL, vamos rapidamente editar o arquivo .env de nosso projeto. Ele é responsável por todas as configurações desse framework. Nesse caso, vamos alterar as credenciais de acesso ao banco de dados de acordo com o que foi informado no docker-compose.yaml. Ele deve ficar assim:

~~~
DB_CONNECTION=mysql
DB_HOST=mysql-app
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=laravel
~~~

## Referências

https://www.treinaweb.com.br/blog/criando-um-ambiente-de-desenvolvimento-php-com-wsl  
https://tecadmin.net/how-to-install-nvm-on-ubuntu-20-04/  
https://getcomposer.org/download/  
https://laravel.com/docs/10.x  
https://jetstream.laravel.com/introduction.html  
https://laravel.com/docs/5.8/installation  
https://nodejs.org/en/docs  
https://docs.npmjs.com  
https://github.com/nvm-sh/nvm  
https://vuejs.org/guide/introduction.html  
https://vuex.vuejs.org  
https://inertiajs.com  
https://tailwindcss.com/docs/installation  