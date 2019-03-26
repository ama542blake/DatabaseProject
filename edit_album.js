$("#editAlbumInfo").click(function() {
    // make the info page a form for updating
    var resultDiv = $("#results");
    resultDiv.addClass("form-group");
    resultDiv.wrap("<form action='update_album.php' method='post' id='album-update-form'></form>");
    
    // get the HTML elements and text values for all of the information
    var yearSpan = $("#albumYear");
    var yearValue = yearSpan.text();
    var artworkSpan = $("#albumArtworkArtistName");
    var artworkValue = artworkSpan.text();

    
    yearSpan.html(`<input type='text' name='year' value='${yearValue}' required>`);
    artworkSpan.html(`<input type='text' name='artwork' value='${artworkValue}' required>`);

    $(this).remove();
    
    var albumParam = location.search;
    $("#album-update-form").append(`<input type='hidden' id='update-button' name='redir_id' value='${albumParam}'>`);
    $("#album-update-form").append("<input type='submit' id='update-button' value='Update Album Info'>");
});