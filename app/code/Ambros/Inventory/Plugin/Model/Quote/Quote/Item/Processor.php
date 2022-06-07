<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Model\Quote\Quote\Item;

/**
 * Quote item processor model plugin
 */
class Processor extends \Ambros\Common\Plugin\Plugin
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
     * After initialize
     * 
     * @param \Magento\Quote\Model\Quote\Item\Processor $subject
     * @param \Magento\Quote\Model\Quote\Item $result
     * @param \Magento\Catalog\Model\Product $product
     * @param \Magento\Framework\DataObject $request
     * @return \Magento\Quote\Model\Quote\Item
     */
    public function afterInit(
        \Magento\Quote\Model\Quote\Item\Processor $subject,
        $result,
        \Magento\Catalog\Model\Product $product,
        \Magento\Framework\DataObject $request
    )
    {
        $this->quoteItemWrapperFactory->create($result)->setSourceCode($request->getSource());
        return $result;
    }
    
    /**
     * After prepare
     * 
     * @param \Magento\Quote\Model\Quote\Item\Processor $subject
     * @param null $result
     * @param \Magento\Quote\Model\Quote\Item $item
     * @param \Magento\Framework\DataObject $request
     * @param \Magento\Catalog\Model\Product $candidate
     * @return void
     */
    public function afterPrepare(
        \Magento\Quote\Model\Quote\Item\Processor $subject,
        $result,
        \Magento\Quote\Model\Quote\Item $item,
        \Magento\Framework\DataObject $request
    )
    {
        $this->quoteItemWrapperFactory->create($item)->setSourceCode($request->getSource());
    }
}