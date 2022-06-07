<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Model\Quote;

/**
 * Quote configuration
 */
class Config
{
    /**
     * Split order configuration path
     */
    const XML_PATH_SPLIT_ORDER = 'cataloginventory/source_options/split_order';

    /**
     * Scope configuration
     * 
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @return void
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    )
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Check if is split order
     *
     * @return bool
     */
    public function isSplitOrder(): bool
    {
        return $this->isSetFlag(static::XML_PATH_SPLIT_ORDER);
    }
    
    /**
     * Check if flag is set
     *
     * @return bool
     */
    private function isSetFlag($path): bool
    {
        return (bool) $this->scopeConfig->isSetFlag($path, \Magento\Framework\App\Config\ScopeConfigInterface::SCOPE_TYPE_DEFAULT);
    }
}