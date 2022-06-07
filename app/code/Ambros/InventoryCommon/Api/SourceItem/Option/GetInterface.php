<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\InventoryCommon\Api\SourceItem\Option;

/**
 * Get source item options interface
 */
interface GetInterface
{
    /**
     * Execute
     * 
     * @param array $skus
     * @param array $sourceCodes
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute(array $skus, array $sourceCodes): array;
}