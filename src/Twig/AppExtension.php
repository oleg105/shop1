<?php


namespace App\Twig;


class AppExtension extends AbstractExtension
{
    public function getFilters() {
        return [
            new TwigFilter('money', [$this, 'formatMoney']),
        ];
    }

    public function formatMoney($value)
    {
        return twig_localized_currency_filter($value / 100, 'UAH');
    }
}