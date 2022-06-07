<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\InventoryCommon\Model\SourceItem\Option;

/**
 * Delete source item options
 */
class Delete implements \Ambros\InventoryCommon\Api\SourceItem\Option\DeleteInterface
{
    /**
     * Resource
     * 
     * @var \Ambros\InventoryCommon\Model\ResourceModel\SourceItem\Option\Delete
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
     * @param \Ambros\InventoryCommon\Model\ResourceModel\SourceItem\Option\Delete $resource
     * @param \Ambros\InventoryCommon\Model\SourceItem\Option\Meta $optionMeta
     * @param \Psr\Log\LoggerInterface $logger
     * @return void
     */
    public function __construct(
        \Ambros\InventoryCommon\Model\ResourceModel\SourceItem\Option\Delete $resource,
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
        try {
            $this->resource->execute($options);
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage());
            throw new \Magento\Framework\Exception\CouldNotDeleteException(__('Could not delete %1.', $this->optionMeta->getLabel()), $exception);
        }
        return $this;
    }
}