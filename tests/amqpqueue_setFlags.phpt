--TEST--
AMQPQueue::setFlags(null)
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

$ch = new AMQPChannel($cnn);

$q = new AMQPQueue($ch);
$q->setFlags(null);
var_dump($q->getFlags())

?>
==DONE==
--EXPECTF--
int(0)
==DONE==
