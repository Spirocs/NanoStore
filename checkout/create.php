<?php
session_start();

require_once '../vendor/autoload.php';
require_once 'secrets.php';

$stripe = new \Stripe\StripeClient($stripeSecretKey);

header('Content-Type: application/json');

try {
    // Create a PaymentIntent with amount and currency
    $paymentIntent = $stripe->paymentIntents->create([
        'amount' => $_SESSION['value'],
        'currency' => 'eur',
        'payment_method_types' => ['sepa_debit'],
    ]);

    

    $output = [
        'clientSecret' => $paymentIntent->client_secret,
    ];

    echo json_encode($output);
} catch (Error $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
