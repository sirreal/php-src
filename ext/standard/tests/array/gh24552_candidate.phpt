--TEST--
GH-24552 candidate (ksort() and krsort() with SORT_FLAG_CASE are locale-dependent)
--SKIPIF--
<?php
if (setlocale(LC_CTYPE, 'tr_TR.UTF-8') === false) {
    die('skip tr_TR.UTF-8 locale not available');
}
?>
--FILE--
<?php
setlocale(LC_CTYPE, 'tr_TR.UTF-8');

$array = ['I' => 0, 'h' => 0, "\xC4" => 0, "\xE0" => 0];
ksort($array, SORT_STRING | SORT_FLAG_CASE);
echo implode(' ', array_map(bin2hex(...), array_keys($array))), "\n";
krsort($array, SORT_STRING | SORT_FLAG_CASE);
echo implode(' ', array_map(bin2hex(...), array_keys($array))), "\n";
?>
--EXPECT--
68 49 c4 e0
e0 c4 49 68
