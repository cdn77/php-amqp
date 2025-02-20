--TEST--
AMQPExchange channel refcount
--SKIPIF--
<?php
if (!extension_loaded("amqp")) print "skip";
if (!getenv("PHP_AMQP_HOST")) print "skip";
?>
--FILE--
<?php
function buildExchange() {
	$cnn = new AMQPConnection();
$cnn->setHost(getenv('PHP_AMQP_HOST'));
	$cnn->connect();

	$ch = new AMQPChannel($cnn);

	$ex = new AMQPExchange($ch);

	$ex->setName("refcount-testing");

	return $ex;
}

$ex = buildExchange();

echo $ex->getName() . "\n";

$ex->setType(AMQP_EX_TYPE_FANOUT);

$ex->declareExchange();

$ex->delete();

?>
--EXPECT--
refcount-testing
