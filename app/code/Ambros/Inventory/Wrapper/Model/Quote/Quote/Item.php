<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Wrapper\Model\Quote\Quote;

/**
 * Quote item wrapper
 */
class Item extends \Ambros\Common\DataObject\Wrapper
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
     * Get resource source wrapper
     * 
     * @return \Ambros\Inventory\Wrapper\Model\Quote\ResourceModel\Quote\Item\Source
     */
    private function getResourceSourceWrapper(): \Ambros\Inventory\Wrapper\Model\Quote\ResourceModel\Quote\Item\Source
    {
        return $this->wrapperFactory->create(
            $this->getObject()->getResource(),
            \Ambros\Inventory\Wrapper\Model\Quote\ResourceModel\Quote\Item\Source::class
        );
    }
    
    /**
     * Get source wrapper
     * 
     * @return \Ambros\Inventory\Wrapper\Model\Quote\Quote\Item\Source
     */
    private function getSourceWrapper(): \Ambros\Inventory\Wrapper\Model\Quote\Quote\Item\Source
    {
        return $this->wrapperFactory->create(
            $this->getObject(),
            \Ambros\Inventory\Wrapper\Model\Quote\Quote\Item\Source::class
        );
    }

    /**
     * After load
     * 
     * @return void
     */
    public function afterLoad(): void
    {
        $this->setSourceCode($this->getResourceSourceWrapper()->getSourceCode($this->getObject()->getId()));
    }

    /**
     * After save
     * 
     * @return void
     */
    public function afterSave(): void
    {
        $this->getResourceSourceWrapper()->saveSourceCode($this->getObject()->getId(), $this->getSourceCode());
    }
    
    /**
     * Before delete
     * 
     * @return void
     */
    public function beforeDelete(): void
    {
        $this->getResourceSourceWrapper()->deleteSourceCode($this->getObject()->getId());
    }
    
    /**
     * Set source code
     * 
     * @param string|null $sourceCode
     * @return void
     */
    public function setSourceCode(string $sourceCode = null): void
    {
        $this->getSourceWrapper()->setSourceCode($sourceCode);
    }
    
    /**
     * Get source code
     * 
     * @return string|null
     */
    public function getSourceCode(): ?string
    {
        return $this->getSourceWrapper()->getSourceCode();
    }
}