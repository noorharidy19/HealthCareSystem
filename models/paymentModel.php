<?php

class CreditCardPayment {
    public function processPayment($data) {
        // Validate and process credit card payment
        if (!$this->validateCardNumber($data['cardNumber'])) {
            throw new Exception('Invalid card number');
        }

        if (!$this->validateExpiryDate($data['expiryDate'])) {
            throw new Exception('Invalid expiry date');
        }

        if (!$this->validateCVV($data['cvv'])) {
            throw new Exception('Invalid CVV');
        }

        // Process payment logic here
        return 'Credit card payment successful';
    }

    private function validateCardNumber($cardNumber) {
        return preg_match('/^[0-9]{16}$/', $cardNumber);
    }

    private function validateExpiryDate($expiryDate) {
        return preg_match('/^(0[1-9]|1[0-2])\/?([0-9]{2})$/', $expiryDate);
    }

    private function validateCVV($cvv) {
        return preg_match('/^[0-9]{3}$/', $cvv);
    }
}

class PayPalPayment {
    public function processPayment($data) {
        // Validate and process PayPal payment
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid PayPal email');
        }

        // Process payment logic here
        return 'PayPal payment successful';
    }
}

class PaymentFactory {
    public static function createPaymentMethod($type) {
        switch ($type) {
            case 'credit_card':
                return new CreditCardPayment();
            case 'paypal':
                return new PayPalPayment();
            default:
                throw new Exception('Invalid payment method');
        }
    }
}
?>