# MailerLite

A PHP package for working w/ the MailerLite API.

## Install

Normal install via Composer.

## Usage

```php
use Travis\MailerLite;

$apikey = 'YOURAPIKEY';
$listid = 'YOURLISTID';

try
{
	$test = MailerLite::run($apikey, 'post', 'groups/'.$listid.'/subscribers', [
		'name' => 'Paul Tarsus',
		'email' => 'paul@tarsus.net',
	]);
}
catch (\Exception $e)
{
	xx($e->getMessage());
}
```

See the [API Guide](https://developers.mailerlite.com/docs/getting-started-with-mailerlite-api) for additional methods.