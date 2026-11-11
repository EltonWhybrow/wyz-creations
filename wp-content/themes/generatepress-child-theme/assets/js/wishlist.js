jQuery(function ($) {
    $('.wishlist-toggle').on('click', function () {
        const $button = $(this);
        const productId = $button.data('product-id');
        const $heart = $button.find('.heart');

        $.post(wishlist_ajax.ajax_url, {
            action: 'toggle_wishlist',
            product_id: productId
        }).done(function (data) {
            const $productCard = $button.closest('.product-item');

            const $badge = $('.wishlist-count-badge');
            if ($badge.length) {
                const count = Array.isArray(data.wishlist) ? data.wishlist.length : 0;
                $badge.text(count);
                $badge.toggleClass('hidden', count === 0);
            }

            if (data.status === 'added') {
                $heart.removeClass('text-gray-400').addClass('text-red-500');
                $button.find('.wishlist-label').text('Remove from Wish List');
                $button.attr('aria-label', 'Remove from Wish List');
            } else {
                $heart.removeClass('text-red-500').addClass('text-gray-400');
                $button.find('.wishlist-label').text('Add to Wish List');
                $button.attr('aria-label', 'Add to Wish List');

                // Remove card from wish list page on removal
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
