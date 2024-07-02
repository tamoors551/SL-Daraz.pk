$(document).ready(function() {
    $('.add-to-cart').click(function() {
        const productId = $(this).data('id');
        const quantity = $(this).data('quantity');

        const data = {
            product_id: productId,
            quantity: quantity
        };

        // Send AJAX request to add-to-cart.php
        $.ajax({
            url: '../ajax/add-to-cart.php',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function(response) {
                const result = JSON.parse(response);
                if (result.success) {
                    // Redirect to cart page or update cart summary
                    window.location.href = '../pages/cart.php'; // Example redirect to cart page
                } else {
                    alert('Failed to add product to cart');
                }
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    });
});
