<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Model\Inventory\SourceItem\Option\TaxClass;

/**
 * Save source item tax class options
 */
class Save extends \Ambros\InventoryCommon\Model\SourceItem\Option\Save 
    implements \Ambros\Inventory\Api\Inventory\SourceItem\Option\TaxClass\SaveInterface 
{
    /**
     * Constructor
     * 
     * @param \Ambros\Inventory\Model\Inventory\ResourceModel\SourceItem\Option\TaxClass\Save $resource
     * @param \Ambros\Inventory\Model\Inventory\SourceItem\Option\TaxClass\Meta $optionMeta
     * @param \Psr\Log\LoggerInterface $logger
     * @return void
     */
    public function __construct(
        \Ambros\Inventory\Model\Inventory\ResourceModel\SourceItem\Option\TaxClass\Save $resource,
        \Ambros\Inventory\Model\Inventory\SourceItem\Option\TaxClass\Meta $optionMeta,
        \Psr\Log\LoggerInterface $logger
    )
    {
        parent::__construct(
            $resource,
            $optionMeta,
            $logger
        );
    }
}