window.onload = function () {
    var band_radio = document.getElementById("band_radio");
    $('#solo_radio').click(function () {
        if (!$('#band-membership-input').length) {
            // needs to not be in body, but adding toform does't work.   
            $("#band_form").append(getBandMembership());   
        }
         
        
    });
    
    $('#band_radio').click(function () {   
        $("#band-membership-input").remove();    
    });
}

function getBandMembership() {
    return '<label id="band-membership-input">Band Membership (leave blank if the artist is not in a band):' +
                '<input type="text" class="form-control" name="band_membership" required>' +
            '</label>';
}