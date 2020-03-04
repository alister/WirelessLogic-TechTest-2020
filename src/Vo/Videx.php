<?php
declare(strict_types=1);

namespace App\Vo;

class Videx
{
    // in 7.4 - `public int $id;` etc.
    public $id;
    public $optionTitle;
    public $desc;
    public $price;
    public $discount;
    
    private function __construct(int $id, string $optionTitle, string $desc, string $priceText, string $discount)
    {
        $this->id = $id;
        $this->optionTitle = $optionTitle;
        $this->desc = $desc;
        $this->price = $this->parsePrice($priceText);
        $this->discount = $discount;
    }
    
    public static function createFromArray(array $package): self
    {
        return new self($package['id'], $package['optionTitle'], $package['desc'], $package['price'], $package['discount']);
    }

    /**
     * Return price in local (eg 6.00) 
     *
     * It's not very strong, and using a Money object would be a lot better long term, 
     * but it's quick and dirty for now. 
     * 
     * @return float
     */
    private function parsePrice(string $priceStr): float
    {
        $priceStr = trim($priceStr, '$£');

        return (float) filter_var($priceStr, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }
}
