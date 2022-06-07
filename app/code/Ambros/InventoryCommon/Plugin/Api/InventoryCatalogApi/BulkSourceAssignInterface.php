<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\InventoryCommon\Plugin\Api\InventoryCatalogApi;

/**
 * Bulk source assign interface
 */
class BulkSourceAssignInterface
{
    /**
     * Assign source item options
     * 
     * @var \Ambros\InventoryCommon\Model\ResourceModel\SourceItem\Option\Assign
     */
    private $assignSourceItemOptions;

    /**
     * Source item option configuration
     * 
     * @var \Ambros\InventoryCommon\Model\SourceItem\Option\Config
     */
    private $optionConfig;

    /**
     * Construct
     * 
     * @param \Ambros\InventoryCommon\Model\ResourceModel\SourceItem\Option\Assign $assignSourceItemOptions
     * @param \Ambros\InventoryCommon\Model\SourceItem\Option\Config $optionConfig
     * @return void
     */
    public function __construct(
        \Ambros\InventoryCommon\Model\ResourceModel\SourceItem\Option\Assign $assignSourceItemOptions,
        \Ambros\InventoryCommon\Model\SourceItem\Option\Config $optionConfig
    )
    {
        $this->assignSourceItemOptions = $assignSourceItemOptions;
        $this->optionConfig = $optionConfig;
    }

    /**
     * After execute
     *
     * @param \Magento\InventoryCatalogApi\Api\BulkSourceAssignInterface $subject
     * @param int $result
     * @param array $skus
     * @param array $sources
     * @return int
     */
    public function afterExecute(
        \Magento\InventoryCatalogApi\Api\BulkSourceAssignInterface $subject,
        int $result,
        array $skus,
        array $sources
    ): int
    {
        if ($this->optionConfig->isEnabled()) {
            $this->assignSourceItemOptions->execute($skus, $sources);
        }
        return $result;
    }
}