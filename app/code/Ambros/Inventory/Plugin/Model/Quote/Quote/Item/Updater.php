<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Model\Quote\Quote\Item;

/**
 * Quote item updater model plugin
 */
class Updater extends \Ambros\Common\Plugin\Plugin
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
     * After update
     * 
     * @param \Magento\Quote\Model\Quote\Item\Updater $subject
     * @param \Magento\Quote\Model\Quote\Item\Updater $result
     * @param \Magento\Quote\Model\Quote\Item $item
     * @param array $info
     * @throws \Zend\Code\Exception\InvalidArgumentException
     * @return \Magento\Quote\Model\Quote\Item\Updater
     */
    public function afterUpdate(
        \Magento\Quote\Model\Quote\Item\Updater $subject,
        $result,
        \Magento\Quote\Model\Quote\Item $item,
        array $info
    )
    {
        /**
        if (empty($info['source'])) {
            throw new \InvalidArgumentException((string) __('The source is required to update quote item.'));
        }*/
        if (empty($info['action']) || !empty($info['configured'])) {
            if (!empty($info['source'])) {
                $this->quoteItemWrapperFactory->create($item)->setSourceCode($info['source']);
            }
            $product = $item->getProduct();
            $product->setIsSuperMode(true);
            $product->unsSkipCheckRequiredOption();
            $item->checkData();
        }
        return $result;
    }
}