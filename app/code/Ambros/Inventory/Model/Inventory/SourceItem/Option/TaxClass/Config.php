<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Model\Inventory\SourceItem\Option\TaxClass;

/**
 * Source item tax class option configuration
 */
class Config extends \Ambros\InventoryCommon\Model\SourceItem\Option\Config 
{
    
    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param string $path
     * @return void
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        string $path = 'cataloginventory/source_options/enable_tax_class'
    )
    {
        parent::__construct($scopeConfig, $path);
    }
}