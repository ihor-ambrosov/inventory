<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Model\CatalogInventory\Quote\Item\QuantityValidator\Initializer;

/**
 * Quote item quantity validator stock item initializer plugin
 */
class StockItem extends \Ambros\Common\Plugin\Plugin
{
    /**
     * Stock state
     * 
     * @var \Ambros\Inventory\Api\CatalogInventory\StockStateInterface
     */
    private $stockState;

    /**
     * Quote item qty list
     * 
     * @var \Ambros\Inventory\Model\CatalogInventory\Quote\Item\QuantityValidator\QuoteItemQtyList
     */
    private $quoteItemQtyList;

    /**
     * Quote item wrapper factory
     * 
     * @var \Ambros\Inventory\Wrapper\Model\Quote\Quote\ItemFactory
     */
    private $quoteItemWrapperFactory;
    
    /**
     * Stock state provider
     * 
     * @var \Magento\CatalogInventory\Model\Spi\StockStateProviderInterface
     */
    private $stockStateProvider;
    
    /**
     * Type configuration
     * 
     * @var \Magento\Catalog\Model\ProductTypes\ConfigInterface
     */
    private $typeConfig;

    /**
     * Constructor
     * 
     * @param \Ambros\Common\DataObject\WrapperFactory $wrapperFactory
     * @param \Ambros\Inventory\Api\CatalogInventory\StockStateInterface $stockState
     * @param \Ambros\Inventory\Model\CatalogInventory\Quote\Item\QuantityValidator\QuoteItemQtyList $quoteItemQtyList
     * @param \Ambros\Inventory\Wrapper\Model\Quote\Quote\ItemFactory $quoteItemWrapperFactory
     * @param \Magento\CatalogInventory\Model\Spi\StockStateProviderInterface $stockStateProvider
     * @param \Magento\Catalog\Model\ProductTypes\ConfigInterface $typeConfig
     */
    public function __construct(
        \Ambros\Common\DataObject\WrapperFactory $wrapperFactory,
        \Ambros\Inventory\Api\CatalogInventory\StockStateInterface $stockState,
        \Ambros\Inventory\Model\CatalogInventory\Quote\Item\QuantityValidator\QuoteItemQtyList $quoteItemQtyList,
        \Ambros\Inventory\Wrapper\Model\Quote\Quote\ItemFactory $quoteItemWrapperFactory,
        \Magento\CatalogInventory\Model\Spi\StockStateProviderInterface $stockStateProvider,
        \Magento\Catalog\Model\ProductTypes\ConfigInterface $typeConfig
    )
    {
        parent::__construct($wrapperFactory);
        $this->stockState = $stockState;
        $this->quoteItemQtyList = $quoteItemQtyList;
        $this->quoteItemWrapperFactory = $quoteItemWrapperFactory;
        $this->stockStateProvider = $stockStateProvider;
        $this->typeConfig = $typeConfig;
    }

    /**
     * Around initialize
     * 
     * @param \Magento\CatalogInventory\Model\Quote\Item\QuantityValidator\Initializer\StockItem $subject
     * @param \Closure $proceed
     * @param \Magento\CatalogInventory\Api\Data\StockItemInterface $stockItem
     * @param \Magento\Quote\Model\Quote\Item $quoteItem
     * @param int $qty
     * @return \Magento\Framework\DataObject
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function aroundInitialize(
        \Magento\CatalogInventory\Model\Quote\Item\QuantityValidator\Initializer\StockItem $subject,
        \Closure $proceed,
        \Magento\CatalogInventory\Api\Data\StockItemInterface $stockItem,
        \Magento\Quote\Model\Quote\Item $quoteItem,
        $qty
    )
    {
        $this->setSubject($subject);
        $this->prepareStockItem($stockItem, $quoteItem);
        $checkQtyResult = $this->checkQuoteItemQty($stockItem, $quoteItem, $qty);
        $this->releaseStockItem($stockItem);
        $this->updateQuoteItem($quoteItem, $checkQtyResult);
        return $checkQtyResult;
    }

    /**
     * Prepare stock item
     * 
     * @param \Magento\CatalogInventory\Api\Data\StockItemInterface $stockItem
     * @param \Magento\Quote\Model\Quote\Item $quoteItem
     * @return void
     */
    private function prepareStockItem(\Magento\CatalogInventory\Api\Data\StockItemInterface $stockItem, \Magento\Quote\Model\Quote\Item $quoteItem): void
    {
        $product = $quoteItem->getProduct();
        $stockItem->setProductName($product->getName());
        $productTypeOption = $product->getCustomOption('product_type');
        if (empty($productTypeOption)) {
            return;
        }
        if ($this->typeConfig->isProductSet($productTypeOption->getValue())) {
            $stockItem->setIsChildItem(true);
        }
    }
    
