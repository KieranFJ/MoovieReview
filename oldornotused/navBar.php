<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

 echo "<div id=\"navBar\">
            <ul id=\"jsddm\">
                <li><span>By Genre</span>
                    <ul>
                        <?php listingScript::top10Genre(); ?>
                    </ul>
                </li>
                <li>By Letter
                    <ul>
                        <li>Alphabetical list here</li>
                    </ul>
                </li>
            </ul>

        </div>";

?>
