<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

/**
 * Class CreditCard
 * @package Source\Models
 */

class CreditCard extends DataLayer
{
  /**
   * CreditCard constructor.
   */
  public function __construct()
  {
    parent::__construct("credit_cards", ["user", "hash", "brand", "last_digits"]);
  }
}
