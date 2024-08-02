//Function updates cart count using AJAX. Takes about 2 seconds - but this is purely a visual feature.

jQuery(document).ready(function($) {
    // Function to update cart count
    function updateCartCount() {
        $.ajax({
            url: cartCountAjax.ajaxurl,
            type: 'POST',
            data: {
                action: 'update_cart_count'
            },
            success: function(response) {
                if (response) {
                    $('.cart-count').text(response);
                }
            }
        });
    }

    // Call updateCartCount on page load
    updateCartCount();

    // Event listener to update cart count on any change to cart
    $(document.body).on('added_to_cart removed_from_cart', function() {
        updateCartCount();
    });
});