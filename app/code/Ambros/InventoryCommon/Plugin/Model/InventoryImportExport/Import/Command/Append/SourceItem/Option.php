<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\InventoryCommon\Plugin\Model\InventoryImportExport\Import\Command\Append\SourceItem;

/**
 * Source item option import append command plugin
 */
class Option
{
    /**
     * Save options
     * 
     * @var \Ambros\InventoryCommon\Api\SourceItem\Option\SaveInterface
     */
    private $saveOptions;

    /**
     * Convert options
     * 
     * @var \Ambros\InventoryCommon\Model\Import\SourceItem\Option\Convert
     */
    private $convertOptions;

    /**
     * Constructor
     * 
     * @param \Ambros\InventoryCommon\Api\SourceItem\Option\SaveInterface $saveOptions
     * @param \Ambros\InventoryCommon\Model\Import\SourceItem\Option\Convert $convertOptions
     */
    public function __construct(
        \Ambros\InventoryCommon\Api\SourceItem\Option\SaveInterface $saveOptions,
        \Ambros\InventoryCommon\Model\Import\SourceItem\Option\Convert $convertOptions
    )
    {
        $this->saveOptions = $saveOptions;
        $this->convertOptions = $convertOptions;
    }

    /**
     * Around execute
     * 
     * @param \Magento\InventoryImportExport\Model\Import\Command\Append $subject
     * @param callable $proceed
     * @param array $bunch
     * @return void
     */
    public function aroundExecute(
        \Magento\InventoryImportExport\Model\Import\Command\Append $subject,
        callable $proceed,
        array $bunch
    )
    {
        $options = $this->convertOptions->convert($bunch);
        $proceed($bunch);
        $this->saveOptions->execute($options);
    }
}