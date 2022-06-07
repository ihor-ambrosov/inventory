<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Wrapper\Model\Quote\Quote\Item;

/**
 * Quote item source wrapper
 */
class Source extends \Ambros\Inventory\Wrapper\Model\Framework\Source
{
    /**
     * Set source code
     * 
     * @param string|null $sourceCode
     * @return void
     */
    public function setSourceCode(string $sourceCode = null): void
    {
        $object = $this->getObject();
        $object->getExtensionAttributes()->setSourceCode($sourceCode);
        $children = $object->getChildren();
        if (!count($children)) {
            return;
        }
        $parentObject = $object;
        foreach ($children as $childItem) {
            $this->setObject($childItem);
            $this->setSourceCode($sourceCode);
        }
        $this->setObject($parentObject);
    }
}