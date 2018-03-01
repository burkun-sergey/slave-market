<?php

namespace SlaveMarket\Lease;

/**
 * Запрос на аренду раба
 *
 * @package SlaveMarket\Lease
 */
class LeaseRequest
{
    /** @var int id хозяина */
    public $masterId;

    /** @var int id раба */
    public $slaveId;

    /** @var string время начала работ Y-m-d H:i:s */
    protected $timeFrom;

    /** @var string время окончания работ Y-m-d H:i:s */
    protected $timeTo;
	
	public function __construct(string $dtFrom, string $dtTo) {
		if (strcasecmp($dtFrom, $dtTo)>0) {
			die("Неверный порядок дат!");
		} 
		$this->timeFrom = $dtFrom;
		$this->timeTo = $dtTo;
	}
	
	public function getTimeFrom(): string {
		return $this->timeFrom;
	}
	
	public function getTimeTo(): string {
		return $this->timeTo;
	}
}