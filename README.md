# Gaucho

Framework PHP para single-page-application (SPA)

## Instalação

### 1) Dependências (Composer, Make, Node 10 & NPM)

```
wget https://getcomposer.org/download/latest-stable/composer.phar
sudo mv composer.phar /usr/bin/composer && sudo chmod +x /usr/bin/
curl -sL https://deb.nodesource.com/setup_10.x | sudo -E bash -
sudo purge nodejs -y
sudo apt-get install -y nodejs build-essential npm -y
sudo npm -g install clean-css less terser
```

### 2) Arquivos base

```bash
composer create-project gaucho/gaucho <nome do projeto>
```

### 3) Configurações (.env)

```
cp .env.example .env && nano .env
```

### 4) Arquivos estáticos (SPA)

```
make static
```

### 5) Rodar localmente (via php built-in server)

```
make run
```