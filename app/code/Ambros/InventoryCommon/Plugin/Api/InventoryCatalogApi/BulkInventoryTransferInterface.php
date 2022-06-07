<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\InventoryCommon\Plugin\Api\InventoryCatalogApi;

/**
 * Bulk inventory transfer interface plugin
 */
class BulkInventoryTransferInterface
{
    /**
     * Transfer source item options
     * 
     * @var \Ambros\InventoryCommon\Model\ResourceModel\SourceItem\Option\Transfer
     */
    private $transferSourceItemOptions;

    /**
     * Unassign source item options
     * 
     * @var \Ambros\InventoryCommon\Model\ResourceModel\SourceItem\Option\Unassign
     */
    private $unassignSourceItemOptions;

    /**
     * Source item option configuration
     * 
     * @var \Ambros\InventoryCommon\Model\SourceItem\Option\Config
     */
    private $optionConfig;

    /**
     * Constructor
     * 
     * @param \Ambros\InventoryCommon\Model\ResourceModel\SourceItem\Option\Transfer $transferSourceItemOptions
     * @param \Ambros\InventoryCommon\Model\ResourceModel\SourceItem\Option\Unassign $unassignSourceItemOptions
     * @param \Ambros\InventoryCommon\Model\SourceItem\Option\Config $optionConfig
     * @return void
     */
    public function __construct(
        \Ambros\InventoryCommon\Model\ResourceModel\SourceItem\Option\Transfer $transferSourceItemOptions,
        \Ambros\InventoryCommon\Model\ResourceModel\SourceItem\Option\Unassign $unassignSourceItemOptions,
        \Ambros\InventoryCommon\Model\SourceItem\Option\Config $optionConfig
    )
    {
        $this->transferSourceItemOptions = $transferSourceItemOptions;
        $this->unassignSourceItemOptions = $unassignSourceItemOptions;
        $this->optionConfig = $optionConfig;
    }

    /**
     * Around execute
     * 
     * @param \Magento\InventoryCatalogApi\Api\BulkInventoryTransferInterface $subject
     * @param callable $proceed
     * @param array $skus
     * @param string $originSource
     * @param string $destinationSource
     * @param bool $unassignFromOrigin
     * @return bool
     */
    public function aroundExecute(
        \Magento\InventoryCatalogApi\Api\BulkInventoryTransferInterface $subject,
        callable $proceed,
        array $skus,
        string $originSource,
        string $destinationSource,
        bool $unassignFromOrigin
    ): bool
    {
        if ($this->optionConfig->isEnabled()) {
            $this->transferSourceItemOptions->execute($skus, $originSource, $destinationSource);
            $result = $proceed($skus, $originSource, $destinationSource, $unassignFromOrigin);
            if ($unassignFromOrigin) {
                $this->unassignSourceItemOptions->execute($skus, [$originSource]);
            }
            return $result;
        } else {
            return $proceed($skus, $originSource, $destinationSource, $unassignFromOrigin);
        }
    }
}