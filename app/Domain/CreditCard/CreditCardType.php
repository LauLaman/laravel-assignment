<?php

declare(strict_types=1);

namespace App\Domain\CreditCard;

use Werkspot\Enum\AbstractEnum;

/**
 * @method static self visa()
 * @method bool isVisa()
 * @method static self discoverCard()
 * @method bool isDiscoverCard()
 * @method static self mastercard()
 * @method bool isMastercard()
 * @method static self americanExpress()
 * @method bool isAmericanExpress()
 */
class CreditCardType extends AbstractEnum
{
    private const VISA = 'Visa';
    private const DISCOVER_CARD = 'Discover Card';
    private const MASTERCARD = 'MasterCard';
    private const AMERICAN_EXPRESS = 'American Express';
}
