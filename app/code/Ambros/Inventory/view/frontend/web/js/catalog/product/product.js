/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
define([
    'jquery',
    'Ambros_Common/js/jquery-serialize-json'
], function ($) {
    'use strict';
    
    var formElement = $('.product-add-form form').get(0);
    
    return {
        
        /**
         * Get form
         * 
         * @returns {jQuery}
         */
        getForm: function () {
            return $(formElement);
        },
        
        /**
         * Get JSON
         * 
         * @returns {Object}
         */
        getJson: function () {
            return $(formElement).serializeJson();
        },
        
        /**
         * Check if is valid
         * 
         * @returns {Boolean}
         */
        isValid: function () {
            return $(formElement).valid();
        }
        
    };
});