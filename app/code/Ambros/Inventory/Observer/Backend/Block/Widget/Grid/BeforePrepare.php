<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Observer\Backend\Block\Widget\Grid;

/**
 * Before prepare grid observer
 */
class BeforePrepare implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * Execute
     * 
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $grid = $observer->getGrid();
        if ($grid instanceof \Magento\OfflineShipping\Block\Adminhtml\Carrier\Tablerate\Grid) {
            $grid->addColumn(
                'source_code',
                [
                    'header' => __('Source'),
                    'index' => 'source_code',
                    'default' => null,
                ]
            );
            $grid->addColumnsOrder('dest_country', 'source_code');
            $grid->addColumnsOrder('dest_region', 'dest_country');
            $grid->addColumnsOrder('dest_zip', 'dest_region');
            $grid->addColumnsOrder('condition_value', 'dest_zip');
            $grid->addColumnsOrder('price', 'condition_value');
            $grid->sortColumnsByOrder();
        }
    }
}