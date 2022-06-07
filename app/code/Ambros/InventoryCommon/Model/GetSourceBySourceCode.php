<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\InventoryCommon\Model;

/**
 * Get source by source code
 */
class GetSourceBySourceCode
{
    /**
     * Source repository
     * 
     * @var \Magento\InventoryApi\Api\SourceRepositoryInterface
     */
    private $sourceRepository;

    /**
     * Sources
     * 
     * @var array
     */
    private $sources = [];

    /**
     * Constructor
     * 
     * @param \Magento\InventoryApi\Api\SourceRepositoryInterface $sourceRepository
     * @return void
     */
    public function __construct(
        \Magento\InventoryApi\Api\SourceRepositoryInterface $sourceRepository
    )
    {
        $this->sourceRepository = $sourceRepository;
    }
    
    /**
     * Execute
     * 
     * @param string $sourceCode
     * @return \Magento\InventoryApi\Api\Data\SourceInterface|null
     */
    public function execute(string $sourceCode): ?\Magento\InventoryApi\Api\Data\SourceInterface
    {
        if (array_key_exists($sourceCode, $this->sources)) {
            return $this->sources[$sourceCode];
        }
        try {
            $source = $this->sourceRepository->get($sourceCode);
        } catch (\Magento\Framework\Exception\NoSuchEntityException $exception) {
            $source = null;
        }
        return $this->sources[$sourceCode] = $source;
    }
}