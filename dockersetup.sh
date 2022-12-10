#!/usr/bin/env bash
mkdir db
mkdir dbdump
cp tabla.sql ./dbdump/tabla.sql
echo Minden előkészítve, most elindítjuk a Docker konténereket!
docker-compose up