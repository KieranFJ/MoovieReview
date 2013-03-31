<!-- Review Form
     Review form that is used to upload user submitted reviews to the database
     Submission are sent to script/reviewUp.php

     jQuery is used to hide this form until the user clicks on a link, at which
     point it appears for use.
     Last updated 17/05/11
     by Kieran Foxley-Jones
-->

<head>
    <script src="jscript/jquery-1.3.2.min.js" type="text/javascript"></script>
    <script src="jscript/jquery.ratings.js" type="text/javascript"></script>
    <script type="text/javascript">
        //script that changes the the rating star bar to 10 stars long
        $(document).ready(function() {
            $('#Rating').ratings(10).bind('ratingchanged', function(event, data) {
                $('#RatingValue').val(data.rating);
            });
        });</script>
    
     <link rel="stylesheet" type="text/css" href="css/jquery.ratings.css" />
</head>

<a href="#contactForm">Your Review</a>

<form id="contactForm" action="script/reviewup.php" method="post">
<input type="hidden" name="Mov_ID" value="<?php echo $_GET['Mov_ID']; ?>"/>
<input type="hidden" name="Mov_Name" value="<?php echo $movieName; ?>"/>
  <h2>Review</h2>

  <ul>

    <li>
      <label for="Summary">Your Summary</label>
      <input type="revInput" name="Summary" id="Summary" placeholder="Please type your summary" required="required" maxlength="40" />
    </li>
    <li>
            <div id="Rating"></div> <br />
            <label for="senderEmail">Your Rating</label><input type="hidden" name="jsRating" id="RatingValue" value=""></input>
<br />

    </li>
    <li>
      <label for="Review" style="padding-top: .5em;">Your Review</label>
      <textarea type="revTextarea" name="Review" id="Review" placeholder="Please type your review" required="required" cols="80" rows="10" maxlength="10000"></textarea>
    </li>
  </ul>

  <div id="formButtons">
    <input type="Submit" id="sendMessage" name="sendMessage" value="Post Review" />
    <input type="Button" id="cancel" name="cancel" value="Cancel" />
  </div>

</form>

<div id="sendingMessage" class="statusMessage"><p>Sending your message. Please wait...</p></div>
<div id="successMessage" class="statusMessage"><p>Thanks for sending your message! We'll get back to you shortly.</p></div>
<div id="failureMessage" class="statusMessage"><p>There was a problem sending your message. Please try again.</p></div>
<div id="incompleteMessage" class="statusMessage"><p>Please complete all the fields in the form before sending.</p></div>
