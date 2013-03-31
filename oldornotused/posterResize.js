/* Resizes any over or under sized posters to fit*/

$(document).ready(function(){
                  $('img.Poster').imgscale({
                    parent : '.contentPoster',
                    center : false,
                    fade : 500
                  });
                });