<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Model\Config\Config;

/**
 * Configuration loader plugin
 */
class Loader
{
    /**
     * Current source provider
     * 
     * @var \Ambros\InventoryCommon\Api\CurrentSourceProviderInterface
     */
    private $currentSourceProvider;

    /**
     * Source configuration data collection factory
     * 
     * @var \Ambros\Inventory\Model\Config\ResourceModel\Config\Data\CollectionFactory
     */
    private $sourceConfigDataCollectionFactory;

    /**
     * Configuration data collection factory
     * 
     * @var \Magento\Config\Model\ResourceModel\Config\Data\CollectionFactory
     */
    private $configDataCollectionFactory;

    /**
     * Constructor
     * 
     * @param \Ambros\InventoryCommon\Api\CurrentSourceProviderInterface $currentSourceProvider
     * @param \Ambros\Inventory\Model\Config\ResourceModel\Config\Data\CollectionFactory $sourceConfigDataCollectionFactory
     * @param \Magento\Config\Model\ResourceModel\Config\Data\CollectionFactory $configDataCollectionFactory
     */
    public function __construct(
        \Ambros\InventoryCommon\Api\CurrentSourceProviderInterface $currentSourceProvider,
        \Ambros\Inventory\Model\Config\ResourceModel\Config\Data\CollectionFactory $sourceConfigDataCollectionFactory,
        \Magento\Config\Model\ResourceModel\Config\Data\CollectionFactory $configDataCollectionFactory
    )
    {
        $this->currentSourceProvider = $currentSourceProvider;
        $this->sourceConfigDataCollectionFactory = $sourceConfigDataCollectionFactory;
        $this->configDataCollectionFactory = $configDataCollectionFactory;
    }

    /**
     * Around get configuration by path
     * 
     * @param \Magento\Config\Model\Config\Loader $subject
     * @param \Closure $proceed
     * @param string $path
     * @param string $scope
     * @param string $scopeId
     * @param bool $full
     * @return array
     */
    public function aroundGetConfigByPath(
        \Magento\Config\Model\Config\Loader $subject,
        \Closure $proceed,
        $path,
        $scope,
        $scopeId,
        $full = true
    )
    {
        $sourceCode = (string) $this->currentSourceProvider->getSourceCode();
        if ($sourceCode) {
            $configDataCollection = $this->sourceConfigDataCollectionFactory->create();
            $configDataCollection->addSourceFilter($sourceCode);
        } else {
            $configDataCollection = $this->configDataCollectionFactory->create();
        }
        $configDataCollection->addScopeFilter($scope, $scopeId, $path);
        $configDataCollection->load();
        $config = [];
        foreach ($configDataCollection->getItems() as $configData) {
            $path = $configData->getPath();
            if ($full) {
                $config[$path] = [
                    'path' => $configData->getPath(),
                    'value' => $configData->getValue(),
                    'config_id' => $configData->getConfigId(),
                ];
            } else {
                $config[$path] = $configData->getValue();
            }
        }
        return $config;
    }
}