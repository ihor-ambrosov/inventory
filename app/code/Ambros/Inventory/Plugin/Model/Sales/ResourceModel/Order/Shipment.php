<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Model\Sales\ResourceModel\Order;

/**
 * Order shipment resource plugin
 */
class Shipment
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
     * After load
     * 
     * @param \Magento\Sales\Model\ResourceModel\Order\Shipment $subject
     * @param \Magento\Sales\Model\ResourceModel\Order\Shipment $result
     * @param \Magento\Framework\Model\AbstractModel $shipment
     * @return \Magento\Sales\Model\ResourceModel\Order\Shipment
     */
    public function afterLoad(
        \Magento\Sales\Model\ResourceModel\Order\Shipment $subject,
        \Magento\Sales\Model\ResourceModel\Order\Shipment $result,
        \Magento\Framework\Model\AbstractModel $shipment
    )
    {
        $shipmentExtension = $shipment->getExtensionAttributes();
        if (!empty($shipmentExtension)) {
            $sourceCode = $shipmentExtension->getSourceCode();
        } else {
            $sourceCode = null;
        }
        $this->currentSourceProvider->setSourceCode($sourceCode);
        return $result;
    }
}