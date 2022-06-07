<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Model\Quote\Quote;

/**
 * Quote item plugin
 */
class Item extends \Ambros\Common\Plugin\Plugin
{
    /**
     * Get source by source code
     * 
     * @var \Ambros\InventoryCommon\Model\GetSourceBySourceCode
     */
    private $getSourceBySourceCode;
    
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
     * @param \Ambros\InventoryCommon\Model\GetSourceBySourceCode $getSourceBySourceCode
     * @param \Ambros\Inventory\Wrapper\Model\Quote\Quote\ItemFactory $quoteItemWrapperFactory
     * @return void
     */
    public function __construct(
        \Ambros\Common\DataObject\WrapperFactory $wrapperFactory,
        \Ambros\InventoryCommon\Model\GetSourceBySourceCode $getSourceBySourceCode,
        \Ambros\Inventory\Wrapper\Model\Quote\Quote\ItemFactory $quoteItemWrapperFactory
    )
    {
        parent::__construct($wrapperFactory);
        $this->quoteItemWrapperFactory = $quoteItemWrapperFactory;
        $this->getSourceBySourceCode = $getSourceBySourceCode;
    }
    
    /**
     * After get product
     * 
     * @param \Magento\Quote\Model\Quote\Item $subject
     * @param \Magento\Catalog\Model\Product $result
     * @return \Magento\Catalog\Model\Product
     */
    public function afterGetProduct(
        \Magento\Quote\Model\Quote\Item $subject,
        $result
    )
    {
        $this->setSubject($subject);
        $sourceCode = (string) $this->quoteItemWrapperFactory->create($subject)->getSourceCode();
        $result->setSourceCode($sourceCode);
        return $result;
    }

    /**
     * After after load
     * 
     * @param \Magento\Quote\Model\Quote\Item $subject
     * @param \Magento\Quote\Model\Quote\Item $result
     * @return \Magento\Quote\Model\Quote\Item
     */
    public function afterAfterLoad(
        \Magento\Quote\Model\Quote\Item $subject,
        $result
    )
    {
        $this->setSubject($subject);
        $this->quoteItemWrapperFactory->create($subject)->afterLoad();
        return $result;
    }

    /**
     * After before save
     * 
     * @param \Magento\Quote\Model\Quote\Item $subject
     * @param \Magento\Quote\Model\Quote\Item $result
     * @return \Magento\Quote\Model\Quote\Item
     */
    public function afterBeforeSave(
        \Magento\Quote\Model\Quote\Item $subject,
        $result
    )
    {
        $this->setSubject($subject);
        $sourceCode = (string) $this->quoteItemWrapperFactory->create($subject)->getSourceCode();
        if (!$sourceCode) {
            return $result;
        }
        if (!$this->getSourceBySourceCode->execute($sourceCode)) {
            throw new \Magento\Framework\Exception\ValidatorException(__('Invalid source code.'));
        }
        return $result;
    }
    
    /**
     * After after save
     * 
     * @param \Magento\Quote\Model\Quote\Item $subject
     * @param \Magento\Quote\Model\Quote\Item $result
     * @return \Magento\Quote\Model\Quote\Item
     */
    public function afterAfterSave(
        \Magento\Quote\Model\Quote\Item $subject,
        $result
    )
    {
        $this->setSubject($subject);
        $this->quoteItemWrapperFactory->create($subject)->afterSave();
        return $result;
    }

    /**
     * After before delete
     *
     * @param \Magento\Quote\Model\Quote\Item $subject
     * @param \Magento\Quote\Model\Quote\Item $result
     * @return \Magento\Quote\Model\Quote\Item
     */
    public function afterBeforeDelete(
        \Magento\Quote\Model\Quote\Item $subject,
        $result
    )
    {
        $this->setSubject($subject);
        $this->quoteItemWrapperFactory->create($subject)->beforeDelete();
        return $result;
    }
}