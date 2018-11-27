<?php
function task1($fileName) {
    $file = file_get_contents($fileName);
    $xml = new SimpleXMLElement($file);
    // Вывод заголовков - Номер заказа и Дата заказа
    $purchaseOrderNumber = $xml->attributes()->PurchaseOrderNumber->__toString();
    $orderDate = $xml->attributes()->OrderDate->__toString();
    echo 'PurchaseOrderNumber: ' . $purchaseOrderNumber . PHP_EOL;
    echo 'OrderDate = ' . $orderDate . PHP_EOL . PHP_EOL;

    // Вывод адресов
    foreach ($xml->Address as $address) {
        echo '<b>' . $address->attributes()->Type->__toString() . ' address:</b>' . PHP_EOL;
        $addrChars = $address->children();
        foreach ($addrChars as $key => $value) {
            echo $key . ': ' . $value . PHP_EOL;
        }
        echo PHP_EOL;
    }

    // Примечания к поставке
    $deliveryNotes = $xml->DeliveryNotes->__toString();
    echo 'Delivery Notes: ' . $deliveryNotes . PHP_EOL . PHP_EOL;
    $items = $xml->Items;
    foreach ($items->Item as $item) {
        echo '<b>PartNumber ' . $item->attributes()->PartNumber->__toString() . '</b>' . PHP_EOL;
        $itemChars = $item->children();
        foreach ($itemChars as $key=>$value) {
            echo $key . ': ' . $value . PHP_EOL;
        }
        echo PHP_EOL;
    }
}

function compair_arrays($arr1, $arr2, $diff = []) {

    foreach ($arr1 as $key=>$value) {
        if (isset($arr2[$key])) {  // Проверка существования ключа во втором массиве
            $arr1Type = gettype($arr1[$key]);
            $arr2Type = gettype($arr2[$key]);
            if ($arr1Type == "array" and $arr2Type == "array") { // Если оба элемента массивы, то сравниваем их
                $diff = compair_arrays($arr1[$key], $arr2[$key], $diff);
            } elseif (($arr1Type == "array" and $arr2Type != "array")
                or ($arr1Type != "array" and $arr2Type == "array")) { // Если один массив а другой не массив, тогда записываем в разницу
                $diff[] = [$arr1[$key], $arr2[$key]];
                return $diff;
            } elseif ($arr1[$key] !== $arr2[$key]) { // Оба элемента массива - числа. Сравниваем
                //  Сравниваем по строгому соответствию, чтобы не срабатывало приведения типов
                $diff[] = [$key, $arr1[$key], $arr2[$key]];
            }
        } else { // Если такого ключа во втором массиве нет, то записываем данный элемент в разницу
            $diff[] = [$key, $arr1[$key], ""];
        }
    }

    // Пробегаемся по второму массиву и ищем ключи 2-го массива, которые не существуют в первом
    foreach ($arr2 as $key=>$value) {
        if (!isset($arr1[$key])) {
            $diff[] = [$key, "", $arr2[$key]];
        }
    }
    return $diff;
}

function task2($arr) {
    file_put_contents('output.json', json_encode($arr));
    $js = file_get_contents('output.json');
    $arr2 = json_decode($js, true);
    if (rand(0, 1)) {
        $arr2['Keyboard']['Oklick 920G'] = array(
            'Connector' => 'USB',
            'Keyboard Type' => 'Mechanical',
            'Key illumination' => 'Yes',
            'Silent keys' => 'No',
            'Digital block' => 'Yes',
            'Connection type' => 'Wired'
        );
        $arr2['Mouse']['DEXP WM-903BU black']['Illumination'] = 'Yes';
        $arr2['Monitor'] = 'LG';
    }
    file_put_contents('output2.json', json_encode($arr2));
    $js = file_get_contents('output.json');
    $js2 = file_get_contents('output2.json');
    $arrGet = json_decode($js, true);
    $arrGet2 = json_decode($js2, true);

    $diff = compair_arrays($arrGet, $arrGet2);
    echo 'Разница между массивами:<br/>';
    print_r($diff);
}

function task3($n) {
    $arr = array();
    for ($i = 1; $i <= $n; $i++) {
        array_push($arr, rand(1, 100));
    }
    $fp = fopen('numbers.csv', 'w');
    if (!$fp) {
        return 'Невозможно записать в csv-файл!';
    }
    fputcsv($fp, $arr, ';');
    fclose($fp);
    $fp = fopen('numbers.csv', 'r');
    if (!$fp) {
        return 'Невозможно считать csv-файл!';
    }
    $sum = 0;

    foreach (fgetcsv($fp, 100, ';') as $num) {
        if ($num % 2 == 0) {
            $sum += $num;
        }
    }
    return $sum;
}

function searchByKey($arr, $keyName) {  // Поиск в многомерном массиве значения ключа
    foreach ($arr as $key=>$value) {
        if ($key == $keyName) {
            if (gettype($value) != "array") {
                echo $keyName . ' = ' . $value . PHP_EOL;
            }
        }
        if (gettype($arr[$key]) == "array") {
            searchByKey($arr[$key], $keyName);
        }
    }
}

function task4($url) {
    $result = file_get_contents($url);
    $json = json_decode($result, true);

    searchByKey($json, 'title');
    searchByKey($json, 'pageid');
    /*
    $title = strstr($result, '"title":');
    $title = substr($title,1, strpos($title, ',') - 2);
    $title = str_replace('":"', '=', $title);
    $pageId = strstr($result, '"pageid":');
    $pageId = substr($pageId,1, strpos($pageId, ',') - 2);
    $pageId = str_replace('":', '=', $pageId);
    echo 'title = ' . $title . PHP_EOL . 'pageId = ' . $pageId;*/
}

function zodiac($dt) {
    $zodiacSign = [
        'Овен' => ['21.03', '20.04'],
        'Телец' => ['21.04', '20.05'],
        'Близнецы' => ['21.05', '21.06'],
        'Рак' => ['22.06', '22.07'],
        'Лев' => ['23.07', '23.08'],
        'Дева' => ['24.08', '23.09'],
        'Весы' => ['24.09', '23.10'],
        'Скорпион' => ['24.10', '22.11'],
        'Стрелец' => ['23.11', '21.12'],
        'Козерог' => ['22.12', '20.01'],
        'Водолей' => ['21.01', '20.02'],
        'Рыбы' => ['21.02', '20.03']
    ];

    $dtWoYear = date('d.m', strtotime($dt));

    foreach ($zodiacSign as $key=>$sign) {
        if (substr($sign[0], 3) == substr($dtWoYear, 3) and substr($sign[0], 0, 2) <= substr($dtWoYear, 0, 2)) {
            return $key;
        }
        if (substr($sign[1], 3) == substr($dtWoYear, 3) and substr($sign[1], 0, 2) >= substr($dtWoYear, 0, 2)) {
            return $key;
        }
    }
}