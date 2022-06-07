<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Model\Inventory\SourceItem\Option\Price;

/**
 * Delete source item price options
 */
class Delete extends \Ambros\InventoryCommon\Model\SourceItem\Option\Delete 
    implements \Ambros\Inventory\Api\Inventory\SourceItem\Option\Price\DeleteInterface 
{
    
    /**
     * Constructor
     * 
     * @param \Ambros\Inventory\Model\Inventory\ResourceModel\SourceItem\Option\Price\Delete $resource
     * @param \Ambros\Inventory\Model\Inventory\SourceItem\Option\Price\Meta $optionMeta
     * @param \Psr\Log\LoggerInterface $logger
     * @return void
     */
    public function __construct(
        \Ambros\Inventory\Model\Inventory\ResourceModel\SourceItem\Option\Price\Delete $resource,
        \Ambros\Inventory\Model\Inventory\SourceItem\Option\Price\Meta $optionMeta,
        \Psr\Log\LoggerInterface $logger
    )
    {
        parent::__construct($resource, $optionMeta, $logger);
    }
    
}