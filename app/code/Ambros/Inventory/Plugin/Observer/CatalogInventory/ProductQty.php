<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Observer\CatalogInventory;

/**
 * Catalog inventory product qty plugin
 */
class ProductQty extends \Ambros\Common\Plugin\Plugin
{
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
     * @param \Ambros\Inventory\Wrapper\Model\Quote\Quote\ItemFactory $quoteItemWrapperFactory
     * @return void
     */
    public function __construct(
        \Ambros\Common\DataObject\WrapperFactory $wrapperFactory,
        \Ambros\Inventory\Wrapper\Model\Quote\Quote\ItemFactory $quoteItemWrapperFactory
    )
    {
        parent::__construct($wrapperFactory);
        $this->quoteItemWrapperFactory = $quoteItemWrapperFactory;
    }
    
    /**
     * Around get product quantity
     * 
     * @param \Magento\CatalogInventory\Observer\ProductQty $subject
     * @param \Closure $proceed
     * @param \Magento\Quote\Model\Quote\Item[] $relatedItems
     * @return array
     */
    public function aroundGetProductQty(
        \Magento\CatalogInventory\Observer\ProductQty $subject,
        \Closure $proceed,
        $relatedItems
    )
    {
        $items = [];
        foreach ($relatedItems as $quoteItem) {
            $productId = $quoteItem->getProductId();
            if (!$productId) {
                continue;
            }
            $childQuoteItems = $quoteItem->getChildrenItems();
            if ($childQuoteItems) {
                foreach ($childQuoteItems as $childQuoteItem) {
                    $this->addQuoteItemToQtyArray($childQuoteItem, $items);
                }
            } else {
                $this->addQuoteItemToQtyArray($quoteItem, $items);
            }
        }
        return $items;
    }

    /**
     * Add quote item to qty array
     *
     * @param \Magento\Quote\Model\Quote\Item $quoteItem
     * @param array &$items
     * @return void
     */
    private function addQuoteItemToQtyArray(\Magento\Quote\Model\Quote\Item $quoteItem, &$items): void
    {
        $productId = $quoteItem->getProductId();
        if (!$productId) {
            return;
        }
        $sourceCode = (string) $this->quoteItemWrapperFactory->create($quoteItem)->getSourceCode();
        if (!$sourceCode) {
            return;
        }
        $qty = $quoteItem->getTotalQty();
        if (isset($items[$productId][$sourceCode])) {
            $items[$productId][$sourceCode] += $qty;
        } else {
            $items[$productId][$sourceCode] = $qty;
        }
    }
}