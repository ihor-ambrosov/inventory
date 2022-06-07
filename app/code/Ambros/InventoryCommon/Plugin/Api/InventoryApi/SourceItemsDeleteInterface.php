<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\InventoryCommon\Plugin\Api\InventoryApi;

/**
 * Source items delete interface
 */
class SourceItemsDeleteInterface
{
    /**
     * Delete source item options
     * 
     * @var \Ambros\InventoryCommon\Model\ResourceModel\SourceItem\Option\Delete
     */
    private $deleteOptions;

    /**
     * Source item option configuration
     * 
     * @var \Ambros\InventoryCommon\Model\SourceItem\Option\Config
     */
    private $optionConfig;

    /**
     * Constructor
     * 
     * @param \Ambros\InventoryCommon\Model\ResourceModel\SourceItem\Option\Delete $deleteOptions
     * @param \Ambros\InventoryCommon\Model\SourceItem\Option\Config $optionConfig
     * @return void
     */
    public function __construct(
        \Ambros\InventoryCommon\Model\ResourceModel\SourceItem\Option\Delete $deleteOptions,
        \Ambros\InventoryCommon\Model\SourceItem\Option\Config $optionConfig
    )
    {
        $this->deleteOptions = $deleteOptions;
        $this->optionConfig = $optionConfig;
    }

    /**
     * After execute
     *
     * @param \Magento\InventoryApi\Api\SourceItemsDeleteInterface $subject
     * @param void $result
     * @param array $sourceItems
     * @return void
     */
    public function afterExecute(
        \Magento\InventoryApi\Api\SourceItemsDeleteInterface $subject,
        $result,
        array $sourceItems
    )
    {
        if ($this->optionConfig->isEnabled()) {
            $this->deleteOptions->execute($sourceItems);
        }
    }
}