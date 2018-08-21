# Docker - Betisier TP

[![Docker Pulls](https://img.shields.io/docker/pulls/sylvainmetayer/betisier-php.svg?style=for-the-badge)](https://hub.docker.com/r/sylvainmetayer/betisier-php/)

## Description

Just a repository to play with docker from an [(old) existing project](https://github.com/sylvainmetayer/Betisier-TP)

## Installation

Copy `db.env.example` to `db.env` and edit it

```bash
cp db.env.example db.env
vim  db.env
```

Copy and edit `config.inc.php.example` to `config.inc.php`

```bash
cp conf/config.inc.php.example conf/config.inc.php
```

Run the docker-compose (See #1 for the `force-recreate` argument)

```bash
docker-compose up --build --force-recreate
```

Go to `http://localhost:8080` to see the application running

## Tag/Push images

```bash
export DOCKER_ID_USER="MY_USERNAME"
docker login
./build.sh [betisier-mysql|betisier-php]
```