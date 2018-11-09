<?php

// define $set hash-map 
$set = array();

// get query from input
$queryLower = $_POST["querystring"];
// convert the query to uppercase
$queryUpper = strtoupper($queryLower);

// check if query empty [rewrite] else check regular expression
if ($queryUpper == "") {
    echo 'error, empty query!';
  // regular expression that accepts characters from a-z with one white-space in between
} else if (!preg_match('/^([A-Za-z][ ]{1})+$/', $queryUpper)) {
    echo 'error, not match!';
} else { 
    // start apply vector-space-model functions
}

?>


