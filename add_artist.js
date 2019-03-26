window.onload = function () {
    var band_radio = document.getElementById("band_radio");
    $('#solo_radio').click(function () {
        if (!$('#band-membership-input').length) {
            // needs to not be in body, but adding toform does't work.   
            $("#submit-artist").before(getBandMembershipHTML());   
        }
         
        
    });
    
    $('#band_radio').click(function () {   
        $("#band-membership-input").remove();    
    });
}

function getBandMembershipHTML() {
    return '<label id="band-membership-input" class="mb-3">Band Membership (optional):' +
                '<input type="text" class="form-control input-info" name="band_membership">' +
            '</label>';
}