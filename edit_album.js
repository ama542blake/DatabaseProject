$("#edit-album-info").click(function() {
    // make the info page a form for updating
    var resultDiv = $("#results");
    resultDiv.addClass("form-group");
    resultDiv.wrap("<form action='update_album.php' method='post' id='album-update-form'></form>");
    
    // get the HTML elements and text values for all of the information
    var yearSpan = $("#albumYear");
    var yearValue = yearSpan.text();
    var artworkSpan = $("#albumArtworkArtistName");
    var artworkValue = artworkSpan.text();
    var artistsSpan = $("#album-artists");
    var artistsValue = artistsSpan.text();

    yearSpan.html(`<input class='form-control' id='year-input' type='text' name='year' value='${yearValue}'>`);
    artworkSpan.html(`<input class='form-control' id='artwork-artist-input' type='text' name='artwork_artist' value='${artworkValue}'>`);
    artistsSpan.html(`<input class='form-control' id='artists-input' type='text' name='artists' value='${artistsValue}' required>`)
    
    $(this).remove();
    
    // retrieves the ?album_id=whatever for redirecting to the infomation page from update_album.php after updates have been made
    var albumParam = location.search;
    // next 2 lines extract just the album ID from the ?album_id=whatever
    var idRegExp = /[0-9]+/;
    var albumID = albumParam.match(idRegExp).join("");
    
    $("#album-update-form").append(`<input type='hidden' name='redir_id' value='${albumParam}'>`);
    $("#update-info").before("<input class='btn btn-primary' type='submit' id='update-button' value='Update Album Info'>");
    $("#album-update-form").append(`<input type='hidden' name='album_id' value='${albumID}'>`);
    
    // trim whitespace from beginning and end of inputs before submitting
   $("#artists-input").focusout(function() {
       $(this).val($(this).val().trim());
   });
   $("#year-input").focusout(function() {
       $(this).val($(this).val().trim());
   });
   $("#artwork-artist-input").focusout(function() {
       $(this).val($(this).val().trim());
   });
});