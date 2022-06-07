<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Model\Catalog\Product\Checkout;

/**
 * Composite product checkout configuration provider
 */
class CompositeConfigProvider implements \Magento\Checkout\Model\ConfigProviderInterface
{
    /**
     * Configuration providers
     * 
     * @var \Magento\Checkout\Model\ConfigProviderInterface[]
     */
    private $configProviders;
    
    /**
     * Constructor
     * 
     * @param \Magento\Checkout\Model\ConfigProviderInterface[] $configProviders
     * @return void
     */
    public function __construct(array $configProviders)
    {
        $this->configProviders = $configProviders;
    }

    /**
     * Get configuration
     * 
     * @return array
     */
    public function getConfig()
    {
        $config = [];
        foreach ($this->configProviders as $configProvider) {
            $config = array_merge_recursive($config, $configProvider->getConfig());
        }
        return $config;
    }
}