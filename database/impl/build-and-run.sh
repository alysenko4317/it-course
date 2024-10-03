docker build -t lab2 ./
docker run -d -p 5432:5432/tcp --name lab2-container lab2