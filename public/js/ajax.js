
$(document).ready(function () {

    //wishlist ajax call
    $('.add-to-wishlist').click(function (e) {
        e.preventDefault();
        var productId = $(this).data('product_id');

        $.ajax({
            type: 'POST',
            url: '/wishlist', // or "{{ route('wishlist.store') }}" if using Blade
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: productId,
            },
            success: function (response) {
                sweet(response.status, response.message);
                $('.wishlist').html(response.data['count']);
            },
            error: function (error) {
                let message = 'Something went wrong.';
                if (error.responseJSON && error.responseJSON.message) {
                    message = error.responseJSON.message;
                }
                sweet('error', message);
            }
        });
    });

    $('.remove-to-wishlist').click(function (e) {
        e.preventDefault();
        var productId = $(this).data('product_id');
        $.ajax({
            type: 'DELETE',
            url: '/wishlist/' + productId,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                sweet(response.status, response.message);
                window.location.reload();
            },
            error: function (error) {
                let message = 'Something went wrong. Try again.';
                if (error.responseJSON && error.responseJSON.message) {
                    message = error.responseJSON.message;
                }
                sweet('error', message);
            }
        });
    });

    //cart ajax call
    $('.add-to-cart').click(function (e) {
        e.preventDefault();

        var productId = $(this).data('product_id');

        $.ajax({
            type: 'POST',
            url: '/cart', // or "{{ route('wishlist.store') }}" if using Blade
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: productId,
            },
            success: function (response) {
                sweet(response.status, response.message);
                if (response.status == "success") {
                    cartupdate(response);
                }

            },
            error: function (error) {
                let message = 'Something went wrong. Try again.';
                if (error.responseJSON && error.responseJSON.message) {
                    message = error.responseJSON.message;
                }
                sweet('error', message);
            }
        });
    });

    $('.remove-to-cart').click(function (e) {
        const tr = $(this);
        e.preventDefault();
        var productId = $(this).data('product_id');
        $.ajax({
            type: 'DELETE',
            url: '/cart/' + productId,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                sweet(response.status, response.message);
                if (response.status == "success") {
                    cartupdate(response)
                    tr.closest('tr.cart_list_item').fadeOut(400, function () {
                        $(this).remove();
                    });

                }
            },
            error: function (error) {
                let message = 'Something went wrong. Try again.';
                if (error.responseJSON && error.responseJSON.message) {
                    message = error.responseJSON.message;
                }
                sweet('error', message);
            }
        });
    });

    $('.inc, .dec').on('click', function (e) {
        let input = $(this).siblings('.update-qty');
        let productId = input.data('product_id');
        let item_price = parseFloat(input.data('item_price'));
        let cart_qty = $(this);

        if (e.target.classList.contains('inc')) {
            input = parseInt(input.val()) + 1;
        } else {
            input = parseInt(input.val()) - 1;
        }

        if (input < 1) {
            sweet('error', "Minimum 1 Item Required.")
            return false;
        }
        $.ajax({
            type: 'PUT',
            url: '/cart/' + productId,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                qty: input,
            },
            success: function (response) {
                sweet(response.status, response.message);
                if (response.status == "success") {
                    cartupdate(response);
                    cart_qty.closest('td.cart__quantity')
                        .next('td.cart__price')
                        .find('span').text(item_price * input);
                }
            },
            error: function (error) {
                let message = 'Something went wrong. Try again.';
                if (error.responseJSON && error.responseJSON.message) {
                    message = error.responseJSON.message;
                }
                sweet('error', message);
            }
        });
    });


    $('.apply-coupon').on('submit', function (e) {
        e.preventDefault();
        let form = $(this);
        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize(),
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                sweet(response.status, response.message);
                if (response.status == "success") {
                    window.location.reload();
                }
            },
            error: function (error) {
                let message = 'Something went wrong. Try again.';
                if (error.responseJSON && error.responseJSON.message) {
                    message = error.responseJSON.message;
                }
                sweet('error', message);
            }
        });
    });

    $('#remove_coupon').on('click', function (e) {
        $.ajax({
            type: 'delete',
            url: "/remove-coupon",
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                sweet(response.status, response.message);
                if (response.status == "success") {
                    window.location.reload();
                }
            },
            error: function (error) {
                let message = 'Something went wrong.';
                if (error.responseJSON && error.responseJSON.message) {
                    message = error.responseJSON.message;
                }
                sweet('error', message);
            }
        });
    });

});

function cartupdate(response) {
    $('.cart_count').html(response.data.count);
    $('.price').html(response.data.price)
    $('.discount').html(response.data.discount)
    $('.coupon').html(response.data.coupon)
    $('.gst').html(response.data.gst)
    $('.final_total').html(response.data.final_total)
}