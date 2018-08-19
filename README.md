# Docker - Betisier TP

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

Run the container (see #1 for the `--force-recreate`)

```bash
docker-compose up --build --force-recreate
```

Go to `http://localhost:8080` to see the application running