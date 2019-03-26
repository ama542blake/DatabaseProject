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
    var producerSpan = $("#producer");
    var producerValue = producerSpan.text();
    var genreSpan = $("#genre");
    var genreValue = genreSpan.text();
    
    artistsSpan.html(`<input type='text' name='artists' value='${artistsValue}' required>`
    + "<br><label>Solo Artist<input type='radio' id='solo_radio' class='form-check-inline ml-2 mr-1' name='isband' value='0'></label>"
    + "<label>Band<input type='radio' id='band_radio' class='form-check-inline ml-2 mr-1' name='isband<label>' value='1'>");
    albumsSpan.html(`<input type='text' name='albums' value='${albumsValue}' required>`);
    producerSpan.html(`<input type='text' name='producer' value='${producerValue}'>`);
    genreSpan.html(`<input type='text' name='genre' value='${genreValue}'>`);

    $(this).remove();
    
    var songParam = location.search;
    $("#song-update-form").append(`<input type='hidden' id='update-button' name='redir_id' value='${songParam}'>`);
    $("#song-update-form").append("<input type='submit' id='update-button' value='Update Song Info'>");
});
