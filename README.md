# Docker - Betisier TP

[![Docker Pulls](https://img.shields.io/docker/pulls/sylvainmetayer/betisier-php.svg?style=for-the-badge)](https://hub.docker.com/r/sylvainmetayer/betisier-php/)
[![Docker Pulls](https://img.shields.io/docker/pulls/sylvainmetayer/betisier-mysql.svg?style=for-the-badge)](https://hub.docker.com/r/sylvainmetayer/betisier-mysql/)

## Description

Just a repository to play with docker and [Traefik](https://traefik.io/) from an [(old) existing project](https://github.com/sylvainmetayer/Betisier-TP)

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

In progress :

- Hard way

  ```bash
  docker stop $(docker ps -a -q) && \
  docker system prune -a -f && \
  docker network create traefik && \
  docker-compose -f traefik.yml up -d && \
  docker-compose up -d && \
  docker ps
  ```

- Production (expose to `http://test.sylvainmetayer.fr`)
  - edit your hosts file if needed `echo 127.0.0.1 test.sylvainmetayer.fr | sudo tee -a /etc/hosts`
  - Go to `http://127.0.0.1:8083` with credentials `ocyhc:ocyhc` to see admin panel
  - Go to `http://127.0.0.1:8082/ping` to see if traefik is alive

  ```bash
  docker network create traefik && \
  docker-compose up -d && \
  docker-compose -f traefik.yml up -d
  ```

- Dev (expose to `localhost:8080`) -> Not tested yet WIP

  ```bash
  docker-compose -f dev.yml up -d
  ```

## TODO

- HTTPS (see [traefik.toml](traefik.toml))
- Handle multiple backend with traefik
- See if we can use php-fpm instead of php-apache ([See this issue on traefik](https://github.com/containous/traefik/issues/753))

## Resources

- [Timeout Traefik](https://stackoverflow.com/questions/46161017/gateway-timeout-with-traefik-and-php-fpm)
