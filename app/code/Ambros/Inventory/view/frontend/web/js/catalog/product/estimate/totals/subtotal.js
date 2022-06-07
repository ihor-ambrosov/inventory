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
            template: 'Ambros_Inventory/catalog/product/estimate/totals/subtotal'
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
            if (totals) {
                price = totals.subtotal;
            }
            return this.getFormattedPrice(price);
        }
        
    });
});