<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Model\InventoryReservationCli\ResourceModel;

/**
 * Get order data for order in final state plugin
 */
class GetOrderDataForOrderInFinalState
{
    /**
     * Get source codes
     * 
     * @var \Ambros\Inventory\Model\Sales\ResourceModel\Order\GetSourceCodes
     */
    private $getSourceCodes;

    /**
     * Constructor
     * 
     * @param \Ambros\Inventory\Model\Sales\ResourceModel\Order\GetSourceCodes $getSourceCodes
     * @return void
     */
    public function __construct(
        \Ambros\Inventory\Model\Sales\ResourceModel\Order\GetSourceCodes $getSourceCodes
    )
    {
        $this->getSourceCodes = $getSourceCodes;
    }

    /**
     * After execute
     * 
     * @param \Magento\InventoryReservationCli\Model\ResourceModel\GetOrderDataForOrderInFinalState $subject
     * @param array $result
     * @return array
     */
    public function afterExecute(
        \Magento\InventoryReservationCli\Model\ResourceModel\GetOrderDataForOrderInFinalState $subject,
        array $result
    ): array
    {
        $sourceCodes = $this->getSourceCodes->execute(
            array_map(
                function ($orderData) {
                    return $orderData['entity_id'];
                },
                $result
            )
        );
        foreach ($result as $key => $orderData) {
            $orderId = $orderData['entity_id'];
            $result[$key]['source_codes'] = !empty($sourceCodes[$orderId]) ? $sourceCodes[$orderId] : [];
        }
        return $result;
    }
}