<?php
namespace Smartwave\CustomerAddress\Plugin\Checkout;

use Psr\Log\LoggerInterface;

class CustomerAddressPlugin
{
    /**
     * @var LoggerInterface $logger
     */
    protected $logger;

    /**
     * ShippingAddressManagementPlugin constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    public function beforeExportCustomerAddress(
        \Magento\Quote\Model\Quote\Address $subject
    ) {
        $extensionAttributes = $subject->getExtensionAttributes();
        try {
            if ( !empty($extensionAttributes) ) {
                $extensionAttributes->setNeighborhood( $subject->getData('neighborhood') );
                $extensionAttributes->setExteriorNumber( $subject->getData('exterior_number') );
                $extensionAttributes->setInteriorNumber( $subject->getData('interior_number') );
                $extensionAttributes->setBetweenStreet1( $subject->getData('between_street1') );
                $extensionAttributes->setBetweenStreet2( $subject->getData('between_street2') );
            }
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }
}