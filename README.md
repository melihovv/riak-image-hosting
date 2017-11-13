# Laravel app for hosting images in riak

![screenshot from 2017-11-11 23-20-51](https://user-images.githubusercontent.com/8608721/32693180-6c095976-c737-11e7-9068-64ab8e4d7b23.png)

## Installation

- git clone https://github.com/melihovv/riak-image-hosting
- cd riak-image-hosting
- composer install
- yarn
- npm run prod
- install docker and docker-compose
- cd riak
- docker-compose up -d coordinator
- docker-compose scale member=2
- docker-compose ps
- specify riak nodes ports in .env file (you can see them in `docker-compose ps` output)
```
RIAK_COORDINATOR_PORT=8098
# Your ports may differ
RIAK_NODE1_PORT=32768
RIAK_NODE2_PORT=32770
```
- php artisan server
- go to [http://localhost:8000](http://localhost:8000)
