# Docker - Betisier TP

[![Docker Pulls](https://img.shields.io/docker/pulls/sylvainmetayer/betisier-php.svg?style=for-the-badge)](https://hub.docker.com/r/sylvainmetayer/betisier-php/)
[![Docker Pulls](https://img.shields.io/docker/pulls/sylvainmetayer/betisier-mysql.svg?style=for-the-badge)](https://hub.docker.com/r/sylvainmetayer/betisier-mysql/)

## Description

Just a repository to play with docker from an [(old) existing project](https://github.com/sylvainmetayer/Betisier-TP)

## Configuration

Copy `db.env.example` to `db.env` and edit it

```bash
cp db.env.example db.env
vim  db.env
```

Copy and edit `config.inc.php.example` to `config.inc.php`

```bash
cp conf/config.inc.php.example conf/config.inc.php
```

## Run containers

1. You first need to create a internal network
2. Start the php and mysql containers
3. Finally, launch the nginx container
4. **You may need to relaunch containers if you encountered an error**. 
    - See [this issue (#1)](https://github.com/sylvainmetayer/docker-betisier-tp/issues/1) and/or go to `restart containers` section to know how to restart.

```bash
docker network create nginx-network && \
docker-compose -f docker-compose.app.yml up -d && \
docker-compose -f docker-compose.nginx.yml up -d
```

Go to `http://test.sylvainmetayer.fr:8080` to see the application running

- edit your hosts file if needed `echo 127.0.0.1 test.sylvainmetayer.fr | sudo tee -a /etc/hosts`

## Restart containers

```bash
docker-compose -f docker-compose.app.yml restart && \
docker-compose -f docker-compose.app.yml restart
```

## Stop containers

```bash
docker-compose -f docker-compose.nginx.yml down && \
docker-compose -f docker-compose.app.yml down && \
docker network rm nginx-network
```

## Tag/Push images

```bash
export DOCKER_ID_USER="MY_USERNAME"
docker login
./build.sh [betisier-mysql|betisier-php]
```

## Stop/Erase all images

WARNING : **This will erase ALL your docker images !**

```bash
docker stop $(docker ps -a -q) && docker system prune -a
```
