<?php

namespace Maras0830\PayNowSDK\Modules;

use Maras0830\PayNowSDK\Exceptions\EncryptException;
use Maras0830\PayNowSDK\Traits\Encrypt;

class CreditCardInfo
{
    use Encrypt;

    /**
     * @var string
     */
    public $secret_card_number;

    /**
     * CreditCardInfo constructor.
     * @param $key
     * @param $iv
     * @param $card_number
     * @param $valid_year
     * @param $valid_month
     * @param $safe_code
     * @throws EncryptException
     */
    public function __construct($key, $iv, $card_number, $valid_year, $valid_month, $safe_code)
    {
        $this->encrypt_key = $key;
        $this->encrypt_iv = $iv;

        $card_info = $card_number . $safe_code . $valid_month . '/' . $this->convertYearFormat($valid_year);

        $this->secret_card_number = $this->encrypt($card_info);
    }

    private function convertYearFormat($valid_year)
    {
        $year = filter_var($valid_year, FILTER_VALIDATE_INT);

        if ($year >= 2000) {
            return str_pad($year - 2000, 2, '0', STR_PAD_LEFT);
        } else {
            return str_pad($year, 2, '0', STR_PAD_LEFT);
        }
    }
}
