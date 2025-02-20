--TEST--
AMQPQueue::get headers with bool values
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

$ex = new AMQPExchange($ch);
$ex->setName('exchange' . bin2hex(random_bytes(32)));
$ex->setType(AMQP_EX_TYPE_TOPIC);
$ex->declareExchange();
$q = new AMQPQueue($ch);
$q->setName('queue1' . bin2hex(random_bytes(32)));
$q->declareQueue();
$q->bind($ex->getName(), '#');


// publish a message:
$ex->publish(
    'body', 'routing.1', AMQP_NOPARAM, array(
        'headers' => array(
            'foo' => 'bar',
            'true' => true,
            'false' => false,
        )
    )
);

// Read from the queue
$msg = $q->get(AMQP_AUTOACK);

var_dump($msg->getHeaders());
echo $msg->getHeader('foo') . "\n";
var_dump($msg->hasHeader('true'), $msg->getHeader('true'));
var_dump($msg->hasHeader('false'), $msg->getHeader('false'));

$ex->delete();
$q->delete();
?>
--EXPECT--
array(3) {
  ["foo"]=>
  string(3) "bar"
  ["true"]=>
  bool(true)
  ["false"]=>
  bool(false)
}
bar
bool(true)
bool(true)
bool(true)
bool(false)
