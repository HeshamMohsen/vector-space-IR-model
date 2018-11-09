<?php

// define $set hash-map 
$set = array();

// get query from input
$queryLower = $_POST["querystring"];
// convert the query to uppercase
$queryUpper = strtoupper($queryLower);

// check if query empty [rewrite] else check regular expression
if ($queryUpper == "") {
  $title = "Whoops...";
  $message = "We're unable to find data you're looking for";
  $btnText = "Find Again";
  // regular expression that accepts characters from a-z with one white-space in between
} else if (!preg_match('/^([A-Za-z][ ]{1})+$/', $queryUpper)){
    $title = "Whoops...";
    $message = "We're unable to find data you're looking for";
    $btnText = "Find Again";
} else { 
    // apply vector-space-model functions
}

  if( isset($title) && isset($message) && isset($btnText) ) {
    $htmlStructure = '
    <div class="handler--white">
      <div class="header-text">
        <div class="header-square">
          <h1>' . $title . '</h1>
          <p>' . $message . '</p>
          <a href="http://localhost/information-retrieval/statistical-model/index.php">' . $btnText . '</a>
        </div>
      </div>
      <div class="image">
        <div class="image--square">
            <img src="images/file.PNG"/>
        </div>
      </div>
    </div>';
  }
?>


<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="css/normalize.css"> 
    <link rel="stylesheet" href="css/ir.css">
  <body>
      <?php if(isset($htmlStructure)) echo $htmlStructure ?>
  </body>
</html>
