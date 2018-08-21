#!/usr/bin/env bash

usage () {
    echo "Usage : $0 [betisier-php|betisier-mysql]"
    exit $1
}

if ! test -v "DOCKER_ID_USER"; then
    echo "DOCKER_ID_USER is not defined, set it first"
    exit 1
fi

if test "$#" -ne 1; then
    echo "Missing mandatory argument"
    usage 1
fi

if test "$1" != "betisier-mysql" && test "$1" != "betisier-php"; then
    echo "Bad argument"
    usage 2
fi

image=$1

username="sylvainmetayer"
docker build "$image" -t "$image"
docker tag "$image" "$username/$image"
docker push "$username/$image"

