<?php

use PagarMe\Client;
use Source\Models\CreditCard;
use Source\Models\User;
use Source\Support\Payment;

require __DIR__ . "/vendor/autoload.php";

$client = (new User())->findById(20);
$pagarme = new Client(PAGARME_API_KEY);

/** Criando o cartao dentro do BD */
$newCard = false;
if ($newCard) {
  $getCreditCard = $pagarme->cards()->create([
    'holder_name' => 'Matheus Zancanela',
    'number' => '5294357618171910',
    'expiration_date' => '0125',
    'cvv' => '800'
  ]);

  if (!$getCreditCard->valid) {
    echo "<h3>Cartao invalido!</h3>";
  } else {
    $createCreditCard = new CreditCard();
    $createCreditCard->user = $client->id;
    $createCreditCard->hash = $getCreditCard->id;
    $createCreditCard->brand = $getCreditCard->brand;
    $createCreditCard->last_digits = $getCreditCard->last_digits;
    $createCreditCard->save();
  }
}

/** Realizando transacao com o cartao */
$newTransaction = false;
if ($newTransaction) {
  $creditCard = (new CreditCard())->findById(1);
  $transaction = $pagarme->transactions()->create([
    "amount" => (55.80 * 100),
    "card_id" => $creditcard->hash,
    "metadata" => [
      "orderId" => 1555
    ]
  ]);

  var_dump($transaction);
}

$pay = new Payment();
$pay->createCard(
  "Matheus Zancanela",
  "5294357618171910",
  "0125",
  "800"
);
var_dump($pay->callback());
if ($pay->callback()->valid) {
  echo "<h1>Cartao Obtido!</h1>";

  $pay->withCard(
    "1250",
    (new CreditCard())->findById(1),
    1230.34,
    2
  );

  var_dump($pay->callback());
  if ($pay->callback()->status == "paid") {
    echo "<h2>Liberar pedido!</h2>";
  }
}
