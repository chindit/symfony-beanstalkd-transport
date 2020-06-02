# symfony-beanstalkd-transport
symfony/messenger transport for Beanstalkd

### Installation
```
composer require chindit/symfony-beanstalkd-transport
```

### Usage
Just use this DSN in your transport:
```
MESSENGER_TRANSPORT_DSN=beanstalk://127.0.0.1{:port}/{defaultPipe}{?timeout=10}
```

Only `beanstalk://127.0.0.1` is required.  Other parts are optional.
 
You can specify:
 * custom port (default is `11300`)
 * custom tube/queue (default is `default`)
 * custome timeout in seconds (default is `10`)
 
A full DSN should look like this
```
MESSENGER_TRANSPORT_DSN=beanstalk://127.0.0.1:1234/mytube?timeout=12
```
