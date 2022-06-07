/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
define([
    'Ambros_Inventory/js/catalog/product/estimate/totals/shipping'
], function (Component) {
    'use strict';
    
    var displayMode = window.checkoutConfig.reviewShippingDisplayMode;
    
    return Component.extend({

        defaults: {
            displayMode: displayMode,
            template: 'Ambros_Inventory/tax/product/estimate/totals/shipping'
        },
        
        /**
         * Check if is both prices displayed
         * 
         * @returns {Boolean}
         */
        isBothPricesDisplayed: function () {
            return this.displayMode === 'both';
        },
        
        /**
         * Check if is including displayed
         * 
         * @returns {Boolean}
         */
        isIncludingDisplayed: function () {
            return this.displayMode === 'including';
        },
        
        /**
         * Check if is excluding displayed
         * 
         * @returns {Boolean}
         */
        isExcludingDisplayed: function () {
            return this.displayMode === 'excluding';
        },
        
        /**
         * Get including value
         * 
         * @param {String} sourceCode
         * @returns {String}
         */
        getIncludingValue: function (sourceCode) {
            if (!this.isCalculated(sourceCode)) {
                return this.notCalculatedMessage;
            }
            var price = 0;
            var totals = this.getSourceQuoteTotals(sourceCode);
            if (totals) {
                price = totals.shipping_incl_tax;
            }
            return this.getFormattedPrice(price);
        },
        
        /**
         * Get excluding value
         * 
         * @param {String} sourceCode
         * @returns {String}
         */
        getExcludingValue: function (sourceCode) {
            if (!this.isCalculated(sourceCode)) {
                return this.notCalculatedMessage;
            }
            var price = 0;
            var totals = this.getSourceQuoteTotals(sourceCode);
            if (totals) {
                price = totals.shipping_amount;
            }
            return this.getFormattedPrice(price);
        }
        
    });
});