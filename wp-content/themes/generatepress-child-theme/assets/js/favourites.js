// wrap in dom ready
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.favourite-toggle').forEach(button => {

        button.addEventListener('click', function () {
            const productId = this.dataset.productId;
            const heart = this.querySelector('.heart');

            fetch(favourites_ajax.ajax_url, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `action=toggle_favourite&product_id=${productId}`
            })
                .then(res => res.json())
                .then(data => {
                    const productCard = this.closest('.product-item');

                    if (data.status === 'added') {
                        heart.classList.remove('text-gray-400');
                        heart.classList.add('text-red-500');

                    } else {
                        heart.classList.remove('text-red-500');
                        heart.classList.add('text-gray-400');

                        // 💥 REMOVE FROM PAGE (only on favourites page)
                        if (productCard) {
                            productCard.style.transition = 'opacity 0.3s ease';
                            productCard.style.opacity = '0';

                            setTimeout(() => {
                                productCard.remove();
                            }, 300);
                        }
                    }


                });
        });

    });
});