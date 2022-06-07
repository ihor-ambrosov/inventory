<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Model\Checkout;

/**
 * Cart model plugin
 */
class Cart extends \Ambros\Common\Plugin\Plugin
{
    /**
     * Stock state
     * 
     * @var \Ambros\Inventory\Api\CatalogInventory\StockStateInterface
     */
    private $stockState;

    /**
     * Get legacy stock item
     * 
     * @var \Ambros\Inventory\Model\Inventory\GetLegacyStockItem
     */
    private $getLegacyStockItem;

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
     * @param \Ambros\Inventory\Api\CatalogInventory\StockStateInterface $stockState
     * @param \Ambros\Inventory\Model\Inventory\GetLegacyStockItem $getLegacyStockItem
     * @param \Ambros\Inventory\Wrapper\Model\Quote\Quote\ItemFactory $quoteItemWrapperFactory
     * @return void
     */
    public function __construct(
        \Ambros\Common\DataObject\WrapperFactory $wrapperFactory,
        \Ambros\Inventory\Api\CatalogInventory\StockStateInterface $stockState,
        \Ambros\Inventory\Model\Inventory\GetLegacyStockItem $getLegacyStockItem,
        \Ambros\Inventory\Wrapper\Model\Quote\Quote\ItemFactory $quoteItemWrapperFactory
    )
    {
        parent::__construct($wrapperFactory);
        $this->stockState = $stockState;
        $this->getLegacyStockItem = $getLegacyStockItem;
        $this->quoteItemWrapperFactory = $quoteItemWrapperFactory;
    }

    /**
     * Around suggest items qty
     * 
     * @param \Magento\Checkout\Model\Cart $subject
     * @param \Closure $proceed
     * @param array $data
     * @return array
     */
    public function aroundSuggestItemsQty(
        \Magento\Checkout\Model\Cart $subject,
        \Closure $proceed,
        $data
    )
    {
        $this->setSubject($subject);
        $quote = $subject->getQuote();
        foreach ($data as $itemId => $item) {
            if (!isset($item['qty'])) {
                continue;
            }
            $qty = (float) $item['qty'];
            if ($qty <= 0) {
                continue;
            }
            $quoteItem = $quote->getItemById($itemId);
            if (empty($quoteItem)) {
                continue;
            }
            $product = $quoteItem->getProduct();
            if (empty($product)) {
                continue;
            }
            $productId = $product->getId();
            $sourceCode = (string) $this->quoteItemWrapperFactory->create($quoteItem)->getSourceCode();
            $data[$itemId]['before_suggest_qty'] = $qty;
            $data[$itemId]['qty'] = $this->stockState->suggestSourceQty($productId, $sourceCode, $qty);
        }
        return $data;
    }

    /**
     * Get quantity request
     *
     * @param \Magento\Catalog\Model\Product $product
     * @param \Magento\Framework\DataObject|int|array $request
     * @return int|\Magento\Framework\DataObject
     */
    private function getQtyRequest($product, $request = 0)
    {
        $request = $this->invokeSubjectMethod('_getProductRequest', $request);
        $stockItem = $this->getLegacyStockItem->execute($product);
        $minSaleQty = $stockItem->getMinSaleQty();
        if ($minSaleQty && $minSaleQty > 0 && !$request->getQty()) {
            $request->setQty($minSaleQty);
        }
        return $request;
    }
}