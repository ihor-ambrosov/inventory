<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\App\Framework\Config;

/**
 * Configuration value plugin
 */
class Value extends \Ambros\Common\Plugin\Plugin
{
    /**
     * Current source provider
     * 
     * @var \Ambros\InventoryCommon\Api\CurrentSourceProviderInterface
     */
    private $currentSourceProvider;

    /**
     * Resource
     * 
     * @var \Ambros\Inventory\Model\Config\ResourceModel\Config\Data $resource
     */
    private $resource;

    /**
     * Constructor
     * 
     * @param \Ambros\Common\DataObject\WrapperFactory $wrapperFactory
     * @param \Ambros\InventoryCommon\Api\CurrentSourceProviderInterface $currentSourceProvider
     * @param \Ambros\Inventory\Model\Config\ResourceModel\Config\Data $resource
     * @return void
     */
    public function __construct(
        \Ambros\Common\DataObject\WrapperFactory $wrapperFactory,
        \Ambros\InventoryCommon\Api\CurrentSourceProviderInterface $currentSourceProvider,
        \Ambros\Inventory\Model\Config\ResourceModel\Config\Data $resource
    )
    {
        parent::__construct($wrapperFactory);
        $this->currentSourceProvider = $currentSourceProvider;
        $this->resource = $resource;
    }

    /**
     * Before load
     * 
     * @param \Magento\Framework\App\Config\Value $subject
     */
    public function beforeLoad(\Magento\Framework\App\Config\Value $subject)
    {
        $this->setSubject($subject);
        $this->initResource();
    }

    /**
     * Before save
     * 
     * @param \Magento\Framework\App\Config\Value $subject
     */
    public function beforeSave(\Magento\Framework\App\Config\Value $subject)
    {
        $this->setSubject($subject);
        $this->initResource();
        $sourceCode = $this->currentSourceProvider->getSourceCode();
        if (!$sourceCode) {
            return;
        }
        $subject->setSourceCode($sourceCode);
    }

    /**
     * Before delete
     * 
     * @param \Magento\Framework\App\Config\Value $subject
     */
    public function beforeDelete(\Magento\Framework\App\Config\Value $subject)
    {
        $this->setSubject($subject);
        $this->initResource();
    }

    /**
     * Initialize resource
     * 
     * @return void
     */
    private function initResource(): void
    {
        $sourceCode = $this->currentSourceProvider->getSourceCode();
        if (!$sourceCode) {
            return;
        }
        $this->setSubjectPropertyValue('_resource', $this->resource);
    }
}