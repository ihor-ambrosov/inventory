<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\InventoryCommon\Model\SourceItem;

/**
 * Source item option
 */
class Option extends \Magento\Framework\Model\AbstractExtensibleModel implements \Ambros\InventoryCommon\Api\Data\SourceItemOptionInterface
{
    /**
     * Get source code
     * 
     * @return string|null
     */
    public function getSourceCode(): ?string
    {
        return $this->getData(static::SOURCE_CODE);
    }
    
    /**
     * Set source code
     * 
     * @param string $sourceCode
     * @return $this
     */
    public function setSourceCode(string $sourceCode)
    {
        $this->setData(static::SOURCE_CODE, $sourceCode);
        return $this;
    }
    
    /**
     * Get SKU
     * 
     * @return string|null
     */
    public function getSku(): ?string
    {
        return $this->getData(static::SKU);
    }
    
    /**
     * Set SKU
     * 
     * @param string $sku
     * @return $this
     */
    public function setSku(string $sku)
    {
        $this->setData(static::SKU, $sku);
        return $this;
    }
    
    /**
     * Get value
     * 
     * @return mixed
     */
    public function getValue()
    {
        return $this->getData(static::VALUE);
    }
    
    /**
     * Set value
     *
     * @param mixed $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->setData(static::VALUE, $value);
        return $this;
    }
    
    /**
     * Get extension attributes
     *
     * @return \Ambros\InventoryCommon\Api\Data\SourceItemOptionExtensionInterface|null
     */
    public function getExtensionAttributes(): ?\Ambros\InventoryCommon\Api\Data\SourceItemOptionExtensionInterface
    {
        $extensionAttributes = $this->_getExtensionAttributes();
        if (null === $extensionAttributes) {
            $extensionAttributes = $this->extensionAttributesFactory->create(\Ambros\InventoryCommon\Api\Data\SourceItemOptionInterface::class);
            $this->setExtensionAttributes($extensionAttributes);
        }
        return $extensionAttributes;
    }
    
    /**
     * Set extension attributes
     *
     * @param \Ambros\InventoryCommon\Api\Data\SourceItemOptionExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(\Ambros\InventoryCommon\Api\Data\SourceItemOptionExtensionInterface $extensionAttributes)
    {
        $this->_setExtensionAttributes($extensionAttributes);
        return $this;
    }
}