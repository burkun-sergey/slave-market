<?php

namespace SlaveMarket;

use DateTime;

/**
 * Раб (Бедняга :-()
 *
 * @package SlaveMarket
 */
class Slave
{
    /** @var int id раба */
    protected $id;

    /** @var string имя раба \ кличка */
    protected $name;

    /** @var float Стоимость раба за час работы */
    protected $pricePerHour;
	
	/** @var string пол раба  */
	protected $gender;
	
	/** @var string вес */
	protected $weight;
	
	/** @var string цвет кожи  */
	protected $skinColor;
	
	/** @var DateTime день рождения раба  */
	protected $bd;
	
	/** @var string где выращен\пойман  */
	protected $grownPlace;
	
	/** @var float стоимость  */
	protected $cost;
	
	/** @var string стоимость  */
	protected $habits;
	
	/**
     * возвращает возраст раба по его дате рождения
     *
	 * @return int
     */	
	public function getAge(): int {
		$currentDate = new DateTime(date('Y-m-d')); 
		return $currentDate->diff(new DateTime($this->bd))->y;
	}
	
	public function setBd(DateTime $bd) {
		$this->bd = $bd;
	}
	
	/**
     * Возвращает дату рождения
     *
     * @return DateTime
     */
	public function getBd(): DateTime {
		return $this->bd;
	}
	
	/**
     * Возвращает пол (male\female\other)
     *
     * @return string
     */
	public function getGender(): string {
		return $this->gender;
	}
	
	/**
     * Устанавливаем пол (male\female\other)
     *
     * @param string $gender
     */
	public function setGender(string $gender) {
		$this->gender = $gender;
	}
	
	/**
     * Возвращает вес
     *
     * @return int
     */
	public function getWeight(): int {
		return $this->weight;
	}
	
	public function setWeight(int $weight) {
		$this->weight = $weight;
	}
	
	public function setCost(float $cost) {
		$this->cost = $cost;
	}
	
	/**
     * Возвращает стоимость
     *
     * @return float
     */
	public function getCost(): float {
		return $this->cost;
	}	
	
	/**
     * Возвращает цвет кожи
     *
     * @return string
     */
	public function getSkinColor(): string {
		return $this->skinColor;
	}
	
	public function setSkinColor(string $skinColor) {
		$this->skinColor = $skinColor;
	}
	
	/**
     * Возвращает место, где пойман\выращен
     *
     * @return string
     */
	public function getGrownPlace(): string {
		return $this->grownPlace;
	}
	
	public function setGrownPlace(string $grownPlace) {
		$this->grownPlace = $grownPlace;
	}
	
	/**
     * Возвращает привычки
     *
     * @return string
     */
	public function getHabits(): string {
		return $this->habits;
	}
	
	public function setHabits(string $habits) {
		$this->habits = $habits;
	}
	
    /**
     * Slave constructor.
     *
     * @param int $id
     * @param string $name
     * @param float $pricePerHour
     */
    public function __construct(int $id, string $name, float $pricePerHour, string $gender = "male")
    {
        $this->id           = $id;
        $this->name         = $name;
        $this->pricePerHour = $pricePerHour;
    }

    /**
     * Возвращает id раба
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Возвращает имя раба
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Возвращает стоимость раба за час
     *
     * @return float
     */
    public function getPricePerHour(): float
    {
        return $this->pricePerHour;
    }
}