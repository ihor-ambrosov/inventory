/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
define([
    'Ambros_Inventory/js/catalog/product/product'
], function (product) {
    'use strict';
    
    return {
        
        /**
         * Get form
         * 
         * @returns {jQuery}
         */
        getForm: function () {
            return product.getForm();
        },
        
        /**
         * Get element
         * 
         * @returns {jQuery}
         */
        getElement: function () {
            return this.getForm().find('[name="source"]');
        },
        
        /**
         * Get value
         * 
         * @returns {String}
         */
        getValue: function () {
            return this.getElement().filter(':checked').val();
        },
        
        /**
         * On change
         * 
         * @param {Function} handler
         * @returns {Object}
         */
        onChange: function (handler) {
            this.getElement().on('change', handler);
            return this;
        }
        
    };
    
});