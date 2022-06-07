/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
define([
    'Ambros_Inventory/js/catalog/product/estimate/totals/abstract-total'
], function (Component) {
    'use strict';
    return Component.extend({

        defaults: {
            template: 'Ambros_Inventory/tax/product/estimate/totals/grand-total'
        },
        
        isTaxDisplayedInGrandTotal: window.checkoutConfig.includeTaxInGrandTotal || false,
        
        /**
         * Get value
         * 
         * @param {String} sourceCode
         * @returns {String}
         */
        getValue: function (sourceCode) {
            var price = 0;
            var segment = this.getSourceQuoteTotalsSegment(sourceCode, 'grand_total');
            if (segment) {
                price = segment.value;
            }
            return this.getFormattedPrice(price);
        },
        
        /**
         * Get value excluding tax
         * 
         * @param {String} sourceCode
         * @returns {String}
         */
        getValueExclTax: function (sourceCode) {
            var price = 0;
            var totals = this.getSourceQuoteTotals(sourceCode);
            if (totals) {
                price = totals.grand_total;
            }
            return this.getFormattedPrice(price);
        }
        
    });
});