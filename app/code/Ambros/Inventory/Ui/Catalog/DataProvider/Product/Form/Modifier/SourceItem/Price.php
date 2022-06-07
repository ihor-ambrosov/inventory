<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Ui\Catalog\DataProvider\Product\Form\Modifier\SourceItem;

/**
 * Source item price product form modifier
 */
class Price extends \Ambros\InventoryCommon\Ui\DataProvider\Product\Form\Modifier\SourceItem\Option
{
    /**
     * Locale currency
     * 
     * @var \Magento\Framework\Locale\CurrencyInterface
     */
    private $localeCurrency;

    /**
     * Constructor
     * 
     * @param \Ambros\Common\Ui\DataProvider\Modifier\Meta $meta
     * @param \Ambros\Inventory\Model\Inventory\SourceItem\Option\Price\Get $getOptions
     * @param \Ambros\Inventory\Model\Inventory\SourceItem\Option\Price\Meta $optionMeta
     * @param \Ambros\Inventory\Model\Inventory\SourceItem\Option\Price\Config $optionConfig
     * @param \Magento\CatalogInventory\Api\StockConfigurationInterface $stockConfiguration
     * @param \Magento\Catalog\Model\Locator\LocatorInterface $locator
     * @param \Magento\Framework\Stdlib\ArrayManager $arrayManager
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\InventoryCatalogApi\Model\IsSingleSourceModeInterface $isSingleSourceMode
     * @param \Magento\InventoryConfigurationApi\Model\IsSourceItemManagementAllowedForProductTypeInterface $isSourceItemManagementAllowedForProductType
     * @param \Magento\Framework\Locale\CurrencyInterface $localeCurrency
     * @param int $sortOrder
     * @return void
     */
    public function __construct(
        \Ambros\Common\Ui\DataProvider\Modifier\Meta $meta,
        \Ambros\Inventory\Model\Inventory\SourceItem\Option\Price\Get $getOptions,
        \Ambros\Inventory\Model\Inventory\SourceItem\Option\Price\Meta $optionMeta,
        \Ambros\Inventory\Model\Inventory\SourceItem\Option\Price\Config $optionConfig,
        \Magento\CatalogInventory\Api\StockConfigurationInterface $stockConfiguration,
        \Magento\Catalog\Model\Locator\LocatorInterface $locator,
        \Magento\Framework\Stdlib\ArrayManager $arrayManager,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\InventoryCatalogApi\Model\IsSingleSourceModeInterface $isSingleSourceMode,
        \Magento\InventoryConfigurationApi\Model\IsSourceItemManagementAllowedForProductTypeInterface $isSourceItemManagementAllowedForProductType,
        \Magento\Framework\Locale\CurrencyInterface $localeCurrency,
        int $sortOrder = 53
    )
    {
        parent::__construct(
            $meta,
            $getOptions,
            $optionMeta,
            $optionConfig,
            $stockConfiguration,
            $locator,
            $arrayManager,
            $storeManager,
            $isSingleSourceMode,
            $isSourceItemManagementAllowedForProductType,
            $sortOrder,
            false
        );
        $this->localeCurrency = $localeCurrency;
    }
    
    /**
     * Get default option value
     * 
     * @return string|null
     */
    protected function getDefaultOptionValue(): ?string
    {
        return $this->formatValue((string) $this->locator->getProduct()->getPrice());
    }
    
    /**
     * Format value
     * 
     * @param string $value
     * @return string
     */
    protected function formatValue(string $value): string
    {
        return (string) $this->localeCurrency->getCurrency($this->storeManager->getStore()->getBaseCurrencyCode())
            ->toCurrency((float) $value, ['display' => \Magento\Framework\Currency::NO_SYMBOL]);
    }
}