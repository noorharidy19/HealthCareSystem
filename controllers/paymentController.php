<?php

class PaymentController {
    public function processPayment() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $paymentType = $_POST['paymentType'];
            $paymentData = $_POST;

            try {
                $paymentMethod = PaymentFactory::createPaymentMethod($paymentType);
                $result = $paymentMethod->processPayment($paymentData);
                echo $result;
            } catch (Exception $e) {
                echo 'Error: ' . $e->getMessage();
            }
        }
    }
}
?>