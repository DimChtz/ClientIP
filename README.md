# PHP ClientIP - v0.1.0

Client IP detector and various IP validators

## Installation

```sh
composer require dimchtz/clientip
```

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

#### Check if an IP is valid (both IPv4 & IPv6)

```php
echo DimChtz\ClientIP\ClientIP::is_valid_ip('192.168.56.23') ? 'It is valid IP' : 'It is not valid IP';
```

#### Check if an IP is valid IPv4

```php
echo DimChtz\ClientIP\ClientIP::is_valid_ipv4('192.168.56.23') ? 'It is valid IPv4' : 'It is not valid IPv4';
```

#### Check if an IP is valid IPv6

```php
echo DimChtz\ClientIP\ClientIP::is_valid_ipv6('::1') ? 'It is valid IPv6' : 'It is not valid IPv6';
```