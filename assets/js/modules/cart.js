'use strict';

let addToCartButtons, cartItemCountInputs;

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
                return(response.text())
            })
            .then((body) => {
                document.getElementById('header-cart').innerHTML = body;
            })

    });
});

cartItemCountInputs = document.querySelectorAll('.js-cart-item-count');

//cartTable = document.getElementById('cartTable');

// if (cartTable) {
//     cartTable.addEventListener('input', (event) =>
//         if (!event.target.classList.contains('js-cart-item-count')) {
//             return;
//         }
//     )
// }

cartItemCountInputs.forEach((input) => {
    input.addEventListener('input', (event) => {
        let formData = new FormData();

        formData.set('count', input.value);

        fetch(input.dataset.url, {
            method: 'post',
            body: formData
        })
            .then((responce) => {
                return responce.text();
            })
            .then((body) => {
                document.getElementById('cartTable').innerHTML = body;
            });
    })
})