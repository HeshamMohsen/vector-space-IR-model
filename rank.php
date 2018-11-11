<?php

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
} else if (!preg_match('/^([A-Za-z][ ]{1})+([A-Za-z])$/', $queryUpper)){
    $title = "Whoops...";
    $message = "We're unable to find data you're looking for";
    $btnText = "Find Again";
} else {
    // function to calculate each file f, tf, df, idf and tf-idf
    function getfileDetails($file, $fileName, $filesContent) {
        // file-terms
        $terms = array(
            'file1' => array(),
            'file2' => array(),
            'file3' => array(),
            'file4' => array(),
            'file5' => array(),
            'Q' => array(),
        );
        // return array
        $fileTerms = explode(' ', $file);
        // call max function to get max number of repeated term
        $max = getMax($file, $fileTerms);
        // start calcs.
        foreach($fileTerms as $key => $val) {
            // if key-term not exist .. push 
            if(!array_key_exists($fileTerms[$key], $terms[$fileName])) {
                $terms[$fileName][$fileTerms[$key]]['f'] = substr_count($file, $fileTerms[$key]);
                //
                $terms[$fileName][$fileTerms[$key]]['tf'] = $terms[$fileName][$fileTerms[$key]]['f'] / $max;
                // 
                $terms[$fileName][$fileTerms[$key]]['df'] = getNumberOfDocsContainTerm($filesContent, $fileTerms[$key]);
                // 
                $terms[$fileName][$fileTerms[$key]]['idf'] = log(count($filesContent) / $terms[$fileName][$fileTerms[$key]]['df'], 2);
                //  
                $terms[$fileName][$fileTerms[$key]]['tf-idf'] = $terms[$fileName][$fileTerms[$key]]['tf'] * $terms[$fileName][$fileTerms[$key]]['idf']; 
            }  
        }
        // return 
        return $terms[$fileName];
    }

    // function takes [files array] and term key  
    // then return how many document have that term 
    function getNumberOfDocsContainTerm ($files, $term) {
        // define result
        $numberOfFiles = 0;
        // each loop add term occur in term document matrix
        foreach($files as $key => $val) {
            if(substr_count($files[$key], $term)) {
                $numberOfFiles += 1;
            }            
        }
        // return 
        return $numberOfFiles;
    }

    function getMax($file, $fileTerms) {
        // define result
        $max = 0;
        // each loop add term occur in term document matrix
        foreach($fileTerms as $key => $val) {
            if(substr_count($file, $fileTerms[$key]) > $max) {
                $max = substr_count($file, $fileTerms[$key]);
            }            
        }
        // return 
        return $max;
    }

    function cosSim ($Q, $D) {
        $terms_in_between = array();

        $sq1 = 0;
        $sq2 = 0;
        $score = 0;
        $score1 = 0;

        foreach($D as $key => $val) {
            if(!array_key_exists($key, $terms_in_between)) {
                array_push($terms_in_between, $key);
            }
            $sq1 += pow($D[$key]['tf-idf'], 2);
        }

        foreach($Q as $key => $val) {
            if(!array_key_exists($key, $terms_in_between)) {
                array_push($terms_in_between, $key);
            }
            $sq2 += pow($Q[$key]['tf-idf'], 2);
        }

        $term1 = 0;
        $term2 = 0;
        for($i = 0; $i < count($terms_in_between); $i++) {
            if(array_key_exists($terms_in_between[$i], $D)) {
                $term1 = $D[$terms_in_between[$i]]['tf-idf'];
            }
            if(array_key_exists($terms_in_between[$i], $Q)) {
                $term2 = $Q[$terms_in_between[$i]]['tf-idf'];
            }
            $score1 += $term1 * $term2;
        }

        $score = $score1 / sqrt($sq1 * $sq2);
        return $score;
    }

    // get files content
    $fileContent1 = file_get_contents("file1.txt");
    $fileContent2 = file_get_contents("file2.txt");
    $fileContent3 = file_get_contents("file3.txt");
    $fileContent4 = file_get_contents("file4.txt");
    $fileContent5 = file_get_contents("file5.txt");

    // files array hold all 5-files content 
    $filesContent = array($fileContent1, $fileContent2, $fileContent3, $fileContent4, $fileContent5);

    // initialize calculations for f, tf, df, idf, tf-idf 
    $file_one_terms     = getfileDetails($fileContent1, 'file1', $filesContent);
    $file_two_terms     = getfileDetails($fileContent2, 'file2', $filesContent);
    $file_three_terms   = getfileDetails($fileContent3, 'file3', $filesContent);
    $file_four_terms    = getfileDetails($fileContent4, 'file4', $filesContent);
    $file_five_terms    = getfileDetails($fileContent5, 'file5', $filesContent);
    $Q = getfileDetails($queryUpper, 'Q', $filesContent);


    // get files cosine similarity
    $fileScore_1 = cosSim($Q, $file_one_terms);
    $fileScore_2 = cosSim($Q, $file_two_terms);
    $fileScore_3 = cosSim($Q, $file_three_terms);
    $fileScore_4 = cosSim($Q, $file_four_terms);
    $fileScore_5 = cosSim($Q, $file_five_terms);

    // files
    $files = [
        "<a href='http://localhost/information-retrieval/vector-space-model/file1.txt' target='_blank'>file1</a>" => $fileScore_1,
        "<a href='http://localhost/information-retrieval/vector-space-model/file2.txt' target='_blank'>file2</a>" => $fileScore_2,
        "<a href='http://localhost/information-retrieval/vector-space-model/file3.txt' target='_blank'>file3</a>" => $fileScore_3,
        "<a href='http://localhost/information-retrieval/vector-space-model/file4.txt' target='_blank'>file4</a>" => $fileScore_4,
        "<a href='http://localhost/information-retrieval/vector-space-model/file5.txt' target='_blank'>file5</a>" => $fileScore_5
    ];

    // sort assoc. files according to the values
    arsort($files);
    
    // inject table rows in table 
    $list = '';
    foreach ($files as $key => $val) {
        $list .= '  
        <p> 
        <span>File: </span><strong>'. $key .'</strong>,
        <span>Score: </span><strong>'. $val .'</strong>
        </p>   
        '; 
    }

    $htmlSucessStructure = '
        <div class="handler--white">
        <div class="header-text">
            <div class="header-square-top">
            <h1> Ranking </h1>
            <div class="list">
                '. $list .'
            </div>
            <a href="http://localhost/information-retrieval/statistical-model/index.php" class="back"> Search Again </a>
            </div>
        </div>
        <div class="image">
            <div class="image--square">
                <img src="images/file.PNG"/>
            </div>
        </div>
        </div>';
}

if( isset($title) && isset($message) && isset($btnText) ) {
    $htmlStructure = '
    <div class="handler--white">
        <div class="header-text">
        <div class="header-square">
            <h1>' . $title . '</h1>
            <p>' . $message . '</p>
            <a href="http://localhost/information-retrieval/vector-space-model/index.php">' . $btnText . '</a>
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
      <?php if(isset($htmlSucessStructure)) echo $htmlSucessStructure ?>
  </body>
</html>
