<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Model\Catalog\Product\Copier\SourceItem\Option;

/**
 * Product resource source item tax class options plugin
 */
class TaxClass extends \Ambros\InventoryCommon\Plugin\Model\Catalog\Product\Copier\SourceItem\Option
{
    
    /**
     * Constructor
     * 
     * @param \Ambros\Inventory\Api\Inventory\SourceItem\Option\TaxClass\GetInterface $getOptions
     * @param \Ambros\Inventory\Api\Inventory\SourceItem\Option\TaxClass\SaveInterface $saveOptions
     * @param \Ambros\Inventory\Model\Inventory\SourceItem\Option\TaxClass\Config $optionConfig
     * @return void
     */
    public function __construct(
        \Ambros\Inventory\Api\Inventory\SourceItem\Option\TaxClass\GetInterface $getOptions,
        \Ambros\Inventory\Api\Inventory\SourceItem\Option\TaxClass\SaveInterface $saveOptions,
        \Ambros\Inventory\Model\Inventory\SourceItem\Option\TaxClass\Config $optionConfig
    )
    {
        parent::__construct(
            $getOptions,
            $saveOptions,
            $optionConfig
        );
    }
    
}