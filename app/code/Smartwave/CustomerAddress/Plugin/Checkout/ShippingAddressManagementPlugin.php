<?php
namespace Smartwave\CustomerAddress\Plugin\Checkout;

use Psr\Log\LoggerInterface;
use Magento\Quote\Model\ShippingAddressManagement;
use Magento\Quote\Api\Data\AddressInterface;

class ShippingAddressManagementPlugin
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

    /**
     * @param ShippingAddressManagement $subject
     * @param $cartId
     * @param AddressInterface $address
     */
    public function beforeAssign(
        ShippingAddressManagement $subject,
        $cartId,
        AddressInterface $address
    ) {
        $extAttributes = $address->getExtensionAttributes();
        try {
            if ( !empty($extAttributes) && method_exists($extAttributes, 'getNeighborhood') ) {
                $address->setNeighborhood($extAttributes->getNeighborhood());
                $address->setExteriorNumber($extAttributes->getExteriorNumber());
                $address->setInteriorNumber($extAttributes->getInteriorNumber());
                $address->setBetweenStreet1($extAttributes->getBetweenStreet1());
                $address->setBetweenStreet2($extAttributes->getBetweenStreet2());
            }
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }
}