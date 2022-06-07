<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Wrapper\Block\Sales\Adminhtml\Order\Create\Items;

/**
 * Create order items grid wrapper
 */
class Grid extends \Ambros\Common\DataObject\Wrapper implements \Magento\Framework\View\Element\Block\ArgumentInterface
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
     * Get source code
     * 
     * @param \Magento\Quote\Api\Data\CartItemInterface $quoteitem
     * @return string|null
     */
    public function getSourceCode(\Magento\Quote\Api\Data\CartItemInterface $quoteitem): ?string
    {
        $quoteItemWrapper = $this->wrapperFactory->create(
            $quoteitem,
            \Ambros\Inventory\Wrapper\Model\Quote\Quote\Item::class
        );
        return $quoteItemWrapper->getSourceCode();
    }
}