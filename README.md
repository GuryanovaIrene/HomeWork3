# HomeWork3
Домашнее задание 3.

Функция task1 производит разбор xml и вывод данных в удобном для просмотра виде.

Функция task2 производит запись в файл output.json.
$arr - исходный массив.
$arr2 - копия массива $arr.
Затем используется функция генерации случайных чисел rand(0, 1). 
Если она принимает значение 1, то меняем массив $arr2.

В массив $diff записываем результат выполнения рекурсивной функции compair_arrays, производящей сравнение двух массивов.
Массив $diff содержит те значения, которыми отличаются данные массивы.
Изначально массив $diff пустой.
Структура массива такова.
Каждый элемент массива $diff - это массив, 
0-й элемент которого содержит имя ключа, по которому есть различие,
1-й элемент - значение 1-го массива, которым отличаются массивы, соответствующее данному ключу (или пустое значение, если такого ключа нет), 
2-й элемент - значение 2-го массива, соответствующее данному ключу (или пустое значение, если такого ключа нет).

Функция compair_arrays принимает на вход два сравниваемых массива. Третий параметр при первичном вызове - пустой массив.
Идем по всем элементам массива, который передан в первом параметре, считываем ключ и значение.
Если во втором параметре есть такой же ключ, переходим к сравнению значений.
Если такого ключа по втором параметре нет, добавляем соответствующую тройку в массив $diff, который в третьем параметре:
[$key, $arr1[$key], ''].
Сравнение значений с одинаковыми ключами.
Варианты:

1. Значения в обоих массивах, соответствующие данному ключу - массивы.
В этом случае применяем функцию compair_arrays к массивам $arr1[$key] и $arr2[$key]. Третий параметр - массив $diff.

2. Значение в одном из массивах - массив, а в другом - скаляр. 
В этом случае заносим разницу путем добавления в массив $diff: [$key, $arr1[$key], $arr2[$key]].

3. Значения в обоих массивах - скаляры.
В этом случае сравниваем значения строгим равенством. Если элементы не равны, добавляем в массив $diff
соответствующую тройку [$key, $arr1[$key], $arr2[$key]].

4. После перебора первого массива пробегаемся по второму массиву и ищем ключи 2-го массива, которые не существуют в первом,
добавляем тройки вида: [$key, '', $arr2[$key]].

Функция task3 содержит параметр - количество вводимых символов.
$arr - массив значений. Циклом for добавляем в массив указанное в параметре количество значений.
Открываем файл csv на запись, с помощью функции fputcsv записываем в файл данные массива.
Затем выполняем обратную операцию: открываем csv файл на чтение и с помощью функции fgetcsv получаем массив значений.
Циклом foreach пробегаемся по значениям массива и в случае, если значение четно, суммируем.

Функция task4 содержит параметр $url, который считываем в переменную $result с помощью функции file_get_contents,
затем переменную result преобразуем в json формат и приводим к ассоциативному массиву $json с помощью функции json_decode.
Чтобы получить именно ассоциативный массив, вторым параметров в функции json_decode указываем true.

Затем применяем рекурсивную функцию searchByKey (поиск по ключу в многомерном массиве), первый параметр которой наш массив $json, а второй имя ключа $keyName, значение которого будем искать.
Пробегаемся по всем элементам массива и сравниваем ключ $key и $keyName.
Если нашелся ключ, то производим проверку типа значения. Если это не массив, то выводим значение.
Если тип значения - массив, то применяем функцию к значению-массиву.

Функция zodiac получает на вход дату возвращает строку, в которой содержится название знака зодиака, соответствующее этой дате.

В теле функции вводится массив $zodiacSign, ключами которого названия знаков зодиака, а значениями - массив пары строковых значений, соответствующих числу и месяцу начала и окончания действия знака, указанного в ключе.

В переменную $dtWoYear записываем входящую дату, приведенную к формату День.Месяц.
Затем пробегаемся по массиву $zodiacSign и производим следующие действия.
1. Сравниваем месяц входной даты и месяц даты начала действия знака. Если они совпадают, то сравниваем соответствующие дни.
Оба сравнения производим одним оператором if. 
Если день начала действия знака меньше, либо равен дню, который мы проверяем, то возвращаем ключ - наименование знака зодиака.
Если, посмотрев дату начала, мы так и не вышли из функции, переходим к следующему сравнению.

2. Сравниваем месяц входной даты и месяц даты окончания действия знака. Если они совпадают, то сравниваем соответствующие дни.
Оба сравнения производим также одним оператором if. 
Если день окончания действия знака больше, либо равен дню, который мы проверяем, то возвращаем ключ - наименование знака зодиака.

Данный подход работает, поскольку нет такого знака зодиака, для которого месяц начала и месяц окончания действия совпадал бы.
Если представить, что знак зодиака начинает и заканчивает свое действие в одном и том же месяце, данная функция работать не будет.

Проверка действия данной функции производилась в index.php на массиве дат
['27.05.2018', '24.06.1980', '22.12.2000', '20.08.1978'].
