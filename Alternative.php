<?php

/**
 * Created by PhpStorm.
 * User: Serhii
 * Date: 27.02.2018
 * Time: 21:32
 */
class Alternative
{
    private $q1;
    private $q2;
    private $paretoOptimal;
    private $slayterOptimal;

    function __construct(int $q1, int $q2)
    {
        $this->q1 = $q1;
        $this->q2 = $q2;
        //По умолчанию все паретооптимальные и оптимальные по Слейтеру
        $this->paretoOptimal = true;
        $this->slayterOptimal = true;

    }

    /**
     * @return int
     */
    public function getQ1(): int
    {
        return $this->q1;
    }

    /**
     * @return int
     */
    public function getQ2(): int
    {
        return $this->q2;
    }

    /**
     * @param boolean $paretoOptimal
     */
    public function setParetoOptimal(bool $paretoOptimal)
    {
        $this->paretoOptimal = $paretoOptimal;
    }

    /**
     * @return bool
     */
    public function getParetoOptimal():bool
    {
        return $this->paretoOptimal;
    }

    /**
     * @param boolean $slayterOptimal
     */
    public function setSlayterOptimal(bool $slayterOptimal)
    {
        $this->slayterOptimal = $slayterOptimal;
    }

    /**
     * @return bool
     */
    public function getSlayterOptimal():bool
    {
        return $this->slayterOptimal;
    }

    public function comparePareto(Alternative $x):int
    {
        return (($this->q1 >= $x->q1) && ($this->q2 >= $x->q2)) ? 1 : -1;
    }

    public function compareSlayter(Alternative $x):int
    {
        return (($this->q1 > $x->q1) && ($this->q2 > $x->q2)) ? 1 : -1;
    }
}