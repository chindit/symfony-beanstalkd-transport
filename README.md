# Beanstalk transport for Symfony Messenger
symfony/messenger transport for Beanstalk

### Installation
1) Install package
```
composer require chindit/beanstalk-transport
```
2) Add bundle in your `config/bundles.php`
```
Chindit\Bundle\ChinditBeanstalkTransportBundle::class => ['all' => true],
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
