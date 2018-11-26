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
        $j = 0;
        foreach ($itemChars as $key=>$value) {
            echo $key . ': ' . $value . PHP_EOL;
        }
        echo PHP_EOL;
    }
}

function compair_arrays($arr1, $arr2, $diff) {
    echo 1;
    foreach ($arr1 as $key=>$value) {
        if (isset($arr2[$key])) {  // Проверка существования ключа во втором массиве
            $arr1Type = gettype($arr1[$key]);
            $arr2Type = gettype($arr2[$key]);
            if ($arr1Type == "array" and $arr2Type == "array") { // Если оба элемента массивы, то сравниваем их
                $diff = compair_arrays($arr1[$key], $arr2[$key], $diff);
                return $diff;
            } elseif (($arr1Type == "array" and $arr2Type != "array")
                  or ($arr1Type != "array" and $arr2Type == "array")) { // Если один массив а другой не массив, тогда записываем в разницу
                    return $diff;
            } elseif ($arr1[$key] === $arr2[$key]) { // Оба элемента массива - числа. Сравниваем
                //  Сравниваем по строгому соответствию, чтобы не срабатывало приведения типов
                //unset($diff[$key]); Здесь необходимо уничтожить часть массива $diff по ключу
                // Не работает для внутренних частей массива, так как $key - это ключ, к которому нужно прийти сверху массива
                return $diff;
            } else {
                return $diff;
            }
        } else { // Если такого ключа во втором массиве нет, то записываем данный элемент в разницу
            return $diff;
        }
    }
}

function task2($arr) {
    file_put_contents('output.json', json_encode($arr));

    $js = file_get_contents('output.json');
    $arr2 = json_decode($js, true);

 //   if (rand(0, 1)) {
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
 //   }
    file_put_contents('output2.json', json_encode($arr2));

    $js = file_get_contents('output.json');
    $js2 = file_get_contents('output2.json');

    $arrGet = json_decode($js, true);
    $arrGet2 = json_decode($js2, true);

    echo 'arrGet<br/>';
    print_r($arrGet);

    echo 'arrGet2<br/>';
    print_r($arrGet2);

    $diff = compair_arrays($arrGet, $arrGet2, $arrGet);
    echo 'diff:<br/>';
    print_r($diff);

    $diff1 = compair_arrays($arrGet2, $arrGet, $arrGet2);
    echo 'diff1:<br/>';
    print_r($diff1);
}

function task3($n) {
    if ($n < 50) {
        return 'Введите число не менее 50!!!';
    }
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
    while ($csvData = fgetcsv($fp, 100, ';')) {
        foreach ($csvData as $num) {
            //$num = $num + 0;
            if ((int)$num % 2 == 0) {
                $sum += $num;
            }
        }
    }
    return $sum;
}

function task4($url) {
    $result = file_get_contents($url);
    $title = strstr($result, '"title":');
    $title = substr($title,1, strpos($title, ',') - 2);
    $title = str_replace('":"', '=', $title);

    $pageId = strstr($result, '"pageid":');
    $pageId = substr($pageId,1, strpos($pageId, ',') - 2);
    $pageId = str_replace('":"', '=', $pageId);

    return $title . PHP_EOL . $pageId;
}
