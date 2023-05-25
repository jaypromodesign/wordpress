document.addEventListener('DOMContentLoaded', (event) => {
    // Fetch and display data from the WebJoint API
    var webjointElements = document.querySelectorAll('.webjoint-output');

    webjointElements.forEach((element) => {
        var endpoint = element.dataset.endpoint;
        var parameters = element.dataset.parameters;
        var apiUrl = 'https://app.webjoint.com/prod/api/' + endpoint + '?' + parameters;

        fetch(apiUrl, {
            headers: {
                'X-Api-Key': element.dataset.apiKey,
                'X-Facility-Id': element.dataset.facilityId,
            },
        })
        .then((response) => response.json())
        .then((data) => {
            element.innerHTML = JSON.stringify(data, null, 2);
        })
        .catch((error) => {
            console.error('Error:', error);
            element.innerHTML = 'Error fetching data from the WebJoint API';
        });
    });

    if(window.jQuery) {
        // Event triggered when a product is added to the cart
        jQuery(document.body).on('added_to_cart', function() {
            var cart = {
                'items': []
            };

            jQuery('.cart_item').each(function() {
                var item = {
                    'product_id': jQuery(this).data('product_id'),
                    'quantity': jQuery(this).find('.quantity').val()
                };

                cart.items.push(item);
            });

            jQuery.post(
                wc_add_to_cart_params.ajax_url, 
                {
                    'action': 'webjoint_sync_cart',
                    'cart': JSON.stringify(cart)
                },
                function(response) {
                    console.log("Cart sync response: ", response);
                }
            );
        });

        // Event triggered when a new user is registered
        jQuery(document.body).on('new_user_registered', function(event, user_id) {
            jQuery.post(
                wc_add_to_cart_params.ajax_url,
                {
                    'action': 'webjoint_sync_user',
                    'user_id': user_id
                },
                function(response) {
                    console.log("User sync response: ", response);
                }
            );
        });

        // Event triggered when a new order is placed
        jQuery(document.body).on('new_order_placed', function(event, order_id) {
            jQuery.post(
                wc_add_to_cart_params.ajax_url,
                {
                    'action': 'webjoint_sync_order',
                    'order_id': order_id
                },
                function(response) {
                    console.log("Order sync response: ", response);
                }
            );
        });
    }
});