    /**
     * Release stock item
     * 
     * @param \Magento\CatalogInventory\Api\Data\StockItemInterface $stockItem
     * @return void
     */
    private function releaseStockItem(\Magento\CatalogInventory\Api\Data\StockItemInterface $stockItem): void
    {
        if ($stockItem->hasIsChildItem()) {
            $stockItem->unsIsChildItem();
        }
    }
    
    /**
     * Check quote item qty
     * 
     * @param \Magento\CatalogInventory\Api\Data\StockItemInterface $stockItem
     * @param \Magento\Quote\Model\Quote\Item $quoteItem
     * @param float $qty
     * @return \Magento\Framework\DataObject
     */
    private function checkQuoteItemQty(
        \Magento\CatalogInventory\Api\Data\StockItemInterface $stockItem,
        \Magento\Quote\Model\Quote\Item $quoteItem,
        $qty
    )
    {
        $sourceCode = $this->quoteItemWrapperFactory->create($quoteItem)->getSourceCode();
        $product = $quoteItem->getProduct();
        $productId = $product->getId();
        $store = $product->getStore();
        $parentQuoteItem = $quoteItem->getParentItem();
        $qtyToAdd = $quoteItem->getQtyToAdd();
        $qtyForCheck = $this->quoteItemQtyList->getSourceQty(
            $productId,
            $sourceCode,
            $quoteItem->getId(),
            $quoteItem->getQuoteId(),
            $parentQuoteItem ? 0 : ($qtyToAdd ? $qtyToAdd : $qty)
        );
        $checkQtyResult = $this->stockState->checkQuoteItemSourceQty(
            $productId,
            $sourceCode,
            ($parentQuoteItem) ? $parentQuoteItem->getQty() * $qty : $qty,
            $qtyForCheck,
            $qty,
            $store->getWebsiteId()
        );
        if ($checkQtyResult->getHasError() === true && in_array($checkQtyResult->getErrorCode(), ['qty_available', 'out_stock'])) {
            $quoteItem->setHasError(true);
        }
        $checkQtyResult->setItemBackorders(
            $this->stockStateProvider->checkQuoteItemQty(
                    $stockItem,
                    ($parentQuoteItem) ? $parentQuoteItem->getQty() * $qty : $qty,
                    $qtyForCheck,
                    $qty
                )
                ->getItemBackorders()
        );
        return $checkQtyResult;
    }
    
    /**
     * Update quote item
     * 
     * @param \Magento\Quote\Model\Quote\Item $quoteItem
     * @param \Magento\Framework\DataObject $checkQtyResult
     * @return void
     */
    private function updateQuoteItem(\Magento\Quote\Model\Quote\Item $quoteItem, \Magento\Framework\DataObject $checkQtyResult): void
    {
        $parentQuoteItem = $quoteItem->getParentItem();
        $parentProduct = ($parentQuoteItem) ? $parentQuoteItem->getProduct() : null;
        $isQtyDecimal = $checkQtyResult->getItemIsQtyDecimal();
        if ($isQtyDecimal !== null) {
            $quoteItem->setIsQtyDecimal($isQtyDecimal);
            if ($parentQuoteItem) {
                $parentQuoteItem->setIsQtyDecimal($isQtyDecimal);
            }
        }
        if (
            $checkQtyResult->getHasQtyOptionUpdate() && 
            (!$parentQuoteItem || $parentProduct->getTypeInstance()->getForceChildItemQtyChanges($parentProduct))
        ) {
            $quoteItem->setData('qty', $checkQtyResult->getOrigQty());
        }
        $useOldQty = $checkQtyResult->getItemUseOldQty();
        if ($useOldQty !== null) {
            $quoteItem->setUseOldQty($useOldQty);
        }
        $message = $checkQtyResult->getMessage();
        if ($message !== null) {
            $quoteItem->setMessage($message);
        }
        $backorders = $checkQtyResult->getItemBackorders();
        if ($backorders !== null) {
            $quoteItem->setBackorders($backorders);
        }
        $quoteItem->setStockStateResult($checkQtyResult);
    }
}