<?php

@include_once 'TMDb.php';

$tmdb_xml = new TMDb('93a3f01925642df2c7898dc0d9fedcc7',TMDb::XML);
$xml_movie_results = $tmdb_xml->getGenres();
$xml_movie_results = new SimpleXMLElement($xml_movie_results);

$i = 0;
while ($i < $xml_movie_results->genres->genre->count()) {
    echo "<a href=\"movies.php?Mov_ID=".$xml_movie_results->genres->genre[$i]->id."\">".
            $xml_movie_results->genres->genre[$i]->attributes()."</a><br />";

    $i++;
}

$who = "wah";

?>
\\