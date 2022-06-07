<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
namespace Ambros\Common\Helper;

/**
 * Product metadata helper
 */
class ProductMetadata extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * Product metadata
     * 
     * @var \Magento\Framework\App\ProductMetadata 
     */
    private $productMetadata;

    /**
     * Constructor
     * 
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\App\ProductMetadata $productMetadata
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\ProductMetadata $productMetadata
    )
    {
        parent::__construct($context);
        $this->productMetadata = $productMetadata;
    }

    /**
     * Get version
     * 
     * @return string
     */
    public function getVersion()
    {
        return $this->productMetadata->getVersion();
    }
}