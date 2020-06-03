import $ from 'jquery';
import axios from 'axios';

$(document).ready(function() {

    const quantityChange = document.getElementsByClassName('cart-quantity');

    Array.from(quantityChange).forEach(input => {
        input.addEventListener('change', function() {

            var id = input.dataset.id;
            var quantity = input.value;
            var url = "api/cart_item/" + id + "/quantity";

            $.ajax({
                type: 'PUT',
                url: url,
                data: { "quantity": quantity },
                dataType: 'json',
                success: function(data) {
                    var amount = new Intl.NumberFormat('vi-VN').format(data.result.amount);
                    var total  = new Intl.NumberFormat('vi-VN').format(data.cart.total);
                    $('#alert').html(data.error);
                    $('#amount-' + id).html(amount);
                    $('#total').html(total);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(JSON.stringify(jqXHR));
                    console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                }
            });
        });
    });
});
