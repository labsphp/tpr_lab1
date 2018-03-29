<?php
/**
 * Created by PhpStorm.
 * User: Serhii
 * Date: 27.12.2017
 * Time: 1:38
 */
declare(strict_types = 1);

error_reporting(E_ALL);
header('Content-type:text/html;charset=utf-8');
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="jquery-3.2.1.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>
    <script src="highcharts.js"></script>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">

    <script>
        $(function () {
            $('#submitPareto').on('click', function () {
                $.ajax({
                    url: 'calculate.php',
                    type: 'post',
                    data: $('form').serialize() + '&type=' + $('#submitPareto').attr("id"),
                    success: function (data) {
                        var data = JSON.parse(data);
                        var set = data['set'];
                        var pareto = data['pareto'];

                        pareto.sort(function (a, b) {
                            //сначала идут элементы с меньшим x и большим y
                            if ((a['x'] <= b['x']) && a['y'] >= b['y']) {
                                return -1;
                            } else {
                                return 1;
                            }
                        });

                        Highcharts.chart('container', {
                            title: {
                                text: 'Оптимальность по Парето',
                                style: {
                                    fontWeight: 'bold'
                                }
                            },
                            yAxis: {
                                tickInterval: 0.5,
                                title: {
                                    text: 'Q2'
                                }
                            },
                            xAxis: {
                                title: {
                                    text: 'Q1',
                                    align: 'high'
                                }
                            },
                            tooltip: {
                                headerFormat: '<i>{series.name}</i><br>',
                                pointFormat: 'q1 = <b>{point.x}</b>;<br> q2 = <b>{point.y}</b>'
                            },
                            credits: {
                                enabled: false
                            },
                            series: [{
                                type: 'scatter',
                                name: 'Не паретооптимальные точки',
                                data: set
                            },
                                {
                                    name: 'Паретооптимальные точки',
                                    data: pareto,
                                    color: '#FF0000',
                                    lineWidth: 1,
                                    marker: {
                                        enabled: true,
                                        lineColor: '#2c9e5f',
                                        fillColor: '#FFFFFF',
                                        lineWidth: 2
                                    }
                                }]
                        });

                    }
                });
            });

            $('#submitSlayter').on('click', function () {
                $.ajax({
                    url: 'calculate.php',
                    type: 'post',
                    data: $('form').serialize() + '&type=' + $('#submitSlayter').attr("id"),
                    success: function (data) {
                        var data = JSON.parse(data);
                        var set = data['set'];
                        var slayter = data['slayter'];

                        slayter.sort(function (a, b) {
                            //сначала идут элементы c меньшим x
                            if ((a['x'] <= b['x']) && a['y'] >= b['y']) {
                                return -1;
                            } else {
                                return 1;
                            }
                        });

                        Highcharts.chart('container', {
                            title: {
                                text: 'Оптимальность по Слейтеру',
                                style: {
                                    fontWeight: 'bold'
                                }
                            },
                            yAxis: {
                                tickInterval: 1,
                                title: {
                                    text: 'Q2'
                                }
                            },
                            xAxis: {
                                title: {
                                    text: 'Q1',
                                    align: 'high'
                                }

                            },
                            tooltip: {
                                headerFormat: '<i>{series.name}</i><br>',
                                pointFormat: 'q1 = <b>{point.x}</b>;<br> q2 = <b>{point.y}</b>'
                            },
                            credits: {
                                enabled: false
                            },
                            series: [{
                                type: 'scatter',
                                name: 'Не оптимальные точки',
                                data: set
                            },
                                {
                                    data: slayter,
                                    name: 'Оптимальные по Слейтеру',
                                    color: '#ff0000',
                                    lineWidth: 1,
                                    marker: {
                                        enabled: true,
                                        lineColor: '#2c9e5f',
                                        fillColor: '#FFFFFF',
                                        lineWidth: 2
                                    }
                                }]
                        });
                    }
                })
                ;
            });
        });

    </script>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12" style="margin-top: 50px">
            <form id="form" action="">
                <div class="form-group">
                    <label for="points">Введите значения: </label>
                    <input type="text" name="points" id='points' value="" style="width: 700px">
                </div>
                <input class="btn btn-primary" type="button" id="submitPareto" name="submitPareto"
                       value="Рассчитать по Парето">
                <input class="btn btn-primary" type="button" id="submitSlayter" name="submitSlayter"
                       value="Рассчитать по Слейтеру">
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div id="result"></div>
            <div id="container" style="height: 700px"></div>
        </div>
    </div>
</div>
</body>
</html>
