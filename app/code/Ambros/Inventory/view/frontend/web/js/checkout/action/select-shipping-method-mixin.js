/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
define([
    'Magento_Checkout/js/model/quote',
], function (quote) {
    'use strict';
    
    return function () {
        return function (shippingMethod) {
            if (shippingMethod) {
                quote.setSourceShippingMethod(shippingMethod.extension_attributes.source_code, shippingMethod);
            }
        };
    };
});