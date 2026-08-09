jQuery(function ($) {
    $('.favourite-toggle').on('click', function () {
        const $button = $(this);
        const productId = $button.data('product-id');
        const $heart = $button.find('.heart');

        $.post(favourites_ajax.ajax_url, {
            action: 'toggle_favourite',
            product_id: productId
        }).done(function (data) {
            const $productCard = $button.closest('.product-item');

            const $badge = $('.favourites-count-badge');
            if ($badge.length) {
                const count = Array.isArray(data.favourites) ? data.favourites.length : 0;
                $badge.text(count);
                $badge.toggleClass('hidden', count === 0);
            }

            if (data.status === 'added') {
                $heart.removeClass('text-gray-400').addClass('text-red-500');
            } else {
                $heart.removeClass('text-red-500').addClass('text-gray-400');

                // 💥 REMOVE FROM PAGE (only on favourites page)
                if ($productCard.length) {
                    $productCard.css('transition', 'opacity 0.3s ease').css('opacity', '0');

                    setTimeout(() => {
                        $productCard.remove();
                    }, 300);
                }
            }
        });
    });
});
