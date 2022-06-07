<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Wrapper\Model\Quote\Quote;

/**
 * Quote item wrapper factory
 */
class ItemFactory
{
    /**
     * Wrapper factory
     * 
     * @var \Ambros\Common\DataObject\WrapperFactory
     */
    private $wrapperFactory;

    /**
     * Constructor
     * 
     * @param \Ambros\Common\DataObject\WrapperFactory $wrapperFactory
     * @return void
     */
    public function __construct(\Ambros\Common\DataObject\WrapperFactory $wrapperFactory)
    {
        $this->wrapperFactory = $wrapperFactory;
    }

    /**
     * Create
     * 
     * @param \Magento\Quote\Api\Data\CartItemInterface $quoteItem
     * @return \Ambros\Inventory\Wrapper\Model\Quote\Quote\Item
     */
    public function create(
        \Magento\Quote\Api\Data\CartItemInterface $quoteItem
    ): \Ambros\Inventory\Wrapper\Model\Quote\Quote\Item
    {
        return $this->wrapperFactory->create(
            $quoteItem,
            \Ambros\Inventory\Wrapper\Model\Quote\Quote\Item::class
        );
    }
}