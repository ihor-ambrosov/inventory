<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Model\Catalog\Product;

/**
 * Product cart configuration plugin
 */
class CartConfiguration
{
    /**
     * Around is product configured
     *
     * @param \Magento\Catalog\Model\Product\CartConfiguration $subject
     * @param callable $proceed
     * @param \Magento\Catalog\Model\Product $product
     * @param array $config
     * @return bool
     */
    public function aroundIsProductConfigured(
        \Magento\Catalog\Model\Product\CartConfiguration $subject,
        \Closure $proceed,
        \Magento\Catalog\Model\Product $product,
        $config
    )
    {
        if (!isset($config['options']) && !$product->getRequiredOptions()) {
            $config['options'] = [];
        }
        return $proceed($product, $config) && !empty($config['source']);
    }
}