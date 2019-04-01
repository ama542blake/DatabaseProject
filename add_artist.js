window.onload = function () {
    var band_radio = document.getElementById("band_radio");
    $('#solo_radio').click(function () {
        //remove the input for band members
        if ($("#band-members-input").length) {
            $("#band-members-input").remove();
        }
        // replace with input for band membership
        if (!$('#band-membership-input').length) {
            $("#submit-artist").before(getBandMembershipHTML());   
        }
    });
    
    $('#band_radio').click(function () {   
        // remove input for band membership
        if ($("#band-membership-input").length) {
            $("#band-membership-input").remove();       
        } 
        // replace with input for band members
        if (!$("#band-members-input").length) {
            $("#submit-artist").before(getBandMembersHTML());
        }
    });
}

function getBandMembershipHTML() {
    return '<label id="band-membership-input" class="mb-3">Band Membership (optional):' +
                '<input type="text" class="form-control input-info" name="band_membership"><br>' +
            '<p>Seperate band names with a comma.</p></label>';
} 

function getBandMembersHTML() {
    return '<label id="band-members-input" class="mb-3">Band Members (optional):' +
                '<input type="text" class="form-control input-info" name="band_members"><br>' +
                '<p>Seperate band names with a comma.</p></label>';
}