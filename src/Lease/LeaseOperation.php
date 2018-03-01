<?php

namespace SlaveMarket\Lease;

use SlaveMarket\MastersRepository;
use SlaveMarket\SlavesRepository;
use DateTime;

/**
 * Операция "Арендовать раба"
 *
 * @package SlaveMarket\Lease
 */
class LeaseOperation
{
    /**
     * @var LeaseContractsRepository
     */
    protected $contractsRepository;
	
	const SLAVE_MAX_HOURS_PER_DAY = 16;

    /**
     * @var MastersRepository
     */
    protected $mastersRepository;

    /**
     * @var SlavesRepository
     */
    protected $slavesRepository;

    /**
     * LeaseOperation constructor.
     *
     * @param LeaseContractsRepository $contractsRepo
     * @param MastersRepository $mastersRepo
     * @param SlavesRepository $slavesRepo
     */
    public function __construct(LeaseContractsRepository $contractsRepo, MastersRepository $mastersRepo, SlavesRepository $slavesRepo)
    {
        $this->contractsRepository = $contractsRepo;
        $this->mastersRepository   = $mastersRepo;
        $this->slavesRepository    = $slavesRepo;
    }
	
	/**
     * считаем занятость раба в часах с учетом всех ограничений в выбранном интервале дат
     *
     * @param string $dtFrom
	 * @param string $dtTo     
	 * @return int
     */
	private function getFullHours(string $dtFrom, string $dtTo): int {
		$fr = DateTime::createFromFormat('Y-m-d H:i', $dtFrom);
		$to = DateTime::createFromFormat('Y-m-d H:i', $dtTo);
		
		$fr->sub(new DateInterval('PT'.$fr->format("i").'M'));
		if ($this->getIntFromStr($to->format("i"))>0) {
			$to->add(new DateInterval('PT'.(60 - $this->getIntFromStr($to->format("i"))).'M'));
		}
		
		$df = $fr->diff($to);
		
		$res = ($df->days * SLAVE_MAX_HOURS_PER_DAY) + $df->h;
		
		return $res;
	}
	
	/**
     * Перевод строки в int (с учетом ведущих нулей)
     *
     * @param string $str	 
	 * @return int
     */
	private function getIntFromStr(string $str): int {
		return intval(ltrim($str, "0"));
	}

    /**
     * Выполнить операцию
     *
     * @param LeaseRequest $request
     * @return LeaseResponse
     */
    public function run(LeaseRequest $request): LeaseResponse
    {
		$resp = new LeaseResponse;
		
		$slaveIntersectContracts = $this->contractsRepository->getForSlave($request->slaveId, $request->getTimeFrom(), $request->getTimeTo());
		
		$master = $this->mastersRepository->getById($request->masterId);
		$slave = $this->slavesRepository->getById($request->slaveId);
		
		if ( (count($slaveIntersectContracts)<=0) || ($master->isVIP()) ) {
			// рассчитаем стоимость
			$hours = $this->getFullHours($request->getTimeFrom(), $request->getTimeTo());
			$price = $hours * $slave->pricePerHour;
			$leasedHours["dtFrom"] = $request->getTimeFrom();
			$leasedHours["dtTo"] = $request->getTimeTo();
			
			$leaseContract = new LeaseContract($master, $slave, $price, $leasedHours);
			$resp->setLeaseContract($leaseContract);
			
		} else {
			// добавим в ответ сообщение о невозможности
			foreach($slaveIntersectContracts as $contract) {
				$resp->addError("Раб занят на другом контракте с ".$contract->leasedHours["dtFrom"]." по ".$contract->leasedHours["dtTo"]);
			}
		}
		
		return $resp;
    }
}