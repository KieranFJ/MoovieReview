<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 *
 * /* outputs image in selected row, the api sends back info on various sized images
 * 0 - full - full height generally very large
 * 1 - mid sized - useful for use to look at poster
 * 2 - cover - useful for movie page output
 * 3 - thumb - thumbnail
 *
 * Recommend use of 1 and 2
 *
 * 4 5 6... etc are backdroups
 * 4 - original
 * 3 - poster
 * 6 - thumb
 *
 */
class tmdbSearch {


    public function search($title) {

        @include_once 'TMDb.php';
        $tmdb_xml = new TMDb('93a3f01925642df2c7898dc0d9fedcc7',TMDb::XML);
        $xml_movies_results = $tmdb_xml->searchMovie($title);

    return (string) $xml_movies_results;




    }
}


?>
