<?php
namespace SlaveMarket\Lease;

$lreq = new LeaseRequest("2009-10-11 12:30:00","2010-10-15 12:00:00");
$lreq->slaveId = 1;
$lreq->masterId = 1000;

$lease = new LeaseOperation(null, null, null);
$resp = $lease->run($lreq);
var_dump($resp);
?>