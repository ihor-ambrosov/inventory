<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Model\Config\ResourceModel\Config\Data;

/**
 * Configuration data collection resource
 */
class Collection extends \Magento\Config\Model\ResourceModel\Config\Data\Collection
{
    /**
     * Construct
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Magento\Framework\App\Config\Value::class,
            \Ambros\Inventory\Model\Config\ResourceModel\Config\Data::class
        );
    }
    
    /**
     * Add source filter
     * 
     * @param string $sourceCode
     * @return $this
     */
    public function addSourceFilter(string $sourceCode)
    {
        $this->addFieldToFilter('source_code', $sourceCode);
        return $this;
    }
}