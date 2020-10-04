# PHP ClientIP - v0.1.0

Client IP detector and various IP validators

## Initialization

```php
$client = new DimChtz\ClientIP\ClientIP();
```

You can also add additional IP services (for the external IP detection functionality):

```php
$client = new DimChtz\ClientIP\ClientIP(array(
	'http://v4.ident.me/',
	'http://checkip.amazonaws.com/',
    'http://ipecho.net/plain',
));
```

## Usage & Examples

#### Getting client's IP (without localhost check)

```php
$client = new DimChtz\ClientIP\ClientIP();

echo 'Visitor\'s IP: ' . $client->get_ip(false);
```

#### Getting client's IP (with localhost check)

By default `get_ip()` will return the external IP if the user is on localhost.

```php
$client = new DimChtz\ClientIP\ClientIP();

echo 'Visitor\'s IP: ' . $client->get_ip();
```

#### Getting client's external IP

```php
$client = new DimChtz\ClientIP\ClientIP();

echo 'Visitor\'s external IP: ' . $client->get_external_ip();
```

#### Check if the visitor's IP is localhost

```php
$client = new DimChtz\ClientIP\ClientIP();

echo $client->is_localhost() ? 'It is localhost' : 'It is not localhost';
```