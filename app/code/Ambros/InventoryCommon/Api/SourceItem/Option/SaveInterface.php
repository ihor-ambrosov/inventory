<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\InventoryCommon\Api\SourceItem\Option;

/**
 * Save source item options interface
 */
interface SaveInterface
{
    /**
     * Execute
     * 
     * @param \Ambros\InventoryCommon\Api\Data\SourceItemOptionInterface[] $options
     * @return $this
     */
    public function execute(array $options);
}