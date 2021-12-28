<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License (MIT)
 * that is bundled with this package in the file LICENSE.md.
 *
 * @author mElements S.A.
 * @copyright mElements S.A.
 * @license   MIT License
 */

use Paynow\Model\Payment\Status;

class PaynowStatusModuleFrontController extends PaynowFrontController
{
    public function initContent()
    {
        parent::initContent();
        $this->ajax = true;
    }

    public function displayAjax()
    {
        if (Tools::getValue('order_reference') && $this->isTokenValid()) {
            $payment  = PaynowPaymentData::findLastByOrderReference(Tools::getValue('order_reference'));
            $payment_status = $payment->status;
            if (Status::STATUS_CONFIRMED !== $payment->status) {
                $payment_status = $this->getPaymentStatus($payment->id_payment);
                $this->updateOrderState(
                    $payment->id_order,
                    $payment->id_payment,
                    $payment->id_cart,
                    $payment->order_reference,
                    $payment->external_id,
                    $payment->status,
                    $payment_status
                );
            }
            $this->order   = new Order($payment->id_order);
            $current_state = $this->order->getCurrentStateFull($this->context->language->id);

            $response = [
                'order_status'   => $current_state['name'],
                'payment_status' => $payment_status
            ];

            if (Status::STATUS_PENDING !== $payment_status) {
                $response['redirect_url'] = PaynowLinkHelper::getContinueUrl(
                    $payment->id_cart,
                    $this->module->id,
                    $this->context->customer->secure_key,
                    $payment->id_order,
                    $payment->order_reference
                );
            }

            $this->ajaxRender(json_encode($response));
            exit;
        }
    }
}
