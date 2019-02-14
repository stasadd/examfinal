$(document).ready(function () {
    $('.forAjax').on("click", function (event) {
        event.preventDefault();
        $.ajax({
            url: '/site/ajax',
            type: 'POST',
            data: {id: 0},
            success: function (result) {
                console.log(result);
            }
        });

    });

    //залишити відгук
    $('.send-review').on("click", function (event) {
        event.preventDefault();
        $.ajax({
            url: '/products/makereview',
            type: 'POST',
            data: $('form').serialize(),
            success: function (result) {
                //console.log(result);
                let data = JSON.parse(result);
                let review = '<div class="panel panel-success"><div class="panel-heading">' +
                    data.name +
                    '</div><div class="panel-body"><p>' +
                    data.text +
                    '</p></div></div>';
                $(".review-container").append(review);
            }
        });
    });

    //добавити в корзину prodCart
    $('.prodCart').on("click", function (event) {
        event.preventDefault();
        let prodId = $(this).attr('prodId');
        $.ajax({
            url: '/products/putintocart',
            type: 'POST',
            data: {id : prodId},
            success: function (result) {
                if(result == "success")
                    alert('товар додано в корзину');
                else if(result == "exist")
                    alert('такий товар уже додано в корзину');
                else
                    alert('не вдалося додати товар до корзини');
            }
        });
    });

    //видалення з корзини
    $('.deleteProdFromCart').on('click', function (event) {
        event.preventDefault();
        let prodId = $(this).attr('prodid');
        let selector = $(this);
        $.ajax({
            url: '/products/delfromcart',
            type: 'POST',
            data: {id : prodId},
            success: function (result) {
                console.log(result);
                if(result == "success") {
                    console.log(selector.closest('.curt-item'));
                    selector.closest('.curt-item').remove();
                }
            }
        });
    });

});