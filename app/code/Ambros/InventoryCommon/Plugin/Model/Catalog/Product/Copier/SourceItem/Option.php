<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\InventoryCommon\Plugin\Model\Catalog\Product\Copier\SourceItem;

/**
 * Product copier source item option plugin
 */
class Option
{
    /**
     * Get source item options
     * 
     * @var \Ambros\InventoryCommon\Api\SourceItem\Option\GetInterface
     */
    private $getOptions;

    /**
     * Save source item options
     * 
     * @var \Ambros\InventoryCommon\Api\SourceItem\Option\SaveInterface
     */
    private $saveOptions;

    /**
     * Source item option configuration
     * 
     * @var \Ambros\InventoryCommon\Model\SourceItem\Option\Config
     */
    private $optionConfig;

    /**
     * Constructor
     * 
     * @param \Ambros\InventoryCommon\Api\SourceItem\Option\GetInterface $getOptions
     * @param \Ambros\InventoryCommon\Api\SourceItem\Option\SaveInterface $saveOptions
     * @param \Ambros\InventoryCommon\Model\SourceItem\Option\Config $optionConfig
     * @return void
     */
    public function __construct(
        \Ambros\InventoryCommon\Api\SourceItem\Option\GetInterface $getOptions,
        \Ambros\InventoryCommon\Api\SourceItem\Option\SaveInterface $saveOptions,
        \Ambros\InventoryCommon\Model\SourceItem\Option\Config $optionConfig
    )
    {
        $this->getOptions = $getOptions;
        $this->saveOptions = $saveOptions;
        $this->optionConfig = $optionConfig;
    }

    /**
     * After copy
     *
     * @param \Magento\Catalog\Model\Product\Copier $subject
     * @param \Magento\Catalog\Model\Product $result
     * @param \Magento\Catalog\Model\Product $product
     * @return \Magento\Catalog\Model\Product $result
     */
    public function afterCopy(
        \Magento\Catalog\Model\Product\Copier $subject,
        \Magento\Catalog\Model\Product $result,
        \Magento\Catalog\Model\Product $product
    )
    {
        if (!$this->optionConfig->isEnabled()) {
            return $result;
        }
        $this->copyOptions($product->getSku(), $result->getSku());
        return $result;
    }

    /**
     * Copy options
     *
     * @param string $origSku
     * @param string $sku
     * @return $this
     */
    private function copyOptions(string $origSku, string $sku)
    {
        $options = $this->getOptions->execute([$origSku])[$origSku] ?? [];
        foreach ($options as $option) {
            $option->setSku($sku);
        }
        if ($options) {
            $this->saveOptions->execute($options);
        }
        return $this;
    }
}