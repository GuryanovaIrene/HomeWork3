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
function compair_arrays($arr1, $arr2, $diff, $index) {
    echo 1;
    foreach ($arr1 as $key=>$value) {
        if (isset($arr2[$key])) {  // Проверка существования ключа во втором массиве
            $arr1Type = gettype($arr1[$key]);
            $arr2Type = gettype($arr2[$key]);
            if ($arr1Type == "array" and $arr2Type == "array") { // Если оба элемента массивы, то сравниваем их
                $diff = compair_arrays($arr1[$key], $arr2[$key], $diff, '');
                return $diff;
            } elseif (($arr1Type == "array" and $arr2Type != "array")
                or ($arr1Type != "array" and $arr2Type == "array")) { // Если один массив а другой не массив, тогда записываем в разницу
                return $diff;
            } elseif ($arr1[$key] === $arr2[$key]) { // Оба элемента массива - числа. Сравниваем
                //  Сравниваем по строгому соответствию, чтобы не срабатывало приведения типов
                unset($diff[$index]); //Здесь необходимо уничтожить часть массива $diff по ключу
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
        $num = $csvData[0];
        if ((int)$num % 2 == 0) {
            $sum += $num;
        }
    }
    return $sum;
}

function searchByKey($arr, $keyName) {  // Поиск в многомерном массиве значения ключа
    foreach ($arr as $key=>$value) {
        if ($key == $keyName) {
            return $value;
        }
        searchByKey($arr[$key], $keyName);
    }
}

function task4($url) {
    $result = file_get_contents($url);
//    $result = '{\"batchcomplete\":\"\",\"warnings\":{\"main\":{\"*\":\"Subscribe to the mediawiki-api-announce mailing list at <https://lists.wikimedia.org/mailman/listinfo/mediawiki-api-announce> for notice of API deprecations and breaking changes. Use [[Special:ApiFeatureUsage]] to see usage of deprecated features by your application.\"},\"revisions\":{\"*\":\"Because \\"rvslots\\" was not specified, a legacy format has been used for the output. This format is deprecated, and in the future the new format will always be used.\"}},\"query\":{\"pages\":{\"15580374\":{\"pageid\":15580374,\"ns\":0,\"title\":\"Main Page\",\"revisions\":[{\"contentformat\":\"text/x-wiki\",\"contentmodel\":\"wikitext\",\"*\":\"<!--        BANNER ACROSS TOP OF PAGE         -->\n<div id=\\"mp - topbanner\\" style=\\"clear:both; position:relative; box - sizing:border - box; width:100 %; margin:1.2em 0 6px; min - width:47em; border:1px solid #ddd; background-color:#f9f9f9; color:#000; white-space:nowrap;\\">\n<!--        \\"WELCOME TO WIKIPEDIA\\" AND ARTICLE COUNT        -->\n<div style=\\"margin:0.4em; width:22em; text-align:center;\\">\n<div style=\\"font-size:162%; padding:.1em;\\">Welcome to [[Wikipedia]],</div>\n<div style=\\"font-size:95%;\\">the [[free content|free]] [[encyclopedia]] that [[Wikipedia:Introduction|anyone can edit]].</div>\n<div id=\\"articlecount\\" style=\\"font-size:85%;\\">[[Special:Statistics|{{NUMBEROFARTICLES}}]] articles in [[English language|English]]</div>\n</div>\n<!--        PORTAL LIST ON RIGHT-HAND SIDE        -->\n<ul style=\\"position:absolute; right:-1em; top:50%; margin-top:-2.4em; width:38%; min-width:25em; font-size:95%;\\">\n<li style=\\"position:absolute; left:0; top:0;\\">[[Portal:Arts|Arts]]</li>\n<li style=\\"position:absolute; left:0; top:1.6em;\\">[[Portal:Biography|Biography]]</li>\n<li style=\\"position:absolute; left:0; top:3.2em;\\">[[Portal:Geography|Geography]]</li>\n<li style=\\"position:absolute; left:33%; top:0;\\">[[Portal:History|History]]</li>\n<li style=\\"position:absolute; left:33%; top:1.6em;\\">[[Portal:Mathematics|Mathematics]]</li>\n<li style=\\"position:absolute; left:33%; top:3.2em;\\">[[Portal:Science|Science]]</li>\n<li style=\\"position:absolute; left:66%; top:0;\\">[[Portal:Society|Society]]</li>\n<li style=\\"position:absolute; left:66%; top:1.6em;\\">[[Portal:Technology|Technology]]</li>\n<li style=\\"position:absolute; left:66%; top:3.2em;\\"><strong>[[Portal:Contents/Portals|All portals]]</strong></li>\n</ul>\n</div>\n<!--        MAIN PAGE BANNER        -->\n{{#if:{{Main Page banner}}|\n<div id=\\"mp-banner\\" class=\\"MainPageBG\\" style=\\"margin-top:4px; padding:0.5em; background-color:#fffaf5; border:1px solid #f2e0ce;\\">\n{{Main Page banner}}\n</div>\n}}\n<!--        TODAY'S FEATURED CONTENT        -->\n{| role=\\"presentation\\" id=\\"mp-upper\\" style=\\"width: 100%; margin-top:4px; border-spacing: 0px;\\"\n<!--        TODAY'S FEATURED ARTICLE; DID YOU KNOW        -->\n| id=\\"mp-left\\" class=\\"MainPageBG\\" style=\\"width:55%; border:1px solid #cef2e0; padding:0; background:#f5fffa; vertical-align:top; color:#000;\\" |\n<h2 id=\\"mp-tfa-h2\\" style=\\"margin:0.5em; background:#cef2e0; font-family:inherit; font-size:120%; font-weight:bold; border:1px solid #a3bfb1; color:#000; padding:0.2em 0.4em;\\">{{#ifexpr:{{formatnum:{{PAGESIZE:Wikipedia:Today's featured article/{{#time:F j, Y}}}}|R}}>150|From today's featured article|Featured article <span style=\\"font-size:85%; font-weight:normal;\\">(Check back later for today's.)</span>}}</h2>\n<div id=\\"mp-tfa\\" style=\\"padding:0.1em 0.6em;\\">{{#ifexpr:{{formatnum:{{PAGESIZE:Wikipedia:Today's featured article/{{#time:F j, Y}}}}|R}}>150|{{Wikipedia:Today's featured article/{{#time:F j, Y}}}}|{{Wikipedia:Today's featured article/{{#time:F j, Y|-1 day}}}}}}</div>\n<h2 id=\\"mp-dyk-h2\\" style=\\"clear:both; margin:0.5em; background:#cef2e0; font-family:inherit; font-size:120%; font-weight:bold; border:1px solid #a3bfb1; color:#000; padding:0.2em 0.4em;\\">Did you know...</h2>\n<div id=\\"mp-dyk\\" style=\\"padding:0.1em 0.6em 0.5em;\\">{{Did you know}}</div>\n| style=\\"border:1px solid transparent;\\" |\n<!--        IN THE NEWS and ON THIS DAY        -->\n| id=\\"mp-right\\" class=\\"MainPageBG\\" style=\\"width:45%; border:1px solid #cedff2; padding:0; background:#f5faff; vertical-align:top;\\"|\n<h2 id=\\"mp-itn-h2\\" style=\\"margin:0.5em; background:#cedff2; font-family:inherit; font-size:120%; font-weight:bold; border:1px solid #a3b0bf; color:#000; padding:0.2em 0.4em;\\">In the news</h2>\n<div id=\\"mp-itn\\" style=\\"padding:0.1em 0.6em;\\">{{In the news}}</div>\n<h2 id=\\"mp-otd-h2\\" style=\\"clear:both; margin:0.5em; background:#cedff2; font-family:inherit; font-size:120%; font-weight:bold; border:1px solid #a3b0bf; color:#000; padding:0.2em 0.4em;\\">On this day</h2>\n<div id=\\"mp-otd\\" style=\\"padding:0.1em 0.6em 0.5em;\\">{{Wikipedia:Selected anniversaries/{{#time:F j}}}}</div>\n|}\n<!--        TODAY'S FEATURED LIST        --><!-- CONDITIONAL SHOW -->{{#switch:{{CURRENTDAYNAME}}|Monday|Friday=\n<div id=\\"mp-middle\\" class=\\"MainPageBG\\" style=\\"margin-top:4px; border:1px solid #f2cedd; background:#fff5fa; overflow:auto;\\">\n<div id=\\"mp-center\\">\n<h2 id=\\"mp-tfl-h2\\" style=\\"margin:0.5em; background:#f2cedd; font-family:inherit; font-size:120%; font-weight:bold; border:1px solid #bfa3af; color:#000; padding:0.2em 0.4em\\">From today's featured list</h2>\n<div id=\\"mp-tfl\\" style=\\"padding:0.3em 0.7em;\\">{{#ifexist:Wikipedia:Today's featured list/{{#time:F j, Y}}|{{Wikipedia:Today's featured list/{{#time:F j, Y}}}}|{{TFLempty}}}}</div>\n</div>\n</div>|}}<!-- END CONDITIONAL SHOW -->\n<!--        TODAY'S FEATURED PICTURE        -->\n<div id=\\"mp-lower\\" class=\\"MainPageBG\\" style=\\"margin-top:4px; border:1px solid #ddcef2; background:#faf5ff; overflow:auto;\\">\n<div id=\\"mp-bottom\\">\n<h2 id=\\"mp-tfp-h2\\" style=\\"margin:0.5em; background:#ddcef2; font-family:inherit; font-size:120%; font-weight:bold; border:1px solid #afa3bf; color:#000; padding:0.2em 0.4em\\">{{#ifexist:Template:POTD protected/{{#time:Y-m-d}}|Today's featured picture | Featured picture&ensp;<span style=\\"font-size:85%; font-weight:normal;\\">(Check back later for today's.)</span>}}</h2>\n<div id=\\"mp-tfp\\" style=\\"margin:0.1em 0.4em 0.6em;\\">{{#ifexist:Template:POTD protected/{{#time:Y-m-d}}|{{POTD protected/{{#time:Y-m-d}}}}|{{POTD protected/{{#time:Y-m-d|-1 day}}}}}}</div>\n</div>\n</div>\n<!--        SECTIONS AT BOTTOM OF PAGE        -->\n<div id=\\"mp-other-lower\\" style=\\"padding-top:4px; padding-bottom:2px; border:1px solid #e2e2e2; overflow:auto; margin-top:4px;\\">\n<h2 id=\\"mp-other\\" style=\\"margin:0.5em; background:#eeeeee; border:1px solid #ddd; color:#222; padding:0.2em 0.4em; font-size:120%; font-weight:bold; font-family:inherit;\\">Other areas of Wikipedia</h2>\n<div id=\\"mp-other-content\\" style=\\"padding:0.1em 0.6em;\\">{{Other areas of Wikipedia}}</div>\n<h2 id=\\"mp-sister\\" style=\\"margin:0.5em; background:#eeeeee; border:1px solid #ddd; color:#222; padding:0.2em 0.4em; font-size:120%; font-weight:bold; font-family:inherit;\\">Wikipedia's sister projects</h2>\n<div id=\\"mp-sister-content\\" style=\\"padding:0.1em 0.6em;\\">{{Wikipedia's sister projects}}</div>\n<h2 id=\\"mp-lang\\" style=\\"margin:0.5em; background:#efefef; border:1px solid #ddd; color:#222; padding:0.2em 0.4em; font-size:120%; font-weight:bold; font-family:inherit;\\">Wikipedia languages</h2>\n<div style=\\"padding:0.1em 0.6em;\\">{{Wikipedia languages}}</div>\n</div>\n<!--        INTERWIKI STRAPLINE        -->\n<noinclude>{{Main Page interwikis}}{{noexternallanglinks}}{{#if:{{Wikipedia:Main_Page/Tomorrow}}||}}</noinclude>__NOTOC____NOEDITSECTION__\"}]}}}}';
    $json = json_decode($result);
    $title = searchByKey($json, 'title');
    $pageId = searchByKey($json, 'pageid');
    /*
    $title = strstr($result, '"title":');
    $title = substr($title,1, strpos($title, ',') - 2);
    $title = str_replace('":"', '=', $title);
    $pageId = strstr($result, '"pageid":');
    $pageId = substr($pageId,1, strpos($pageId, ',') - 2);
    $pageId = str_replace('":"', '=', $pageId);*/
    return $title . PHP_EOL . $pageId;
}
