<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Indianic\FortoxFinance\Model;
/**
 * Cash on delivery payment method model
 *
 * @method \Magento\Quote\Api\Data\PaymentMethodExtensionInterface getExtensionAttributes()
 *
 * @api
 * @since 100.0.2
 */
class FortoxFinance extends \Magento\Payment\Model\Method\AbstractMethod
{
    /*
     * Payment method code
     *
     * @var string
     */
    protected $_code = 'fortoxfinance';

    /**
     * @var string
     */
    protected $_formBlockType = \Indianic\FortoxFinance\Block\Form\FortoxFinance::class;

    /**
     * @var string
     */
    protected $_infoBlockType = \Indianic\FortoxFinance\Block\Info\FortoxFinance::class;

    /**
     * Assign data to info model instance
     *
     * @param \Magento\Framework\DataObject|mixed $data
     * @return $this
     * @throws LocalizedException
     */
    public function assignData(\Magento\Framework\DataObject $data)
    {
        $this->getInfoInstance()->setPoNumber($data->getPoNumber());
        return $this;
    }

    /**
     * Validate payment method information object
     *
     * @return $this
     * @throws LocalizedException
     * @api
     */
    // public function validate()
    // {
    //     parent::validate();

    //     if (empty($this->getInfoInstance()->getPoNumber())) {
    //         throw new \Magento\Framework\Exception\LocalizedException(__('Purchase order number is a required field.'));
    //     }

    //     return $this;
    // }
}