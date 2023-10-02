# Sistema de Chat em Tempo Real com Laravel WebSockets

A aplicação será um chat em tempo real que permitirá dois usuários se comunicarem por mensagens de texto. Cada conversa ficará separada e indicada com o nome da pessoa com quem o usuário está se comunicando. Caso exista uma nova mensagem não lida, um indicativo visual irá aparecer para informar o usuário. Esse indicativo desaparecerá no momento em que a conversa for aberta.

Linguagens usadas no projeto:  

* PHP: é uma linguagem interpretada livre, usada originalmente apenas para o desenvolvimento de aplicações presentes e atuantes no lado do servidor, capazes de gerar conteúdo dinâmico na World Wide Web;

* Javascript: é uma linguagem de programação interpretada estruturada, de script em alto nível com tipagem dinâmica fraca e multiparadigma. Juntamente com HTML e CSS, o JavaScript é uma das três principais tecnologias da World Wide Web.
	
Frameworks:  

* Laravel: é um framework PHP livre e open-source criado por Taylor B. Otwell para o desenvolvimento de sistemas web que utilizam o padrão MVC;
  * Laravel Jetstream: é um pacote open source mantido pela equipe do Laravel e nos dá a possibilidade de começar uma aplicação já com diversas funcionalidades prontas;

* Node: é um software de código aberto, multiplataforma, baseado no interpretador V8 do Google e que permite a execução de códigos JavaScript fora de um navegador web. A principal característica do Node.js é sua arquitetura assíncrona e orientada por eventos;

* Vue: é um framework JavaScript de código-aberto, focado no desenvolvimento de interfaces de usuário e aplicativos de página única;

  * Vuex: é uma biblioteca de gerenciamento de estado de código aberto para aplicativos Vue.js. Ele foi criado por Evan You, o desenvolvedor por trás do Vue.js, para fornecer um armazenamento centralizado para gerenciamento de estado em aplicativos Vue.js;

* Tailwind CSS: é uma estrutura CSS de código aberto. A principal característica desta biblioteca é que, ao contrário de outros frameworks CSS como o Bootstrap, ela não fornece uma série de classes predefinidas para elementos como botões ou tabelas.
		
Ferramentas auxiliares:  

* Composer: é um gerenciador de dependências em nível de aplicativo para a * linguagem de programação PHP que fornece um formato padrão para gerenciar * dependências de software PHP e bibliotecas necessárias;

* NVM: é um gerenciador de versão para node.js, projetado para ser instalado * por usuário e invocado por shell;

* NPM: é um gerenciador de pacotes para o Node.JS npm, Inc. é uma subsidiária * do GitHub, que fornece hospedagem para desenvolvimento de software e * controle de versão com o uso do Git. npm é o gerenciador de pacotes padrão * para o ambiente de tempo de execução JavaScript Node.js;

* Inertia: é uma estratégia ou técnica para desenvolver Aplicações de Página * Única (Single Page Applications, SPA). Ele permite o desenvolvedor utilizar * as frameworks atuais do lado do servidor para construir um SPA moderno sem * a complexidade que vem com ele.

## Instalação no WSL UBUNTU 20.04

Atualize o ubuntu:

	sudo apt-get update

### Instalando Javascript e seus managers

Instalar o nvm (Node Version Manager):

	sudo apt install curl 
	curl https://raw.githubusercontent.com/creationix/nvm/master/install.sh | bash 

Rode o comando para verificar se foi realizada a instalação corretamente, o comando não deve retornar nada:

	source ~/.bashrc   

Estando tudo certo instale o node e o npm (Node Package Manager) com o seguinte comando:

	nvm install --lts

Atualize o npm para a última versão com o comando:

	npm install -g npm

Verifique se a instalação foi realizada com sucesso:

	node -v
	npm -v
	nvm -v

### Instalando Laravel Jetstream com Inertia.js

É necessário já possuir o PHP, Laravel e Composer instalados. Verifique se já possui o php instalado, depois o Laravel e por último o composer:

	php -v
	laravel -v
	composer --version
	
Se não possuir siga os passos abaixo.

### PHP

    incluir aqui instalação do PHP, Laravel e Composer

### Composer

Instale o composer localmente com os seguintes comandos:

	php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"

	php -r "if (hash_file('sha384', 'composer-setup.php') === '48e3236262b34d30969dca3c37281b3b4bbe3221bda826ac6a9a62d6444cdb0dcd0615698a5cbe587c3f0fe57a54d8f5') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
	
    php composer-setup.php
	
    php -r "unlink('composer-setup.php');"
	
Este script de instalação irá simplesmente verificar algumas configurações do php.ini, avisar se elas estiverem configuradas incorretamente e, em seguida, baixar o compositor.phar mais recente no diretório atual. As 4 linhas acima irão, em ordem:

1. Baixar o instalador para o diretório atual
2. Verificar o instalador SHA-384 que você também pode verificar aqui
3. Executar o instalador
4. Remover o instalador
 
Mova o arquivo compositor.phar para o seu caminho global:
	
	sudo mv composer.phar /usr/local/bin/composer
	
Atualize o composer (se necessário):

	sudo -H composer self-update
	
### Laravel

Instalando o laravel globalmente com composer

	composer global require laravel/installer

Adicione o Laravel ao caminho global adicionando esta linha ao arquivo .bashrc:

	export PATH=~/.composer/vendor/bin:$PATH

### Jetstream e Inertia.js
Começamos criando um projeto em Laravel com o comando (substitua example-app pelo nome do projeto):
	
	composer create-project laravel/laravel example-app
	
Vá para a pasta criada:

	cd example-app
	
Use o composer para instalar o Jetstream:

	composer require laravel/jetstream
	
Então, instale o Inertia com o artisan (interface de Linha de Comando do Laravel, que pode realizar diversas ações em nossas aplicações):

	php artisan jetstream:install inertia
	
Após instalado é preciso instalar as dependências do projeto com os seguintes comandos:

	npm install
	npm run build
	php artisan migrate -- problema, preciso ter um banco configurado no wsl para poder rodar o migrate
	
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