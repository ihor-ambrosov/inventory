<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\InventoryCommon\Model\ResourceModel\SourceItem\Option;

/**
 * Assign source item options resource
 */
class Assign
{
    /**
     * Connection provider
     * 
     * @var \Ambros\Common\Model\ResourceModel\ConnectionProvider
     */
    private $connectionProvider;

    /**
     * Is source item management allowed for product type
     * 
     * @var \Magento\InventoryConfigurationApi\Model\IsSourceItemManagementAllowedForProductTypeInterface
     */
    private $isSourceItemManagementAllowedForProductType;

    /**
     * Get product types by SKUs
     * 
     * @var \Magento\InventoryCatalogApi\Model\GetProductTypesBySkusInterface
     */
    private $getProductTypesBySkus;

    /**
     * Table name
     * 
     * @var string
     */
    private $tableName;

    /**
     * Constructor
     * 
     * @param \Ambros\Common\Model\ResourceModel\ConnectionProvider $connectionProvider
     * @param \Magento\InventoryCatalogApi\Model\GetProductTypesBySkusInterface $getProductTypesBySkus
     * @param \Magento\InventoryConfigurationApi\Model\IsSourceItemManagementAllowedForProductTypeInterface $isSourceItemManagementAllowedForProductType
     * @param string $tableName
     * @return void
     */
    public function __construct(
        \Ambros\Common\Model\ResourceModel\ConnectionProvider $connectionProvider,
        \Magento\InventoryCatalogApi\Model\GetProductTypesBySkusInterface $getProductTypesBySkus,
        \Magento\InventoryConfigurationApi\Model\IsSourceItemManagementAllowedForProductTypeInterface $isSourceItemManagementAllowedForProductType,
        string $tableName
    )
    {
        $this->connectionProvider = $connectionProvider;
        $this->isSourceItemManagementAllowedForProductType = $isSourceItemManagementAllowedForProductType;
        $this->getProductTypesBySkus = $getProductTypesBySkus;
        $this->tableName = $tableName;
    }
    
    /**
     * Execute
     *
     * @param array $skus
     * @param array $sources
     * @return $this
     */
    public function execute(array $skus, array $sources)
    {
        $table = $this->connectionProvider->getTable($this->tableName);
        $connection = $this->connectionProvider->getConnection();
        $productTypes = $this->getProductTypesBySkus->execute($skus);
        foreach ($productTypes as $sku => $productType) {
            if (!$this->isSourceItemManagementAllowedForProductType->execute($productType)) {
                continue;
            }
            foreach ($sources as $sourceCode) {
                try {
                    $connection->insert($table, [
                        \Ambros\InventoryCommon\Api\Data\SourceItemOptionInterface::SOURCE_CODE => (string) $sourceCode,
                        \Ambros\InventoryCommon\Api\Data\SourceItemOptionInterface::SKU => $sku,
                        \Ambros\InventoryCommon\Api\Data\SourceItemOptionInterface::VALUE => null,
                    ]);
                } catch (\Magento\Framework\DB\Adapter\DuplicateException $exception) {
                    continue;
                }
            }
        }
        return $this;
    }
}
