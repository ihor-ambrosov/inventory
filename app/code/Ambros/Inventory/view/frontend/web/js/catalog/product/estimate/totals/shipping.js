/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
define([
    'Ambros_Inventory/js/catalog/product/estimate/totals/abstract-total',
    'Ambros_Inventory/js/catalog/product/estimate/data',
    'Magento_Checkout/js/model/quote'
], function (Component, data, quote) {
    'use strict';
    return Component.extend({

        defaults: {
            template: 'Ambros_Inventory/catalog/product/estimate/totals/shipping'
        },
        quoteIsVirtual: quote.isVirtual(),
        
        /**
         * Check if is calculated
         * 
         * @param {String} sourceCode
         * @returns {Boolean}
         */
        isCalculated: function (sourceCode) {
            return (data.getSourceQuoteShippingMethod(sourceCode)) ? true : false;
        },
        
        /**
         * Get value
         * 
         * @param {String} sourceCode
         * @returns {String}
         */
        getValue: function (sourceCode) {
            var price = 0;
            var totals = this.getSourceQuoteTotals(sourceCode);
            if (this.isCalculated(sourceCode) && totals) {
                price = totals.shipping_amount;
            }
            return this.getFormattedPrice(price);
        }
        
    });
});