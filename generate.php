<?php

// characters array from [A-Z]
$charSet = ['A','B','C','D','E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

// open  5-files and add flag 'w' => 'write'
$fileOne    = fopen("file1.txt", "w") or die("Unable to open file!");
$fileTwo    = fopen("file2.txt", "w") or die("Unable to open file!");
$fileThree  = fopen("file3.txt", "w") or die("Unable to open file!");
$fileFour   = fopen("file4.txt", "w") or die("Unable to open file!");
$fileFive   = fopen("file5.txt", "w") or die("Unable to open file!");

// generate function takes file, lengthOfFile, charsArray 
// and generate string from charSet array randomly 
// then write it in each files 
function generate ($file, $chars) {
  // get random file length of characters 
  $fileLength = rand(10, 30);
  // define empty string to add the generated characters
  $str = '';
  // generate random number from 0 - length of characters array
  // and then add to str string 
  for($i = 0; $i < $fileLength; $i++) {
    $index = rand(0, count($chars) - 1);
    $str.= $chars[$index] . ' ';
  }
  // write str in the opened file
  fwrite($file, $str);
  // close the file
  fclose($file);
}

// generate function call 5 times of 5 files
generate($fileOne, $charSet);
generate($fileTwo, $charSet);
generate($fileThree, $charSet);
generate($fileFour, $charSet);
generate($fileFive, $charSet);


?>
