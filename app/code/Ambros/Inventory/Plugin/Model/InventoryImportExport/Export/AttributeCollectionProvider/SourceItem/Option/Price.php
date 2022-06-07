<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Model\InventoryImportExport\Export\AttributeCollectionProvider\SourceItem\Option;

/**
 * Source item price option export attribute collection provider plugin
 */
class Price extends \Ambros\InventoryCommon\Plugin\Model\InventoryImportExport\Export\AttributeCollectionProvider\SourceItem\Option
{
    /**
     * Constructor
     * 
     * @param \Ambros\Inventory\Model\Inventory\SourceItem\Option\Price\Meta $optionMeta
     * @param \Magento\Eav\Model\Entity\AttributeFactory $attributeFactory
     * @return void
     */
    public function __construct(
        \Ambros\Inventory\Model\Inventory\SourceItem\Option\Price\Meta $optionMeta,
        \Magento\Eav\Model\Entity\AttributeFactory $attributeFactory
    )
    {
        parent::__construct(
            $optionMeta,
            $attributeFactory
        );
    }
}