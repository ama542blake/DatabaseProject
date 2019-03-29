$("#edit-artist-info").click(function() {
    // decide if the artist is solo or band
    if ($("#band-results").length){//document.getElementById("band-results")) {
        editBand($("#band-results"));
    } else if ($("#solo-results").length) {
        editSolo($("#solo-results"));
    } else alert("Something has gone wrong");
    
    function editBand(resultDiv) {
        // make the info page a form for updating
        resultDiv.addClass("form-group");
        resultDiv.wrap("<form action='update_band.php' method='post' id='artist-update-form'></form>");
        var updateForm = $("#artist-update-form");
    
        // get the HTML elements and text values for all of the information
        var memberSpan = $("#member-span");
        var memberValues = memberSpan.text();
        // get the artistID of each member from each member link
        var oldMemberLinks = $(".member-links");
        var oldMemberIDs = new Array();
        $.each(oldMemberLinks, function(index) {
            oldMemberIDs[index] = this.getAttribute("id");
        });
        
        oldMemberIDs.forEach(function(id) {
            updateForm.append(`<input type='hidden' value='${id}' name='old_member_ids[]'>`);
        });
        
        // change the members span to an input
        memberSpan.html(`<input type='text' id='members-input' name='members' value='${memberValues}' required><br><p>Seperate member names with commas.</p>`);
        
        /* don't think this is needed right now, could potentially be useful
        later on though... not sure yet */
//        // get the albumID for each album
//        var albumLinks = $(".album-links");
//        var albumIDs = new Array();
//        albumLinks.each(function(index) {
//            albumIDs[index] = this[index].attr("id");
//        });
//        albumIDs.forEach(function(id) {
//            updateForm.append(`<input type='hidden' value='${id}' name='album_ids[]'>`);
//        });
        
        // trim whitespace from beginning and end of inputs before submitting
        $("#members-input").focusout(function() {
            $(this).val($(this).val().trim());
        });
    }
    
    function editSolo(resultDiv) {
        resultDiv.addClass("form-group");
        resultDiv.wrap("<form action='update_solo.php' method='post' id='artist-update-form'></form>");
        var updateForm = $("#artist-update-form");
        
        // get the HTML elements and text values for all of the information
        var bandSpan = $("#band-span");
        var bandValues = bandSpan.text();
        // get the artistID of each band from each band link
        var bandLinks = $(".member-links");
        var bandIDs = new Array();
        bandLinks.each(function(index, value) {
            //bandIDs[index] = this[index].attr("id");
            var val = value.attr("id");
            bandIDs[index] = val;
            console.log(bandIDs[index]);
        });
        
        bandIDs.forEach(function(id) {
            updateForm.append(`<input type='hidden' value='${id}' name='old_band_ids[]'>`);
        });
        
        bandSpan.html(`<input type='text' id='bands-input' name='bands' value='${bandValues}' required><br><p>Seperate band names with commas.</p>`);
        
        $("#bands-input").focusout(function() {
            $(this).val($(this).val().trim());
        });
    }
    
    $(this).remove();
    
    // retrieves the ?artist_id=whatever for redirecting to the infomation page from updatr_artidt.php after updates have been made
    var artistParam = location.search;
    // next 2 lines extract just the artist ID from the ?artist_id=whatever
    var idRegExp = /[0-9]+/;
    var artistID = artistParam.match(idRegExp).join("");
    
    $("#artist-update-form").append(`<input type='hidden' id='update-button' name='redir_id' value='${artistParam}'>`);
    $("#album-update-form").append(`<input type='hidden' name='artist_id' value='${artistID}'>`); 
    $("#artist-update-form").append("<input type='submit' id='update-button' value='Update Artist Info'>");
    
    function parseOldMemberID(link) {
        //var regex = \\
    }
});