window.onload = function() {
    var band_radio = document.getElementById("band_radio");
    alert("the tits");
    band_radio.click(function() {
        if $('#band_radio').is(":checked") {
            alert("checked");
        } else {
            alert("not checked");
            //$("#band_info").append(getBandMembership());
        }
        
    });
}

function getBandMembership() {
    return '<label id="band-membership-input">Band Membership (leave blank if the artist is not in a band):' +
                '<input type="text" class="form-control" name="bandmembership">' +
            '</label>';
}