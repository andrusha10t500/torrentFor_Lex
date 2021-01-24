#!/bin/bash

#clear images and containers
stopped=$(docker ps -qa )
containers=$(docker ps -qa -f "status=exited")
images=$(docker images -q)

docker stop $containers

if [[ -n "$containers" ]]
  then
    docker rm $containers
  else
    echo "Not containers"
fi

if [[ -n "$images" ]]
  then
    docker rmi $images
  else
    echo "Not images"
fi
