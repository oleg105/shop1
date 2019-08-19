'use strict';

window.addEventListener('load', () => {
    let container, amountElement;

    container = document.getElementsByClassName('js-update-amount').item(0).closest('.sonata-ba-field-inline-table');
    amountElement = document.querySelector('.js-amount');

    if (container) {
        container.addEventListener('input', (event) => {
            if (event.target.classList.contains('js-update-amount')) {
                updateAmount;
            }

        $(container).on('change', (event) => {
            if (event.target.name.indexof('[product]')>0) {
                updatePrice();
            }
        });

        })
    }

    function updateAmount() {
        let amount = 0;
        let rows = container.querySelectorAll('.sonata-ba-tbody tr');

        rows.forEach((row) => {
            let priceElement = row.querySelector('[name*=price]');
            let countElement = row.querySelector('[name*=count]');

            amount += priceElement.value * countElement.value;
        });

        amountElement.value = amount;
    }

    function updatePrice(select) {
        let option = select.selectedOptions[0];
        let row = select.closest('tr');
        let priceElement = row.querySelector('[name*=price]');

        priceElement.value = option.dataset.price;
        updateAmount();
    }
});
