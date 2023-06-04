jQuery(document).ready(function($) {
    // Handle form submission
    $('#webjoint-settings-form').submit(function(e) {
        e.preventDefault();

        // Validate API key
        var apiKey = $('#webjoint-api-key').val();
        if (apiKey == '') {
            alert('Please enter your Webjoint API key.');
            return;
        }

        // Validate Facility ID
        var facilityId = $('#webjoint-facility-id').val();
        if (facilityId == '') {
            alert('Please enter your Webjoint Facility ID.');
            return;
        }

        // Send AJAX request to save settings
        $.ajax({
            url: ajaxurl, // This is a variable that WordPress defines for us
            method: 'POST',
            data: {
                action: 'webjoint_save_settings',
                api_key: apiKey,
                facility_id: facilityId
            },
            success: function(response) {
                if (response.success) {
                    alert('Settings saved successfully.');
                } else {
                    alert('There was an error saving the settings. Please try again.');
                }
            },
            error: function() {
                alert('There was an error sending the request. Please try again.');
            }
        });
    });
});
