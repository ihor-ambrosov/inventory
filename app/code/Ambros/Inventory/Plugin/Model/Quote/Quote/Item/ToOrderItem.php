<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Model\Quote\Quote\Item;

/**
 * Quote item to order item plugin
 */
class ToOrderItem
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
    public function __construct(
        \Ambros\Common\DataObject\WrapperFactory $wrapperFactory
    )
    {
        $this->wrapperFactory = $wrapperFactory;
    }

    /**
     * After convert
     * 
     * @param \Magento\Quote\Model\Quote\Item\ToOrderItem $subject
     * @param \Magento\Sales\Api\Data\OrderItemInterface $result
     * @param \Magento\Quote\Model\Quote\Item|\Magento\Quote\Model\Quote\Address\Item $item
     * @param array $data
     * @return \Magento\Sales\Api\Data\OrderItemInterface
     */
    public function afterConvert(
        \Magento\Quote\Model\Quote\Item\ToOrderItem $subject,
        $result,
        $item
    )
    {
        if ($item instanceof \Magento\Quote\Api\Data\CartItemInterface) {
            $sourceCode = (string) $this->wrapperFactory->create($item, \Ambros\Inventory\Wrapper\Model\Quote\Quote\Item::class)->getSourceCode();
        } else {
            $sourceCode = (string) $item->getSourceCode();
        }
        $this->wrapperFactory->create($result, \Ambros\Inventory\Wrapper\Model\Sales\Order\Item::class)->setSourceCode($sourceCode);
        return $result;
    }
}