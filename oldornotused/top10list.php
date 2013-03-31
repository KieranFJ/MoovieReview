<?php
@include ('TMDb.php');

$tmdb_xml = new TMDb('93a3f01925642df2c7898dc0d9fedcc7',TMDb::XML);
$genres = "12,28,16,35,80,105,18,82,14,36,9648,1115,878,53,37,10748,9805";  //
$xml_movie_results = $tmdb_xml->browseMovies('rating','desc', 'per_page=10&page=1&min_votes=15&genres='.$genres);
$xml_movie_results = new SimpleXMLElement($xml_movie_results);

$i = 0;
while ($i < $xml_movie_results->movies->movie->count()) { //returns the amount of movie there are
    echo "<div id=\"contentTop10Single\">";

    if (isset($xml_movie_results->movies->movie[$i]->images->image[2]['url'])) {
        echo "<img src=\"".$xml_movie_results->movies->movie[$i]->images->image[2]['url']."\"></img>";
    }
    else {
        echo "<img src=\"images/no-poster.jpg\"></img>";
    }
    echo "<strong><a href=\"title.php?Mov_ID=".$xml_movie_results->movies->movie[$i]->id."\"
    >".$xml_movie_results->movies->movie[$i]->name."</a></strong>"; //outputs <name> in array position $i
    echo "</div> ";

$i++;

}
?>
