<?php

// characters array from [A-Z]
$charSet = ['A','B','C','D','E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

// open  5-files and add flag 'w' => 'write'
$fileOne    = fopen("file1.txt", "w") or die("Unable to open file!");
$fileTwo    = fopen("file2.txt", "w") or die("Unable to open file!");
$fileThree  = fopen("file3.txt", "w") or die("Unable to open file!");
$fileFour   = fopen("file4.txt", "w") or die("Unable to open file!");
$fileFive   = fopen("file5.txt", "w") or die("Unable to open file!");



?>
