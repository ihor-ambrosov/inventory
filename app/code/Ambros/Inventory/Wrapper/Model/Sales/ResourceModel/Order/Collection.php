<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Wrapper\Model\Sales\ResourceModel\Order;

/**
 * Order collection wrapper
 */
class Collection extends \Ambros\Common\DataObject\Wrapper
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
     * @param \Ambros\Common\DataObject\ReflectionFactory $objectReflectionFactory
     * @param \Ambros\Common\DataObject\WrapperFactory $wrapperFactory
     * @return void
     */
    public function __construct(
        \Ambros\Common\DataObject\ReflectionFactory $objectReflectionFactory,
        \Ambros\Common\DataObject\WrapperFactory $wrapperFactory
    )
    {
        parent::__construct($objectReflectionFactory);
        $this->wrapperFactory = $wrapperFactory;
    }

    /**
     * After load with filter
     *
     * @return void
     */
    public function afterLoadWithFilter(): void
    {
        $collection = $this->getObject();
        $orderIds = [];
        foreach ($collection->getItems() as $order) {
            $orderIds[] = $order->getId();
        }
        $collectionShippingMethodWrapper = $this->wrapperFactory->create(
            $this->getObject(),
            \Ambros\Inventory\Wrapper\Model\Sales\ResourceModel\Order\Collection\ShippingMethod::class
        );
        $sourceOptions = $collectionShippingMethodWrapper->getSourceOptions($orderIds);
        foreach ($collection->getItems() as $order) {
            $orderId = $order->getId();
            $orderWrapper = $this->wrapperFactory->create(
                $order,
                \Ambros\Inventory\Wrapper\Model\Sales\Order::class
            );
            $orderWrapper->setShippingMethods($sourceOptions[$orderId] ?? []);
        }
    }
}