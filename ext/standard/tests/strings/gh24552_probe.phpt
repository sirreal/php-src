--TEST--
GH-24552 probe (always fails; prints this job's locale case folding)
--FILE--
<?php
echo PHP_OS_FAMILY, ' ', PHP_ZTS ? 'ZTS' : 'NTS', "\n";
if (PHP_OS_FAMILY !== 'Windows') {
    $locales = explode("\n", (string) shell_exec('locale -a 2>/dev/null'));
    echo 'locale -a: ', implode(' ', preg_grep('/^(tr_TR|de_DE)/i', $locales)), "\n";
}
foreach (['C', 'tr_TR.UTF-8', 'tr_TR.ISO8859-9', 'de_DE.ISO8859-1', 'tr-TR', 'Turkish_Turkey.1254', 'German_Germany.1252'] as $locale) {
    $result = setlocale(LC_CTYPE, $locale);
    echo $locale, ': ', var_export($result, true);
    if ($result !== false) {
        $keys = ['I' => 0, 'h' => 0, "\xC4" => 0, "\xE0" => 0];
        ksort($keys, SORT_STRING | SORT_FLAG_CASE);
        echo ' substr_compare(I,i)=', substr_compare('I', 'i', 0, 1, true),
            ' substr_compare(C4,E4)=', substr_compare("\xC4", "\xE4", 0, 1, true),
            ' ksort=', implode(' ', array_map(bin2hex(...), array_keys($keys)));
    }
    echo "\n";
}
?>
--EXPECT--
probe
