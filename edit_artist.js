$("#editArtistInfo").click(function() {
    // make the info page a form for updating
    var resultDiv = $("#results");
    resultDiv.addClass("form-group");
    resultDiv.wrap("<form action='update_artist.php' method='post' id='artist-update-form'></form>");
    
    // get the HTML elements and text values for all of the information

    
    $(this).remove();
    
    // retrieves the ?artist_id=whatever for redirecting to the infomation page from updatr_artidt.php after updates have been made
    var artistParam = location.search;
    // next 2 lines extract just the artist ID from the ?artist_id=whatever
    var idRegExp = /[0-9]+/;
    var artistID = artistParam.match(idRegExp).join("");
    
    $("#artist-update-form").append(`<input type='hidden' id='update-button' name='redir_id' value='${artistParam}'>`);
    $("#artist-update-form").append("<input type='submit' id='update-button' value='Update Artist Info'>");
    $("#album-update-form").append(`<input type='hidden' name='artist_id' value='${artistID}'>`);
    
    // trim whitespace from beginning and end of inputs before submitting
   $("#albums-input").focusout(function() {
       $(this).val($(this).val().trim());
   });
   $("#year-input").focusout(function() {
       $(this).val($(this).val().trim());
   });
   $("#artwork-artist-input").focusout(function() {
       $(this).val($(this).val().trim());
   });
});