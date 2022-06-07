<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Model\Catalog\ResourceModel\Product\SourceItem\Option;

/**
 * Product resource source item tax class options plugin
 */
class TaxClass extends \Ambros\InventoryCommon\Plugin\Model\Catalog\ResourceModel\Product\SourceItem\Option
{
    /**
     * Constructor
     * 
     * @param \Ambros\Inventory\Api\Inventory\SourceItem\Option\TaxClass\GetInterface $getOptions
     * @param \Ambros\Inventory\Api\Inventory\SourceItem\Option\TaxClass\SaveInterface $saveOptions
     * @param \Ambros\Inventory\Model\Inventory\SourceItem\Option\TaxClass\Config $optionConfig
     * @param \Ambros\Inventory\Model\Inventory\SourceItem\Option\TaxClass\Meta $optionMeta
     * @param \Ambros\Inventory\Model\Inventory\SourceItem\Option\TaxClass\Processor $optionsProcessor
     * @param \Magento\InventoryCatalogApi\Api\DefaultSourceProviderInterface $defaultSourceProvider
     * @param \Magento\InventoryConfigurationApi\Model\IsSourceItemManagementAllowedForProductTypeInterface $isSourceItemManagementAllowedForProductType
     * @param \Psr\Log\LoggerInterface $logger
     * @return void
     */
    public function __construct(
        \Ambros\Inventory\Api\Inventory\SourceItem\Option\TaxClass\GetInterface $getOptions,
        \Ambros\Inventory\Api\Inventory\SourceItem\Option\TaxClass\SaveInterface $saveOptions,
        \Ambros\Inventory\Model\Inventory\SourceItem\Option\TaxClass\Config $optionConfig,
        \Ambros\Inventory\Model\Inventory\SourceItem\Option\TaxClass\Meta $optionMeta,
        \Ambros\Inventory\Model\Inventory\SourceItem\Option\TaxClass\Processor $optionsProcessor,
        \Magento\InventoryCatalogApi\Api\DefaultSourceProviderInterface $defaultSourceProvider,
        \Magento\InventoryConfigurationApi\Model\IsSourceItemManagementAllowedForProductTypeInterface $isSourceItemManagementAllowedForProductType,
        \Psr\Log\LoggerInterface $logger
    )
    {
        parent::__construct(
            $getOptions,
            $saveOptions,
            $optionConfig,
            $optionMeta,
            $optionsProcessor,
            $defaultSourceProvider,
            $isSourceItemManagementAllowedForProductType,
            $logger
        );
    }
}