<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\InventoryCommon\Model\SourceItem\Option;

/**
 * Save source item options
 */
class Save implements \Ambros\InventoryCommon\Api\SourceItem\Option\SaveInterface
{
    /**
     * Resource
     * 
     * @var \Ambros\InventoryCommon\Model\ResourceModel\SourceItem\Option\Save
     */
    private $resource;
    
    /**
     * Source item option meta
     * 
     * @var \Ambros\InventoryCommon\Model\SourceItem\Option\Meta
     */
    private $optionMeta;
    
    /**
     * Logger
     * 
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * Constructor
     * 
     * @param \Ambros\InventoryCommon\Model\ResourceModel\SourceItem\Option\Save $resource
     * @param \Ambros\InventoryCommon\Model\SourceItem\Option\Meta $optionMeta
     * @param \Psr\Log\LoggerInterface $logger
     * @return void
     */
    public function __construct(
        \Ambros\InventoryCommon\Model\ResourceModel\SourceItem\Option\Save $resource,
        \Ambros\InventoryCommon\Model\SourceItem\Option\Meta $optionMeta,
        \Psr\Log\LoggerInterface $logger
    )
    {
        $this->resource = $resource;
        $this->optionMeta = $optionMeta;
        $this->logger = $logger;
    }
    
    /**
     * Execute
     * 
     * @param \Ambros\InventoryCommon\Api\Data\SourceItemOptionInterface[] $options
     * @return $this
     */
    public function execute(array $options)
    {
        if (empty($options)) {
            throw new \Magento\Framework\Exception\InputException(__('No %1 to save.', $this->optionMeta->getLabel()));
        }
        try {
            $this->resource->execute($options);
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage());
            throw new \Magento\Framework\Exception\CouldNotSaveException(__('Could not save %1.', $this->optionMeta->getLabel()), $exception);
        }
        return $this;
    }
}