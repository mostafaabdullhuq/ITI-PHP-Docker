# Use an existing Docker image as the base image
FROM php:apache

# Download and install a dependency
RUN apt update

# copy the app folder than contains the php app to the docker container
ADD app /var/www/html
