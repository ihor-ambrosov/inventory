<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Wrapper\Model\Sales\ResourceModel\Order\Item;

/**
 * Order item collection wrapper
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
     * Order item wrapper factory
     * 
     * @var \Ambros\Inventory\Wrapper\Model\Sales\Order\ItemFactory 
     */
    private $orderItemWrapperFactory;
    
    /**
     * Constructor
     * 
     * @param \Ambros\Common\DataObject\ReflectionFactory $objectReflectionFactory
     * @param \Ambros\Common\DataObject\WrapperFactory $wrapperFactory
     * @param \Ambros\Inventory\Wrapper\Model\Sales\Order\ItemFactory $orderItemWrapperFactory
     * @return void
     */
    public function __construct(
        \Ambros\Common\DataObject\ReflectionFactory $objectReflectionFactory,
        \Ambros\Common\DataObject\WrapperFactory $wrapperFactory,
        \Ambros\Inventory\Wrapper\Model\Sales\Order\ItemFactory $orderItemWrapperFactory
    )
    {
        parent::__construct($objectReflectionFactory);
        $this->wrapperFactory = $wrapperFactory;
        $this->orderItemWrapperFactory = $orderItemWrapperFactory;
    }

    /**
     * After load with filter
     *
     * @return void
     */
    public function afterLoadWithFilter(): void
    {
        $collection = $this->getObject();
        $orderItemIds = [];
        foreach ($collection->getItems() as $orderItem) {
            $orderItemIds[] = $orderItem->getId();
        }
        $collectionSourceWrapper = $this->wrapperFactory->create(
            $this->getObject(),
            \Ambros\Inventory\Wrapper\Model\Sales\ResourceModel\Order\Item\Collection\Source::class
        );
        $sourceCodes = $collectionSourceWrapper->getSourceCodes($orderItemIds);
        foreach ($collection->getItems() as $orderItem) {
            $orderItemId = $orderItem->getId();
            $this->orderItemWrapperFactory->create($orderItem)->setSourceCode($sourceCodes[$orderItemId] ?? null);
        }
    }
}