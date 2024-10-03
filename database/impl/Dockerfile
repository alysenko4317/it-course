# Use the official Postgres image
FROM postgres:13

# Set the environment variables for the database
ENV POSTGRES_DB=khpi
ENV POSTGRES_USER=khpi
ENV POSTGRES_PASSWORD=khpi

# Create a directory for initialization scripts
RUN mkdir -p /docker-entrypoint-initdb.d

# Copy the SQL scripts to the initialization directory
COPY schema.sql /docker-entrypoint-initdb.d/01-schema.sql
COPY data.sql /docker-entrypoint-initdb.d/02-data.sql

# Mount the current directory to /repo inside the container for running SQL files via psql
VOLUME [ "/repo" ]

# Expose the PostgreSQL default port
EXPOSE 5432
