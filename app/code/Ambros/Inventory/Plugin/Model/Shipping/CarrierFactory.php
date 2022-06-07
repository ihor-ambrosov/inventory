<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Model\Shipping;

/**
 * Carrier factory plugin
 */
class CarrierFactory
{
    /**
     * Current source provider
     * 
     * @var \Ambros\InventoryCommon\Api\CurrentSourceProviderInterface
     */
    private $currentSourceProvider;

    /**
     * Constructor
     * 
     * @param \Ambros\InventoryCommon\Api\CurrentSourceProviderInterface $currentSourceProvider
     * @return void
     */
    public function __construct(
        \Ambros\InventoryCommon\Api\CurrentSourceProviderInterface $currentSourceProvider
    )
    {
        $this->currentSourceProvider = $currentSourceProvider;
    }

    /**
     * Before get
     * 
     * @param \Magento\Shipping\Model\CarrierFactory $subject
     * @param array|string $carrierCode
     * @return bool|\Magento\Shipping\Model\Carrier\AbstractCarrier
     */
    public function beforeGet(
        \Magento\Shipping\Model\CarrierFactory $subject,
        $carrierCode
    )
    {
        return [$this->getSourceCarrierCode($carrierCode)];
    }

    /**
     * Before create
     * 
     * @param \Magento\Shipping\Model\CarrierFactory $subject
     * @param array|string $carrierCode
     * @param int|null $storeId
     * @return bool|\Magento\Shipping\Model\Carrier\AbstractCarrier
     */
    public function beforeCreate(
        \Magento\Shipping\Model\CarrierFactory $subject,
        $carrierCode,
        $storeId = null
    )
    {
        return [$this->getSourceCarrierCode($carrierCode), $storeId];
    }

    /**
     * Before get if active
     * 
     * @param \Magento\Shipping\Model\CarrierFactory $subject
     * @param array|string $carrierCode
     * @return bool|\Magento\Shipping\Model\Carrier\AbstractCarrier
     */
    public function beforeGetIfActive(
        \Magento\Shipping\Model\CarrierFactory $subject,
        $carrierCode
    )
    {
        return [$this->getSourceCarrierCode($carrierCode)];
    }

    /**
     * Before create if active
     * 
     * @param \Magento\Shipping\Model\CarrierFactory $subject
     * @param array|string $carrierCode
     * @param int|null $storeId
     * @return bool|\Magento\Shipping\Model\Carrier\AbstractCarrier
     */
    public function beforeCreateIfActive(
        \Magento\Shipping\Model\CarrierFactory $subject,
        $carrierCode,
        $storeId = null
    )
    {
        return [$this->getSourceCarrierCode($carrierCode), $storeId];
    }

    /**
     * Get source carrier code
     * 
     * @param array|string $carrierCode
     * @return string
     */
    private function getSourceCarrierCode($carrierCode)
    {
        if (is_array($carrierCode)) {
            $sourceCode = (string) $this->currentSourceProvider->getSourceCode();
            if (!empty($sourceCode)) {
                $carrierCode = !empty($carrierCode[$sourceCode]) ? $carrierCode[$sourceCode] : null;
            } else {
                $carrierCode = current($carrierCode);
            }
        }
        return $carrierCode;
    }
}