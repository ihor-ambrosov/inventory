<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Block\Catalog\Product;

/**
 * View product block plugin
 */
class View
{
    /**
     * Get current salable source items
     * 
     * @var \Ambros\Inventory\Model\InventorySales\GetCurrentSalableSourceItems
     */
    private $getCurrentSalableSourceItems;

    /**
     * Serializer
     * 
     * @var \Magento\Framework\Serialize\Serializer\Json
     */
    private $serializer;
    
    /**
     * Constructor
     * 
     * @param \Ambros\Inventory\Model\InventorySales\GetCurrentSalableSourceItems $getCurrentSalableSourceItems
     * @param \Magento\Framework\Serialize\Serializer\Json $serializer
     * @return void
     */
    public function __construct(
        \Ambros\Inventory\Model\InventorySales\GetCurrentSalableSourceItems $getCurrentSalableSourceItems,
        \Magento\Framework\Serialize\Serializer\Json $serializer
    )
    {
        $this->getCurrentSalableSourceItems = $getCurrentSalableSourceItems;
        $this->serializer = $serializer;
    }

    /**
     * After get JSON configuration
     * 
     * @param \Magento\Catalog\Block\Product\View $subject
     * @param string $result
     * @return string
     */
    public function afterGetJsonConfig(
        \Magento\Catalog\Block\Product\View $subject,
        $result
    )
    {
        $product = $subject->getProduct();
        $config = $this->serializer->unserialize($result);
        $sourcePrices = [];
        $initialSourceCode = $product->getSourceCode();
        $sourceCodes = array_keys($this->getCurrentSalableSourceItems->execute($product->getData(\Magento\Catalog\Api\Data\ProductInterface::SKU)));
        foreach ($sourceCodes as $sourceCode) {
            $this->setProductSourceCode($product, (string) $sourceCode);
            $priceInfo = $product->getPriceInfo();
            $regularPriceAmount = $priceInfo->getPrice('regular_price')->getAmount();
            $finalPriceAmount = $priceInfo->getPrice('final_price')->getAmount();
            $sourcePrices[$sourceCode] = [
                'oldPrice' => [
                    'amount' => $regularPriceAmount->getValue(),
                    'adjustments' => [],
                ],
                'basePrice' => [
                    'amount' => $finalPriceAmount->getBaseAmount(),
                    'adjustments' => [],
                ],
                'finalPrice' => [
                    'amount' => $finalPriceAmount->getValue(),
                    'adjustments' => [],
                ],
            ];
        }
        $this->setProductSourceCode($product, $initialSourceCode);
        $config['sourcePrices'] = $sourcePrices;
        return $this->serializer->serialize($config);
    }

    /**
     * Set product source code
     * 
     * @param \Magento\Catalog\Model\Product $product
     * @param string|null $sourceCode
     * @return void
     */
    private function setProductSourceCode(\Magento\Catalog\Model\Product $product, string $sourceCode = null): void
    {
        $product->setSourceCode($sourceCode);
        $product->reloadPriceInfo();
    }
}