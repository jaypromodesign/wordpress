(function($) {
    'use strict';

    $(document).ready(function() {
        $('#webjoint-settings-form').on('submit', function(e) {
            e.preventDefault();

            var api_key = $('#api_key').val();
            var facility_id = $('#facility_id').val();
            var sync_frequency = $('#sync_frequency').val();

            $.ajax({
                url: '/wp-json/webjoint/v1/settings',
                method: 'POST',
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('X-WP-Nonce', webjointAdmin.nonce);
                },
                data: {
                    api_key: api_key,
                    facility_id: facility_id,
                    sync_frequency: sync_frequency
                }
            }).done(function(response) {
                // Handle success
                if (response.success) {
                    alert('Settings saved successfully!');
                } else {
                    alert('There was an error saving your settings.');
                }
            }).fail(function() {
                // Handle error
                alert('There was an error sending your request.');
            });
        });
    });
})(jQuery);
