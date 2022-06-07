<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Ui\Sales\Component\Order\Listing\Column;

/**
 * Order sources column
 */
class Sources extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * Get source names
     * 
     * @var \Ambros\InventoryCommon\Model\ResourceModel\Source\GetNames 
     */
    private $getSourceNames;

    /**
     * Get order source codes
     * 
     * @var \Ambros\Inventory\Model\Sales\ResourceModel\Order\GetSourceCodes
     */
    private $getOrderSourceCodes;

    /**
     * Constructor
     * 
     * @param \Ambros\InventoryCommon\Model\ResourceModel\Source\GetNames $getSourceNames
     * @param \Ambros\Inventory\Model\Sales\ResourceModel\Order\GetSourceCodes $getOrderSourceCodes
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        \Ambros\InventoryCommon\Model\ResourceModel\Source\GetNames $getSourceNames,
        \Ambros\Inventory\Model\Sales\ResourceModel\Order\GetSourceCodes $getOrderSourceCodes,
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    )
    {
        parent::__construct(
            $context,
            $uiComponentFactory,
            $components,
            $data
        );
        $this->getSourceNames = $getSourceNames;
        $this->getOrderSourceCodes = $getOrderSourceCodes;
    }

    /**
     * Prepare data source
     * 
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (!isset($dataSource['data']['totalRecords'])|| $dataSource['data']['totalRecords'] <= 0) {
            return $dataSource;
        }
        $dataSource['data'] = $this->getOrderGridData($dataSource['data']);
        return $dataSource;
    }
    
    /**
     * Get order IDs
     * 
     * @param array $data
     * @return array
     */
    private function getOrderIds($data): array
    {
        $orderIds = [];
        if (empty($data['items'])) {
            return $orderIds;
        }
        foreach ($data['items'] as $item) {
            if (empty($item['entity_id'])) {
                continue;
            }
            $orderIds[] = $item['entity_id'];
        }
        return $orderIds;
    }

    /**
     * Get order grid data
     * 
     * @param array $data
     * @return array
     */
    private function getOrderGridData($data): array
    {
        $sourceCodes = $this->getOrderSourceCodes->execute($this->getOrderIds($data));
        if (empty($sourceCodes)) {
            return $data;
        }
        $names = $this->getSourceNames->execute($sourceCodes);
        foreach ($data['items'] as &$item) {
            if (empty($item['entity_id'])) {
                continue;
            }
            $orderId = $item['entity_id'];
            if (empty($sourceCodes[$orderId])) {
                $item['sources'] = [];
                continue;
            }
            $item['sources'] = array_map(
                function ($sourceCode) use ($names) {
                    return $names[$sourceCode] ?? '';
                },
                $sourceCodes[$orderId]
            );
        }
        return $data;
    }
}
