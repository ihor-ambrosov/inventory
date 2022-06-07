<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\InventoryCommon\Model;

/**
 * Get default stock
 */
class GetDefaultStock implements \Ambros\InventoryCommon\Api\GetDefaultStockInterface
{
    /**
     * Stock repository
     * 
     * @var \Magento\InventoryApi\Api\StockRepositoryInterface
     */
    private $stockRepository;

    /**
     * Default stock provider
     * 
     * @var \Magento\InventoryCatalogApi\Api\DefaultStockProviderInterface
     */
    private $defaultStockProvider;

    /**
     * Constructor
     * 
     * @param \Magento\InventoryApi\Api\StockRepositoryInterface $stockRepository
     * @param \Magento\InventoryCatalogApi\Api\DefaultStockProviderInterface $defaultStockProvider
     * @return void
     */
    public function __construct(
        \Magento\InventoryApi\Api\StockRepositoryInterface $stockRepository,
        \Magento\InventoryCatalogApi\Api\DefaultStockProviderInterface $defaultStockProvider
    )
    {
        $this->stockRepository = $stockRepository;
        $this->defaultStockProvider = $defaultStockProvider;
    }
    
    /**
     * Execute
     * 
     * @return \Magento\InventoryApi\Api\Data\StockInterface
     */
    public function execute(): \Magento\InventoryApi\Api\Data\StockInterface
    {
        return $this->stockRepository->get($this->defaultStockProvider->getId());
    }
}