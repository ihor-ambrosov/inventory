<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Wrapper\Model\Sales\Order;

/**
 * Order item wrapper factory 
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
     * @param \Magento\Sales\Api\Data\OrderItemInterface $orderItem
     * @return \Ambros\Inventory\Wrapper\Model\Sales\Order\Item
     */
    public function create(
        \Magento\Sales\Api\Data\OrderItemInterface $orderItem
    ): \Ambros\Inventory\Wrapper\Model\Sales\Order\Item
    {
        return $this->wrapperFactory->create(
            $orderItem,
            \Ambros\Inventory\Wrapper\Model\Sales\Order\Item::class
        );
    }
}