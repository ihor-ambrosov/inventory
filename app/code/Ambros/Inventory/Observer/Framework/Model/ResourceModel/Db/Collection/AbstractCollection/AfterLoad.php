<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * See COPYING.txt for license details.
 */
namespace Ambros\Inventory\Observer\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Collection after load source observer
 */
class AfterLoad implements \Magento\Framework\Event\ObserverInterface
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
     */
    public function __construct(\Ambros\Common\DataObject\WrapperFactory $wrapperFactory)
    {
        $this->wrapperFactory = $wrapperFactory;
    }

    /**
     * Execute
     * 
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $event = $observer->getEvent();
        if (!$event) {
            return $this;
        }
        $collection = $event->getCollection();
        if (!$collection) {
            return $this;
        }
        if ($collection instanceof \Magento\Quote\Model\ResourceModel\Quote\Item\Collection) {
            $this->wrapperFactory
                ->create(
                    $collection,
                    \Ambros\Inventory\Wrapper\Model\Quote\ResourceModel\Quote\Item\Collection::class
                )
                ->afterLoadWithFilter();
        } else if ($collection instanceof \Magento\Quote\Model\ResourceModel\Quote\Address\Collection) {
            $this->wrapperFactory
                ->create(
                    $collection,
                    \Ambros\Inventory\Wrapper\Model\Quote\ResourceModel\Quote\Address\Collection::class
                )
                ->afterLoadWithFilter();
        } else if ($collection instanceof \Magento\Sales\Model\ResourceModel\Order\Item\Collection) {
            $this->wrapperFactory
                ->create(
                    $collection,
                    \Ambros\Inventory\Wrapper\Model\Sales\ResourceModel\Order\Item\Collection::class
                )
                ->afterLoadWithFilter();
        } else if ($collection instanceof \Magento\Sales\Model\ResourceModel\Order\Collection) {
            $this->wrapperFactory
                ->create(
                    $collection,
                    \Ambros\Inventory\Wrapper\Model\Sales\ResourceModel\Order\Collection::class
                )
                ->afterLoadWithFilter();
        }
        return $this;
    }
}