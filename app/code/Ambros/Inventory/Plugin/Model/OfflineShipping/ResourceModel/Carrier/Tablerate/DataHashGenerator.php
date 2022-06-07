<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Model\OfflineShipping\ResourceModel\Carrier\Tablerate;

/**
 * Shipping table rate data hash generator plugin
 */
class DataHashGenerator
{
    /**
     * After get hash
     * 
     * @param \Magento\OfflineShipping\Model\ResourceModel\Carrier\Tablerate\DataHashGenerator $subject
     * @param string $result
     * @param array $data
     * @return string
     */
    public function afterGetHash(
        \Magento\OfflineShipping\Model\ResourceModel\Carrier\Tablerate\DataHashGenerator $subject,
        $result,
        array $data
    )
    {
        return $data['source_code'].'-'.$result;
    }
}