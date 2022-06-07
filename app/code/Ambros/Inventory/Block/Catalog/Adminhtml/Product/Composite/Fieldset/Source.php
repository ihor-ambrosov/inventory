<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Block\Catalog\Adminhtml\Product\Composite\Fieldset;

/**
 * Product source block
 */
class Source extends \Ambros\Inventory\Block\Catalog\Product\View\Source
{
    /**
     * Get current sources
     * 
     * @var \Ambros\InventoryCommon\Model\GetCurrentSources 
     */
    private $getCurrentSources;

    /**
     * Quote session
     * 
     * @var \Magento\Backend\Model\Session\Quote
     */
    private $quoteSession;

    /**
     * Constructor
     * 
     * @param \Magento\Catalog\Block\Product\Context $context
     * @param \Magento\Framework\Url\EncoderInterface $urlEncoder
     * @param \Magento\Framework\Json\EncoderInterface $jsonEncoder
     * @param \Magento\Framework\Stdlib\StringUtils $string
     * @param \Magento\Catalog\Helper\Product $productHelper
     * @param \Magento\Catalog\Model\ProductTypes\ConfigInterface $productTypeConfig
     * @param \Magento\Framework\Locale\FormatInterface $localeFormat
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
     * @param \Ambros\InventoryCommon\Model\GetSourceBySourceCode $getSourceBySourceCode
     * @param \Ambros\InventoryCommon\Model\GetCurrentSources $getCurrentSources
     * @param \Ambros\Inventory\Model\InventorySales\GetCurrentSalableSourceItems $getCurrentSalableSourceItems
     * @param \Magento\Backend\Model\Session\Quote $quoteSession
     * @param array $data
     * @return void
     */
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Url\EncoderInterface $urlEncoder,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Magento\Framework\Stdlib\StringUtils $string,
        \Magento\Catalog\Helper\Product $productHelper,
        \Magento\Catalog\Model\ProductTypes\ConfigInterface $productTypeConfig,
        \Magento\Framework\Locale\FormatInterface $localeFormat,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        \Ambros\InventoryCommon\Model\GetSourceBySourceCode $getSourceBySourceCode,
        \Ambros\InventoryCommon\Model\GetCurrentSources $getCurrentSources,
        \Ambros\Inventory\Model\InventorySales\GetCurrentSalableSourceItems $getCurrentSalableSourceItems,
        \Magento\Backend\Model\Session\Quote $quoteSession,
        array $data = []
    )
    {
        $this->getCurrentSources = $getCurrentSources;
        $this->quoteSession = $quoteSession;
        parent::__construct(
            $context,
            $urlEncoder,
            $jsonEncoder,
            $string,
            $productHelper,
            $productTypeConfig,
            $localeFormat,
            $customerSession,
            $productRepository,
            $priceCurrency,
            $getSourceBySourceCode,
            $getCurrentSalableSourceItems,
            $data
        );
    }
    
    /**
     * Get sources
     * 
     * @return array
     */
    public function getSources(): array
    {
        $storeId = (int) $this->quoteSession->getStore()->getId();
        return $this->getCurrentSources->execute($storeId);
    }
}