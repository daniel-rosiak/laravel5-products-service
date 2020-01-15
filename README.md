# DOCKER

Add to hosts in Your system:
<docker ip> chalhoub.api.lo

Unix
/etc/hosts

Windows
%SystemRoot%\system32\drivers\etc\hosts

## RUN

docker-compose up -d

mind that first start installs all the dependencies and sets up the project, so be patient it might take w while


## URL's

API: http://chalhoub.api.lo

## TESTS

Tests are using guzzle and phpunit, they are outside of the project

cd /tests

composer install

./vendor/bin/phpunit
