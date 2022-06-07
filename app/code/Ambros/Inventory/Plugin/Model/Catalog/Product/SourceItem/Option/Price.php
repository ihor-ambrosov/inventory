<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Model\Catalog\Product\SourceItem\Option;

/**
 * Product source item price option plugin
 */
class Price extends \Ambros\InventoryCommon\Plugin\Model\Catalog\Product\SourceItem\Option
{
    /**
     * Constructor
     * 
     * @param \Ambros\Inventory\Model\Inventory\SourceItem\Option\Price\Config $optionConfig
     * @param \Ambros\Inventory\Model\Inventory\SourceItem\Option\Price\Get $getOptions
     * @param \Ambros\Inventory\Model\Inventory\SourceItem\Option\Price\Meta $optionMeta
     * @param \Ambros\InventoryCommon\Model\GetCurrentSources $getCurrentSources
     * @param \Magento\InventoryConfigurationApi\Model\IsSourceItemManagementAllowedForProductTypeInterface $isSourceItemManagementAllowedForProductType
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @return void
     */
    public function __construct(
        \Ambros\Inventory\Model\Inventory\SourceItem\Option\Price\Config $optionConfig,
        \Ambros\Inventory\Model\Inventory\SourceItem\Option\Price\Get $getOptions,
        \Ambros\Inventory\Model\Inventory\SourceItem\Option\Price\Meta $optionMeta,
        \Ambros\InventoryCommon\Model\GetCurrentSources $getCurrentSources,
        \Magento\InventoryConfigurationApi\Model\IsSourceItemManagementAllowedForProductTypeInterface $isSourceItemManagementAllowedForProductType,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    )
    {
        parent::__construct(
            $optionConfig,
            $getOptions,
            $optionMeta,
            $getCurrentSources,
            $isSourceItemManagementAllowedForProductType,
            $storeManager
        );
    }
}