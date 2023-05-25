// Custom JavaScript for the admin area of the Webjoint WooCommerce Plugin

document.addEventListener('DOMContentLoaded', (event) => {
    // Code to run when the admin page is loaded goes here

    // Example: Show a message in the console
    console.log('Webjoint WooCommerce Plugin admin page loaded');

    // Get the settings form
    var settingsForm = document.querySelector('.webjoint-settings-form');

    if (settingsForm) {
        // Add an event listener for the form submission
        settingsForm.addEventListener('submit', (event) => {
            // Get the API key and facility ID inputs
            var apiKeyInput = document.querySelector('#webjoint_api_key');
            var facilityIdInput = document.querySelector('#webjoint_facility_id');

            // Check if the API key and facility ID are set
            if (!apiKeyInput.value.trim() || !facilityIdInput.value.trim()) {
                event.preventDefault();
                alert('Please fill out both the API key and the facility ID.');
            }
        });
    }
});