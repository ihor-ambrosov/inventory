<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Model\Sales\ResourceModel\Order;

/**
 * Get source codes resource
 */
class GetSourceCodes
{
    /**
     * Connection provider
     * 
     * @var \Ambros\Common\Model\ResourceModel\ConnectionProvider 
     */
    private $connectionProvider;
    
    /**
     * Constructor
     * 
     * @param \Ambros\Common\Model\ResourceModel\ConnectionProvider $connectionProvider
     * @return void
     */
    public function __construct(
        \Ambros\Common\Model\ResourceModel\ConnectionProvider $connectionProvider
    )
    {
        $this->connectionProvider = $connectionProvider;
    }
    
    /**
     * Execute
     *
     * @param array $orderIds
     * @return array
     */
    public function execute(array $orderIds): array
    {
        $sourceCodes = [];
        if (empty($orderIds)) {
            return $sourceCodes;
        }
        $orderItemTableAlias = 'order_item';
        $orderItemSourceTableAlias = 'order_item_source';
        $select = $this->connectionProvider->getSelect()
            ->from(
                [$orderItemTableAlias => $this->connectionProvider->getTable('sales_order_item')],
                []
            )
            ->join(
                [$orderItemSourceTableAlias => $this->connectionProvider->getTable('ambros_inventory__sales_order_item_source')],
                $orderItemSourceTableAlias.'.item_id = '.$orderItemTableAlias.'.item_id',
                []
            )
            ->columns([
                'order_id' => $orderItemTableAlias.'.order_id',
                'source_code' => $orderItemSourceTableAlias.'.source_code',
            ])
            ->where($orderItemTableAlias.'.order_id IN (?)', $orderIds);
        $rows = $this->connectionProvider->getConnection()->fetchAll($select);
        if (empty($rows)) {
            return $sourceCodes;
        }
        foreach ($rows as $row) {
            $orderId = $row['order_id'];
            $sourceCode = (string) $row['source_code'];
            if (isset($sourceCodes[$orderId]) && in_array($sourceCode, $sourceCodes[$orderId])) {
                continue;
            }
            $sourceCodes[$orderId][] = $sourceCode;
        }
        return $sourceCodes;
    }
}