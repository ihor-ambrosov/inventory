<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Wrapper\Model\Quote\ResourceModel\Quote\Item;

/**
 * Quote item collection wrapper
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
     * Quote item wrapper factory
     * 
     * @var \Ambros\Common\DataObject\WrapperFactory
     */
    private $quoteItemWrapperFactory;

    /**
     * Constructor
     * 
     * @param \Ambros\Common\DataObject\ReflectionFactory $objectReflectionFactory
     * @param \Ambros\Common\DataObject\WrapperFactory $wrapperFactory
     * @param \Ambros\Inventory\Wrapper\Model\Quote\Quote\ItemFactory $quoteItemWrapperFactory
     * @return void
     */
    public function __construct(
        \Ambros\Common\DataObject\ReflectionFactory $objectReflectionFactory,
        \Ambros\Common\DataObject\WrapperFactory $wrapperFactory,
        \Ambros\Inventory\Wrapper\Model\Quote\Quote\ItemFactory $quoteItemWrapperFactory
    )
    {
        parent::__construct($objectReflectionFactory);
        $this->wrapperFactory = $wrapperFactory;
        $this->quoteItemWrapperFactory = $quoteItemWrapperFactory;
    }

    /**
     * After load with filter
     *
     * @return void
     */
    public function afterLoadWithFilter(): void
    {
        $collection = $this->getObject();
        $quoteItemIds = [];
        foreach ($collection->getItems() as $quoteItem) {
            $quoteItemIds[] = $quoteItem->getId();
        }
        $collectionSourceWrapper = $this->wrapperFactory->create(
            $this->getObject(),
            \Ambros\Inventory\Wrapper\Model\Quote\ResourceModel\Quote\Item\Collection\Source::class
        );
        $sourceCodes = $collectionSourceWrapper->getSourceCodes($quoteItemIds);
        foreach ($collection->getItems() as $quoteItem) {
            $quoteItemId = $quoteItem->getId();
            $this->quoteItemWrapperFactory->create($quoteItem)->setSourceCode($sourceCodes[$quoteItemId] ?? null);
        }
    }
}