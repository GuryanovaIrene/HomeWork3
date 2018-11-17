<pre>
<?php
require "src/functions.php";
//task1('data.xml');

$arr = array(
    'Keyboard' => array(
        'Defender OfficeMate SM-820' => array(
            'Connector' => 'USB',
            'Keyboard Type' => 'Membrane',
            'Key illumination' => 'No',
            'Silent keys' => 'Yes',
            'Digital block' => 'Yes',
            'Connection type' => 'Wired'
        ),
        'DEXP KW-3002BU' => array(
            'Connector' => 'USB',
            'Keyboard Type' => 'Membrane',
            'Key illumination' => 'No',
            'Silent keys' => 'Yes',
            'Digital block' => 'Yes',
            'Connection type' => 'Not wired'
        )
    ),
    'Mouse' => array(
        'DEXP CM-407BU black' => array(
            'Main color' => 'Black',
            'Illumination' => 'No',
            'Total number of buttons' => 3,
            'Additional buttons' => 'No',
            'Sensor type' => 'Optical led sensor',
            'Max resolution of the sensor (dpi)' => '800 dpi',
            'Connection type' => 'Wired'
        ),
        'DEXP WM-903BU black' => array(
            'Main color' => 'Black',
            'Illumination' => 'No',
            'Total number of buttons' => 6,
            'Additional buttons' => 'Yes',
            'Sensor type' => 'Optical led sensor',
            'Max resolution of the sensor (dpi)' => '1600 dpi',
            'Connection type' => 'Not wired'
        ),
        'DEXP WM-903BU red' => array(
            'Main color' => 'Red',
            'Illumination' => 'No',
            'Total number of buttons' => 3,
            'Additional buttons' => 'No',
            'Sensor type' => 'Optical led sensor',
            'Max resolution of the sensor (dpi)' => '800 dpi',
            'Connection type' => 'Not wired'
        )
    )
);
task2($arr);

echo task3(60) . PHP_EOL;

echo task4('https://en.wikipedia.org/w/api.php?action=query&titles=Main%20Page&prop=revisions&rvprop=content&format=json');