<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Model\Store;

/**
 * Website plugin
 */
class Website
{
    /**
     * Configuration cache
     * 
     * @var \Magento\Framework\App\Cache\Type\Config
     */
    private $configCache;

    /**
     * Resource
     * 
     * @var \Magento\Store\Model\ResourceModel\Website
     */
    private $resource;

    /**
     * Constructor
     * 
     * @param \Magento\Framework\App\Cache\Type\Config $configCache
     * @param \Magento\Store\Model\ResourceModel\Website $resource
     * @return void
     */
    public function __construct(
        \Magento\Framework\App\Cache\Type\Config $configCache,
        \Magento\Store\Model\ResourceModel\Website $resource
    )
    {
        $this->configCache = $configCache;
        $this->resource = $resource;
    }

    /**
     * After after delete
     * 
     * @param \Magento\Store\Model\Website $subject
     * @param \Magento\Store\Model\Website $result
     * @return \Magento\Store\Model\Website
     */
    public function afterAfterDelete(
        \Magento\Store\Model\Website $subject,
        $result
    )
    {
        $this->resource->getConnection()->delete(
            $this->resource->getTable('ambros_inventory__source_core_config_data'),
            [
                'scope = ?' => \Magento\Store\Model\ScopeInterface::SCOPE_WEBSITES,
                'scope_id = ?' => $subject->getWebsiteId(),
            ]
        );
        $this->configCache->clean();
        return $result;
    }
}