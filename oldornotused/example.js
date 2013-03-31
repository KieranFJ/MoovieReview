$(document).ready(function() {
  $('#Rating').ratings(10).bind('ratingchanged', function(event, data) {
    $('#RatingValue').val(data.rating);
  });
});