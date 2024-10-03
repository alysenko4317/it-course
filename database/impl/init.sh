docker cp init.sql lab2-container:/
docker exec -it lab2-container psql -U postgres -d khpi -f /init.sql