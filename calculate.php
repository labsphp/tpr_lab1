<?php
/**
 * Created by PhpStorm.
 * User: Serhii
 * Date: 28.02.2018
 * Time: 22:47
 */
include_once 'Alternative.php';
include_once "Set.php";

$type = ($_POST['type'] == 'submitPareto') ? 'pareto' : 'slayter';
$x = $_POST['points'];
$x = preg_split('#\s+#', $x);

$set = new Set($x);

$s = [];
$paretoOptimalPoints = [];
$slayterOptimalPoints = [];
if ($type == 'pareto') {
    $set->pareto();
    /**
     * @param Alternative $alternative
     */
    foreach ($set->getSet() as $alternative) {
        if ($alternative->getParetoOptimal() == true) {
            $paretoOptimalPoints[] = ['x' => $alternative->getQ1(), 'y' => $alternative->getQ2()];
        } else {
            $s[] = [$alternative->getQ1(), $alternative->getQ2()];
        }
    }

    echo json_encode(['set' => $s, 'pareto' => $paretoOptimalPoints]);
} else {
    $set->slayter();
    /**
     * @param Alternative $alternative
     */
    foreach ($set->getSet() as $alternative) {
        if ($alternative->getSlayterOptimal() == true) {
            $slayterOptimalPoints[] = ['x' => $alternative->getQ1(), 'y' => $alternative->getQ2()];
        } else {
            $s[] = [$alternative->getQ1(), $alternative->getQ2()];
        }
    }

    echo json_encode(['set' => $s, 'slayter' => $slayterOptimalPoints]);

}


