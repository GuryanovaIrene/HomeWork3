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
    $i = 0;
    $address = $xml->Address[$i];
    while (isset($address)) {
        echo '<b>' . $address->attributes()->Type->__toString() . ' address:</b>' . PHP_EOL;
        $j = 0;
        $addrChars = $address->children();
        foreach ($addrChars as $key => $value) {
            if ($j > 0) {
                echo $key . ': ' . $value . PHP_EOL;
            }
            $j++;
        }
        echo PHP_EOL;
        $i++;
        $address = $xml->Address[$i];
    }

    // Примечания к поставке
    $deliveryNotes = $xml->DeliveryNotes->__toString();
    echo 'Delivery Notes: ' . $deliveryNotes . PHP_EOL . PHP_EOL;

    $items = $xml->Items;
    $i = 0;
    $item = $items->Item[$i];
    while (isset($item)) {
        echo '<b>PartNumber ' . $item->attributes()->PartNumber->__toString() . '</b>' . PHP_EOL;
        $itemChars = $item->children();
        $j = 0;
        foreach ($itemChars as $key=>$value) {
            if ($j > 0) {
                echo $key . ': ' . $value . PHP_EOL;
            }
            $j++;
        }
        echo PHP_EOL;
        $i++;
        $item = $items->Item[$i];
    }
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

        $arr2['Mouse']['Type']['DEXP WM-903BU black']['Illumination'] = 'Yes';

        $arr2['Monitor'] = 'LG';
    }
    file_put_contents('output2.json', json_encode($arr2));

    $js = file_get_contents('output.json');
    $js2 = file_get_contents('output2.json');

    $arrGet = json_decode($js, true);
    $arrGet2 = json_decode($js2, true);


}

function task3($n) {
    if ($n >= 50) {
        $arr = array();
        for ($i = 1; $i <= $n; $i++) {
            array_push($arr, rand(1, 100));
        }
        if ($fp = fopen('numbers.csv', 'w')) {
            fputcsv($fp, $arr, ';');
            fclose($fp);
            $sum = 0;
            if ($fp = fopen('numbers.csv', 'r')) {
                while ($csvData = fgetcsv($fp, 100, ';')) {
                    foreach ($csvData as $num) {
                        $num = number_format($num);
                        if ($num % 2 == 0) {
                            $sum += $num;
                        }
                    }
                }
                return $sum;
            } else {
                return 'Невозможно считать csv-файл!';
            }
        } else {
            return 'Невозможно записать в csv-файл!';
        }
    } else {
        return 'Введите число не менее 50!!!';
    }
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
