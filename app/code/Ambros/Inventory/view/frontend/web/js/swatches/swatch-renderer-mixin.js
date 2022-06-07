/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
define([
    'jquery',
    'Ambros_Inventory/js/catalog/product/source',
    'jquery/ui'
], function ($, source) {
    'use strict';
    
    return function (target) {
        
        $.widget('mage.SwatchRenderer', target, {
            
            /**
             * Create
             * 
             * @returns {Object}
             */
            _create: function () {
                this._super();
                source.onChange(this.onSourceChange.bind(this));
                this.changeSource();
                return this;
            },

            /**
             * On source change
             * 
             * @returns {Object}
             */
            onSourceChange: function () {
                this.changeSource();
                return this;
            },
            
            /**
             * Set options prices
             * 
             * @returns {Object}
             */
            setOptionsPrices: function () {
                var sourceCode = source.getValue();
                if (
                    sourceCode && 
                    this.options.jsonConfig && 
                    this.options.jsonConfig.sourceOptionPrices && 
                    sourceCode in this.options.jsonConfig.sourceOptionPrices
                ) {
                    this.options.jsonConfig.optionPrices = this.options.jsonConfig.sourceOptionPrices[sourceCode];
                }
                return this;
            },
            
            /**
             * Change source
             * 
             * @returns {Object}
             */
            changeSource: function () {
                this.setOptionsPrices();
                this._UpdatePrice();
            }
            
        });
        return $.mage.SwatchRenderer;
    };
});