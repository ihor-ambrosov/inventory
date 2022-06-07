<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Block\Inventory\Source;

/**
 * Source switcher block
 */
class Switcher extends \Magento\Backend\Block\Template
{
    /**
     * Template
     *
     * @var string
     */
    protected $_template = 'Ambros_Inventory::inventory/source/switcher.phtml';

    /**
     * Current source provider
     * 
     * @var \Ambros\InventoryCommon\Api\CurrentSourceProviderInterface
     */
    private $currentSourceProvider;
    
    /**
     * Get source by source code
     * 
     * @var \Ambros\InventoryCommon\Model\GetSourceBySourceCode
     */
    private $getSourceBySourceCode;

    /**
     * Get sources
     * 
     * @var \Ambros\InventoryCommon\Model\GetSources
     */
    private $getSources;

    /**
     * Constructor
     * 
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Ambros\InventoryCommon\Api\CurrentSourceProviderInterface $currentSourceProvider
     * @param \Ambros\InventoryCommon\Model\GetSourceBySourceCode $getSourceBySourceCode
     * @param \Ambros\InventoryCommon\Model\GetSources $getSources
     * @param array $data
     * @return void
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Ambros\InventoryCommon\Api\CurrentSourceProviderInterface $currentSourceProvider,
        \Ambros\InventoryCommon\Model\GetSourceBySourceCode $getSourceBySourceCode,
        \Ambros\InventoryCommon\Model\GetSources $getSources,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->currentSourceProvider = $currentSourceProvider;
        $this->getSourceBySourceCode = $getSourceBySourceCode;
        $this->getSources = $getSources;
    }

    /**
     * Initialize
     * 
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setUseConfirm(true);
        $this->setUseAjax(true);
        $this->setDefaultOptionLabel(__('All Sources'));
    }

    /**
     * Get sources
     *
     * @return \Magento\InventoryApi\Api\Data\SourceInterface[]
     */
    public function getSources(): array
    {
        return $this->getSources->execute();
    }

    /**
     * Get current source code
     * 
     * @return string|null
     */
    public function getCurrentSourceCode(): ?string
    {
        return $this->currentSourceProvider->getSourceCode();
    }
    
    /**
     * Get current source
     * 
     * @return \Magento\InventoryApi\Api\Data\SourceInterface|null
     */
    public function getCurrentSource(): ?\Magento\InventoryApi\Api\Data\SourceInterface
    {
        $currentSourceCode = $this->getCurrentSourceCode();
        return $currentSourceCode ? $this->getSourceBySourceCode->execute($currentSourceCode) : null;
    }

    /**
     * Check if default option is available
     * 
     * @return bool
     */
    public function isDefaultOptionAvailable(): bool
    {
        return true;
    }

    /**
     * Get current option label
     * 
     * @return string
     */
    public function getCurrentOptionLabel(): string
    {
        $label = $this->getDefaultOptionLabel();
        $currentSource = $this->getCurrentSource();
        if ($currentSource) {
            $label = $currentSource->getName();
        }
        return $label;
    }

    /**
     * Get switch URL
     * 
     * @return string
     */
    public function getSwitchUrl(): string
    {
        $switchUrl = $this->getData('switch_url');
        if ($switchUrl) {
            return $switchUrl;
        }
        return $this->getUrl('*/*/*', ['_current' => true]);
    }
}