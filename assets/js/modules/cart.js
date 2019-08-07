'use strict';

let addToCartButtons, cartTable;

addToCartButtons = document.querySelectorAll('.js-add-to-cart');

addToCartButtons.forEach((button) => {
    button.addEventListener('click', (event) => {
        event.preventDefault();

        fetch(button.href, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then((response) => {
                return response.text();
            })
            .then((body) => {
                document.getElementById('header-cart').innerHTML = body;
            })
    });
});

cartTable = document.getElementById('cartTable');

if (cartTable) {
    cartTable.addEventListener('input', (event) => {
        if (!event.target.classList.contains('js-cart-item-count')) {
            return;
        }

        let input = event.target;
        let formData = new FormData();

        formData.set('count', input.value);

        fetch(input.dataset.url, {
            method: 'post',
            body: formData
        })
            .then((response) => {
                return response.text();
            })
            .then((body) => {
                cartTable.innerHTML = body;
            });
    });

    cartTable.addEventListener('click', (event) => {
        let link = event.target.closest('.js-cart-remove-item');

        if (!link) {
            return;
        }

        event.preventDefault();

        fetch(link.href)
            .then((response) => {
                return response.text();
            })
            .then((body) => {
                cartTable.innerHTML = body;
            });
    })
}
