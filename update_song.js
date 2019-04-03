$("#edit-song-info").click(function() {
    // make the info page a form for updating
    var resultDiv = $("#results");
    resultDiv.addClass("form-group");
    resultDiv.wrap("<form action='update_song.php' method='post' id='song-update-form'></form>");
    
    // get the HTML elements and text values for all of the information
    var artistsSpan = $("#artists");
    var artistsValue = artistsSpan.text();
    var albumsSpan = $("#albums");
    var albumsValue = albumsSpan.text();
    var genreSpan = $("#genre");
    var genreValue = genreSpan.text();
    
    artistsSpan.html(`<input type='text' class='form-control' id='artists-input' name='artists' value='${artistsValue}' required>`
    + "<br><label>Solo Artist<input type='radio' id='solo_radio' class='form-check-inline ml-2 mr-1' name='isband' value='0'></label>"
    + "<label>Band<input type='radio' id='band_radio' class='form-check-inline ml-2 mr-1' name='isband' value='1' checked></label>");
    albumsSpan.html(`<input type='text' class='form-control' id='albums-input' name='albums' value='${albumsValue}' required>`);
    genreSpan.html(`<input type='text' class='form-control' id='genre-input' name='genre' value='${genreValue}'>`);

    $(this).remove();
    
    // retrieves the ?song_id=whatever for redirecting to the infomation page from update_song.php after updates have been made
    var songParam = location.search;
    // next 2 lines extract jus the song ID from the ?song_id=whatever
    var idRegExp = /[0-9]+/;
    var songID = songParam.match(idRegExp).join("");

    $("#song-update-form").append(`<input type='hidden' name='redir_id' value='${songParam}'>`);
    $("#song-update-form").append(`<input type='hidden' name='song_id' value='${songID}'>`);
    $("#update-info").append("<input type='submit' class='btn btn-block btn-primary' id='update-button' value='Update'>");
    
    // event listeners for the artist solo/band radio buttons
    $('#solo_radio').click(function () {
        if (!$('#band-membership-input').length) {
            // needs to not be in body, but adding to form doesn't work.   
            artistsSpan.append(getBandMembershipHTML());   
        }
    });
    
    $('#band_radio').click(function () {   
        $("#band-membership-input").remove();   
    });
    
    // trim whitespace from beginning and end of inputs before submitting
   $("#artists-input").focusout(function() {
       $(this).val($(this).val().trim());
   });
   $("#albums-input").focusout(function() {
       $(this).val($(this).val().trim());
   });
   $("#genre-input").focusout(function() {
       $(this).val($(this).val().trim());
   });

    
    function getBandMembershipHTML() {
    return '<label id="band-membership-input" class="mb-3">Band Membership (optional):' +
                '<input type="text" class="form-control input-info" name="band_membership">' +
            '</label>';
    }
});
