# Docker - Betisier TP

[![Docker Pulls](https://img.shields.io/docker/pulls/sylvainmetayer/betisier-php.svg?style=for-the-badge)](https://hub.docker.com/r/sylvainmetayer/betisier-php/)
[![Docker Pulls](https://img.shields.io/docker/pulls/sylvainmetayer/betisier-mysql.svg?style=for-the-badge)](https://hub.docker.com/r/sylvainmetayer/betisier-mysql/)

## Description

Just a repository to play with docker and [Traefik](https://traefik.io/) from an [(old) existing project](https://github.com/sylvainmetayer/Betisier-TP)

## Development

1. Edit database configuration

    ```bash
    cp db.env.example db.env
    vim  db.env
    ```

2. Edit application configuration according to your database configuration

    ```bash
    cp conf/config.inc.php.example conf/config.inc.php
    vim conf/config.inc.php
    ```

3. Run it

    ```bash
    docker-compose -f dev.yml up -d
    ```

The site is now available at [http://localhost:8080](http://localhost:8080)

## Actions on containers

- Restart
    ```bash
    docker-compose -f dev.yml restart
    ```

- Stop containers
    ```bash
    docker-compose -f dev.yml stop
    ```

- Remove containers
    ```bash
    docker-compose -f dev.yml down
    ```

- See logs

    ```bash
    docker logs betisier_php
    docker logs betisier_db
    ```
    > Add `-f` at the end of the command to see live changes

## Deployement

See the [Wiki](https://github.com/sylvainmetayer/docker-betisier-tp/wiki/) for additional information.