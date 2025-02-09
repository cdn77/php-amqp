--TEST--
AMQPChannel slots usage
--SKIPIF--
<?php
if (!extension_loaded("amqp")) print "skip";
if (!getenv("PHP_AMQP_HOST")) print "skip";
?>
--FILE--
<?php
$cnn = new AMQPConnection();
$cnn->setHost(getenv('PHP_AMQP_HOST'));
$cnn->connect();

echo 'Used channels: ', $cnn->getUsedChannels(), PHP_EOL;

$ch = new AMQPChannel($cnn);
echo 'Used channels: ', $cnn->getUsedChannels(), PHP_EOL;

$ch = new AMQPChannel($cnn);
echo 'Used channels: ', $cnn->getUsedChannels(), PHP_EOL;

$ch = null;
echo 'Used channels: ', $cnn->getUsedChannels(), PHP_EOL;
?>
--EXPECT--
Used channels: 0
Used channels: 1
Used channels: 1
Used channels: 0
