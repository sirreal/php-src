--TEST--
GH-24552 candidate (Case-insensitive substr_compare() is locale-dependent)
--SKIPIF--
<?php
if (setlocale(LC_CTYPE, 'tr_TR.UTF-8') === false) {
    die('skip tr_TR.UTF-8 locale not available');
}
?>
--FILE--
<?php
setlocale(LC_CTYPE, 'tr_TR.UTF-8');
var_dump(substr_compare('I', 'i', 0, 1, true));
var_dump(substr_compare("\xC4", "\xE4", 0, 1, true));
?>
--EXPECT--
int(0)
int(-32)
