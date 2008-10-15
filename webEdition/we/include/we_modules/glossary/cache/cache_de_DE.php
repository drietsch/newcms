<?php

$link = array(
);


$acronym = array(
);


$abbreviation = array(
"/((<[^>]*)|([^[:alnum:]])(zum Beispiel)([^[:alnum:]]))/e" => '"\2"=="\1"?"\1":"\3<abbr title=\"z.B.\" lang=\"de\" xml:lang=\"de\">\4</abbr>\5"',
);


$foreignword = array(
);

?>