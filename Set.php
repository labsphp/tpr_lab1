<?php

/**
 * Created by PhpStorm.
 * User: Serhii
 * Date: 28.02.2018
 * Time: 18:58
 */
class Set
{
    private $set = [];

    function __construct(array $x)
    {
        $i = 1;
        foreach ($x as $value) {
            $pattern = '#(?<first>\d)(?<second>\d)#';
            preg_match($pattern, $value, $matches);
            $q1 = $matches['first'];
            $q2 = $matches['second'];
            $this->set["a{$i}"] = new Alternative($q1, $q2);
            $i++;
        }
    }

    public function getSet():array
    {
        return $this->set;
    }

    public function pareto():void
    {
        $i = 1;
        $j = 2;
        $count = count($this->set);

        while (true) {
            //Проверка, что заходим в элемент, который paretoOptimal = true , иначе переходим на след итерацию
            //(так как этот элемент не входит в множество Парето)
            if ($this->set["a{$i}"]->getParetoOptimal() == false) {
                if ($i < $count - 1) {
                    $i++;
                    $j = $i + 1;
                    continue;
                } else {
                    break;
                }
            }
            if ($this->set["a{$j}"]->getParetoOptimal() == false) {
                if ($j < $count) {
                    $j++;
                    continue;
                } else {
                    if ($i < $count - 1) {
                        $i++;
                        $j = $i + 1;
                    } else {
                        break;
                    }
                }
            }
            //Если лучше след альтернативы
            if ($this->set["a{$i}"]->comparePareto($this->set["a{$j}"]) > 0) {
                $this->set["a{$j}"]->setParetoOptimal(false);
                if ($j < $count) {
                    $j++;
                } else {
                    if ($i < $count - 1) {
                        $i++;
                        $j = $i + 1;
                    } else {
                        break;
                    }
                }
                //Если хуже след альтернативы
            } elseif ($this->set["a{$j}"]->comparePareto($this->set["a{$i}"]) > 0) {
                $this->set["a{$i}"]->setParetoOptimal(false);
                if ($i < $count - 1) {
                    $i++;
                    $j = $i + 1;
                } else {
                    break;
                }
                //Есди по одному критерию лучше, а по-другому хуже
            } else {
                if ($j < $count) {
                    $j++;
                } else {
                    if ($i < $count - 1) {
                        $i++;
                        $j = $i + 1;
                    } else {
                        break;
                    }
                }
            }
        }
        return;
    }

    public function slayter():void
    {
        $i = 1;
        $j = 2;
        $count = count($this->set);

        while (true) {
            //Проверка, что заходим в элемент, который slayterOptimal=true, иначе переходим на след итерацию
            if ($this->set["a{$i}"]->getSlayterOptimal() == false) {
                if ($i < $count - 1) {
                    $i++;
                    $j = $i + 1;
                    continue;
                } else {
                    break;
                }
            }
            if ($this->set["a{$j}"]->getSlayterOptimal() == false) {
                if ($j < $count) {
                    $j++;
                    continue;
                } else {
                    if ($i < $count - 1) {
                        $i++;
                        $j = $i + 1;
                    } else {
                        break;
                    }
                }
            }

            //Если лучше след альтернативы
            if ($this->set["a{$i}"]->compareSlayter($this->set["a{$j}"]) > 0) {
                //Удаляем с множества Слейтера
                $this->set["a{$j}"]->setSlayterOptimal(false);
                if ($j < $count) {
                    $j++;
                } else {
                    if ($i < $count - 1) {
                        $i++;
                        $j = $i + 1;
                    } else {
                        break;
                    }
                }
                //Если хуже след альтернативы
            } elseif ($this->set["a{$j}"]->compareSlayter($this->set["a{$i}"]) > 0) {
                $this->set["a{$i}"]->setSlayterOptimal(false);
                if ($i < $count - 1) {
                    $i++;
                    $j = $i + 1;
                } else {
                    break;
                }
                //Есди по одному критерию лучше, а по-другому хуже
            } else {
                if ($j < $count) {
                    $j++;
                } else {
                    if ($i < $count - 1) {
                        $i++;
                        $j = $i + 1;
                    } else {
                        break;
                    }
                }
            }
        }
        return;
    }
}