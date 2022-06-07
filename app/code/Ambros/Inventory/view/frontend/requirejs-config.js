/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
var config = {
    map: {
        '*': {
            priceBox: 'Ambros_Inventory/js/catalog/product/price-box'
        }
    },
    config: {
        mixins: {
            'Magento_Bundle/js/price-bundle': {
                'Ambros_Inventory/js/bundle/price-bundle-mixin': true
            },
            'Magento_ConfigurableProduct/js/configurable': {
                'Ambros_Inventory/js/configurable-product/configurable-mixin': true
            },
            'Magento_Swatches/js/swatch-renderer': {
                'Ambros_Inventory/js/swatches/swatch-renderer-mixin': true
            },
            
            'Magento_Checkout/js/action/select-shipping-method': {
                'Ambros_Inventory/js/checkout/action/select-shipping-method-mixin': true
            },
            'Magento_Checkout/js/model/quote': {
                'Ambros_Inventory/js/checkout/model/quote-mixin': true
            },
            'Magento_Checkout/js/model/checkout-data-resolver': {
                'Ambros_Inventory/js/checkout/model/checkout-data-resolver-mixin': true
            },
            'Magento_Checkout/js/view/cart/shipping-rates': {
                'Ambros_Inventory/js/checkout/view/cart/shipping-rates-mixin': true
            },
            'Magento_Checkout/js/view/shipping': {
                'Ambros_Inventory/js/checkout/view/shipping-mixin': true
            },
            'Magento_Checkout/js/view/shipping-information': {
                'Ambros_Inventory/js/checkout/view/shipping-information-mixin': true
            },
            'Magento_Checkout/js/view/summary/shipping': {
                'Ambros_Inventory/js/checkout/view/summary/shipping-mixin': true
            },
            'Magento_Checkout/js/checkout-data': {
                'Ambros_Inventory/js/checkout/checkout-data-mixin': true
            },
            'Magento_Paypal/js/order-review': {
                'Ambros_Inventory/js/paypal/order-review-mixin': true
            }
        }
    }
};