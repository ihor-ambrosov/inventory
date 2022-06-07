<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Wrapper\Model\Framework;

/**
 * Source wrapper
 */
class Source extends \Ambros\Common\DataObject\Wrapper
{
    /**
     * Default source provider
     * 
     * @var \Magento\InventoryCatalogApi\Api\DefaultSourceProviderInterface
     */
    private $defaultSourceProvider;

    /**
     * Constructor
     * 
     * @param \Ambros\Common\DataObject\ReflectionFactory $objectReflectionFactory
     * @param \Magento\InventoryCatalogApi\Api\DefaultSourceProviderInterface $defaultSourceProvider
     * @return void
     */
    public function __construct(
        \Ambros\Common\DataObject\ReflectionFactory $objectReflectionFactory,
        \Magento\InventoryCatalogApi\Api\DefaultSourceProviderInterface $defaultSourceProvider
    )
    {
        parent::__construct($objectReflectionFactory);
        $this->defaultSourceProvider = $defaultSourceProvider;
    }
    
    /**
     * Set source code
     * 
     * @param string|null $sourceCode
     * @return void
     */
    public function setSourceCode(string $sourceCode = null): void
    {
        $this->getObject()->getExtensionAttributes()->setSourceCode($sourceCode);
    }
    
    /**
     * Get source code
     * 
     * @return string|null
     */
    public function getSourceCode(): ?string
    {
        $sourceCode = $this->getObject()->getExtensionAttributes()->getSourceCode();
        if ($sourceCode) {
            return $sourceCode;
        } else {
            return $this->defaultSourceProvider->getCode();
        }
    }
}