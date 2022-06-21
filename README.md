Four docker containers
* reference-design - Application written in PHP / Laravel.
* db - A relational database (MySQL)
* nginx - Front-end is a a web UI using Nginx and vue.js.
* client-helper-application - Provides connection to node. 


### Create public and private keys for signing and verifying

docker run -it --rm -v $(pwd)/keys:/root/keys alpine:3.15 sh -c "
apk add openssl 
openssl genpkey -algorithm ED25519 | tee /root/keys/test.pem
openssl pkey -in /root/keys/test.pem  -pubout | tee /root/keys/85bb2165-90e1-4134-af3e-90a4a0e1e2c1.pem
"