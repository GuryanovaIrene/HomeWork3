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

