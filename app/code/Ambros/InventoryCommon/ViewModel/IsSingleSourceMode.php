<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\InventoryCommon\ViewModel;

/**
 * Is single source mode view model
 */
class IsSingleSourceMode implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    /**
     * Is single source mode
     * 
     * @var \Magento\InventoryCatalogApi\Model\IsSingleSourceModeInterface
     */
    private $isSingleSourceMode;
    
    /**
     * Constructor
     * 
     * @param \Magento\InventoryCatalogApi\Model\IsSingleSourceModeInterface $isSingleSourceMode
     */
    public function __construct(
        \Magento\InventoryCatalogApi\Model\IsSingleSourceModeInterface $isSingleSourceMode
    )
    {
        $this->isSingleSourceMode = $isSingleSourceMode;
    }
    
    /**
     * Execute
     * 
     * @return bool
     */
    public function execute(): bool
    {
        return $this->isSingleSourceMode->execute();
    }
}