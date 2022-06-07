<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Model\CatalogInventory\Quote\Item\QuantityValidator\Initializer;

/**
 * Quote item quantity validator option initializer plugin
 */
class Option extends \Ambros\Common\Plugin\Plugin
{
    /**
     * Quote item qty list
     * 
     * @var \Ambros\Inventory\Model\CatalogInventory\Quote\Item\QuantityValidator\QuoteItemQtyList
     */
    private $quoteItemQtyList;
    
    /**
     * Stock state
     * 
     * @var \Ambros\Inventory\Api\CatalogInventory\StockStateInterface
     */
    private $stockState;
    
    /**
     * Quote item wrapper factory
     * 
     * @var \Ambros\Inventory\Wrapper\Model\Quote\Quote\ItemFactory
     */
    private $quoteItemWrapperFactory;

    /**
     * Constructor
     * 
     * @param \Ambros\Common\DataObject\WrapperFactory $wrapperFactory
     * @param \Ambros\Inventory\Model\CatalogInventory\Quote\Item\QuantityValidator\QuoteItemQtyList $quoteItemQtyList
     * @param \Ambros\Inventory\Api\CatalogInventory\StockStateInterface $stockState
     * @param \Ambros\Inventory\Wrapper\Model\Quote\Quote\ItemFactory $quoteItemWrapperFactory
     * @return void
     */
    public function __construct(
        \Ambros\Common\DataObject\WrapperFactory $wrapperFactory,
        \Ambros\Inventory\Model\CatalogInventory\Quote\Item\QuantityValidator\QuoteItemQtyList $quoteItemQtyList,
        \Ambros\Inventory\Api\CatalogInventory\StockStateInterface $stockState,
        \Ambros\Inventory\Wrapper\Model\Quote\Quote\ItemFactory $quoteItemWrapperFactory
    )
    {
        parent::__construct($wrapperFactory);
        $this->quoteItemQtyList = $quoteItemQtyList;
        $this->stockState = $stockState;
        $this->quoteItemWrapperFactory = $quoteItemWrapperFactory;
    }

    /**
     * Around initialize
     * 
     * @param \Magento\CatalogInventory\Model\Quote\Item\QuantityValidator\Initializer\Option $subject
     * @param \Closure $proceed
     * @param \Magento\Quote\Model\Quote\Item\Option $option
     * @param \Magento\Quote\Model\Quote\Item $quoteItem
     * @param int $qty
     * @return \Magento\Framework\DataObject
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function aroundInitialize(
        \Magento\CatalogInventory\Model\Quote\Item\QuantityValidator\Initializer\Option $subject,
        \Closure $proceed,
        \Magento\Quote\Model\Quote\Item\Option $option,
        \Magento\Quote\Model\Quote\Item $quoteItem,
        $qty
    )
    {
        $this->setSubject($subject);
        $stockItem = $subject->getStockItem($option, $quoteItem);
        $this->prepareStockItem($stockItem, $option);
        $checkQtyResult = $this->checkOptionQty($option, $quoteItem, $qty);
        $this->releaseStockItem($stockItem);
        $this->updateOption($option, $quoteItem, $checkQtyResult, $qty);
        return $checkQtyResult;
    }

    /**
     * Prepare stock item
     * 
     * @param \Magento\CatalogInventory\Api\Data\StockItemInterface $stockItem
     * @param \Magento\Quote\Model\Quote\Item\Option $option
     * @return void
     */
    private function prepareStockItem(\Magento\CatalogInventory\Api\Data\StockItemInterface $stockItem, \Magento\Quote\Model\Quote\Item\Option $option): void
    {
        $stockItem->setProductName($option->getProduct()->getName());
    }
    
    /**
     * Release stock item
     * 
     * @param \Magento\CatalogInventory\Api\Data\StockItemInterface $stockItem
     * @return void
     */
    private function releaseStockItem(\Magento\CatalogInventory\Api\Data\StockItemInterface $stockItem): void
    {
        $stockItem->unsIsChildItem();
    }
    
    /**
     * Check option qty
     * 
     * @param \Magento\Quote\Model\Quote\Item\Option $option
     * @param \Magento\Quote\Model\Quote\Item $quoteItem
     * @param float $qty
     * @return \Magento\Framework\DataObject
     */
    private function checkOptionQty(
        \Magento\Quote\Model\Quote\Item\Option $option,
        \Magento\Quote\Model\Quote\Item $quoteItem,
        $qty
    )
    {
        $sourceCode = (string) $this->quoteItemWrapperFactory->create($quoteItem)->getSourceCode();
        $product = $option->getProduct();
        $productId = $product->getId();
        $store = $product->getStore();
        $optionValue = $option->getValue();
        $qtyToAdd = $quoteItem->getQtyToAdd();
        $qtyForCheck = $this->quoteItemQtyList->getSourceQty(
            $productId,
            $sourceCode,
            $quoteItem->getId(),
            $quoteItem->getQuoteId(),
            ($qtyToAdd ? $qtyToAdd : $qty) * $optionValue
        );
        return $this->stockState->checkQuoteItemSourceQty(
            $productId,
            $sourceCode,
            $qty * $optionValue,
            $qtyForCheck,
            $optionValue,
            $store->getWebsiteId()
        );
    }
    
    /**
     * Update option
     * 
     * @param \Magento\Quote\Model\Quote\Item\Option $option
     * @param \Magento\Quote\Model\Quote\Item $quoteItem
     * @param \Magento\Framework\DataObject $checkQtyResult
     * @param int $qty
     * @return void
     */
    private function updateOption(
        \Magento\Quote\Model\Quote\Item\Option $option,
        \Magento\Quote\Model\Quote\Item $quoteItem,
        \Magento\Framework\DataObject $checkQtyResult,
        $qty
    ): void
    {
        $isQtyDecimal = $checkQtyResult->getItemIsQtyDecimal();
        if ($isQtyDecimal !== null) {
            $option->setIsQtyDecimal($isQtyDecimal);
        }
        if ($checkQtyResult->getHasQtyOptionUpdate()) {
            $origQty = $checkQtyResult->getOrigQty();
            $option->setHasQtyOptionUpdate(true);
            $quoteItem->updateQtyOption($option, $origQty);
            $option->setValue($origQty);
            $quoteItem->setData('qty', (int) $qty);
        }
        $message = $checkQtyResult->getMessage();
        if ($message !== null) {
            $option->setMessage($message);
            $quoteItem->setMessage($message);
        }
        $backorders = $checkQtyResult->getItemBackorders();
        if ($backorders !== null) {
            $option->setBackorders($backorders);
        }
        $option->setStockStateResult($checkQtyResult);
    }
}