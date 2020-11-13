<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Indianic\FortoxFinance\Block\Info;

class FortoxFinance extends \Magento\Payment\Block\Info
{
    /**
     * @var string
     */
    protected $_template = 'Indianic_FortoxFinance::info/fortoxfinance.phtml';

    /**
     * @return string
     */
    public function toPdf()
    {
        $this->setTemplate('Indianic_FortoxFinance::info/pdf/fortoxfinance.phtml');
        return $this->toHtml();
    }
}