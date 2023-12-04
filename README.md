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
  - [Docker](#docker)
  - [MYSQL](#mysql)
  - [Criando container com MySQL Server](#criando-container-com-mysql-server)
    - [Se conectando no MySQL Server e configurando senha](#se-conectando-no-mysql-server-e-configurando-senha)
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
php artisan migrate # esse comando só funcionará após o banco está online e indicado no .env
~~~

## Docker

Para instalar o Docker no WSL (Windows Subsystem for Linux) no Ubuntu, você pode seguir os seguintes passos:

	Observação: Certifique-se de que você tenha o WSL ativado no seu sistema Windows. Você pode ativá-lo nas configurações do Windows.

Caso não tenha o Docker instalado ainda, abra o terminal e atualize os pacotes:

~~~bash
sudo apt-get update
~~~

Instale esses pacotes:

~~~bash
sudo apt-get install \
    apt-transport-https \
    ca-certificates \
    curl \
    gnupg-agent \
    software-properties-common
~~~

Adicione a GPG key oficial do Docker:

~~~bash
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -
~~~

Adicione o repositório:

~~~bash
sudo add-apt-repository \
   "deb [arch=amd64] https://download.docker.com/linux/ubuntu \
   $(lsb_release -cs) \
   stable"
~~~

Atualize os pacotes novamente e adicione o Docker Engine:

~~~bash
sudo apt-get install docker-ce docker-ce-cli containerd.io
~~~

Para evitar ter que usar o sudo o tempo todo, crie um grupo docker e adicione seu user no grupo:

~~~bash
$ sudo groupadd docker
$ sudo usermod -aG docker $USER
$ newgrp docker
~~~

Abra e feche o terminal, depois rode

~~~bash
docker run hello-world
~~~

Para checar que está tudo ok.

## MYSQL

O MySQL é um sistema de gerenciamento de banco de dados relacional (SGBDR) que foi inicialmente lançado em 1995. Ele é um dos sistemas de gerenciamento de banco de dados mais populares e amplamente utilizados no mundo, conhecido por sua confiabilidade, desempenho e facilidade de uso.

## Criando container com MySQL Server

Para criar um container com o MySQL faça o seguinte:

~~~bash
docker run -p 3306:3306 --name=seu-container -d mysql/mysql-server
~~~

Esse comando roda um container chamado “seu-container” a partir de uma imagem do MySQL Server e mapeia a porta 3306 do container com a sua de mesmo número. Dê um docker ps e veja o que tem rodando na sua máquina.

### Se conectando no MySQL Server e configurando senha

Pegue a senha randômica gerada:

~~~bash
docker logs seu-container 2>&1 | grep GENERATED
~~~

Copie a root password que apareceu e rode o comando:

~~~bash
docker exec -it seu-container mysql -uroot -p
~~~

Cole a password e dê enter. Depois disso, já no server, digite:

~~~bash
ALTER USER 'root'@'localhost' IDENTIFIED BY '12345';
~~~

Isso vai mudar a senha padrão do usuário para 12345. Depois rode o seguinte:

~~~bash
update mysql.user set host = '%' where user='root';
~~~

Esse comando vai permitir que você conecte o Workbench no container. Dê um ctrl-D e depois um 

~~~bash
docker restart seu-container
~~~

Para se conectar ao mysql você deve usar as seguintes configurações:

- host: localhost
- username: root
- port: 3306
- password: 12345 (ou aquele que você tiver configurado)

Também é necessário instalar o pacote php-mysql para se conectar ao banco de dados:

~~~bash
sudo apt-get install php-mysql
~~~

Apenas após esses passos você deve rodar:

~~~bash
php artisan migrate
~~~

## Referências

https://dev.to/nfo94/como-criar-um-container-com-mysql-server-com-docker-e-conecta-lo-no-workbench-linux-1blf
