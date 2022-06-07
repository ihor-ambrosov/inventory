<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Helper\Catalog\Product;

/**
 * Product configuration helper plugin
 */
class Configuration
{
    /**
     * Get source by source code
     * 
     * @var \Ambros\InventoryCommon\Model\GetSourceBySourceCode
     */
    private $getSourceBySourceCode;

    /**
     * Constructor
     * 
     * @param \Ambros\InventoryCommon\Model\GetSourceBySourceCode $getSourceBySourceCode
     * @return void
     */
    public function __construct(
        \Ambros\InventoryCommon\Model\GetSourceBySourceCode $getSourceBySourceCode
    )
    {
        $this->getSourceBySourceCode = $getSourceBySourceCode;
    }

    /**
     * After get custom options
     * 
     * @param \Magento\Catalog\Helper\Product\Configuration $subject
     * @param array $result
     * @param \Magento\Catalog\Model\Product\Configuration\Item\ItemInterface $item
     * @return array
     */
    public function afterGetCustomOptions(
        \Magento\Catalog\Helper\Product\Configuration $subject,
        $result,
        \Magento\Catalog\Model\Product\Configuration\Item\ItemInterface $item
    )
    {
        $sourceOption = $item->getOptionByCode('source');
        if (empty($sourceOption)) {
            return $result;
        }
        $source = $this->getSourceBySourceCode->execute($sourceOption->getValue());
        if (empty($source)) {
            return $result;
        }
        $result[] = [
            'label' => __('Source'),
            'value' => $source->getName(),
            'type' => 'source',
            'source_code' => $source->getSourceCode(),
        ];
        return $result;
    }
}