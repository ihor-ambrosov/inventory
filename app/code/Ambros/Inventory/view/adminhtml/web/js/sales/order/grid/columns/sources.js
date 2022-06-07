/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
define([
    'Magento_Ui/js/grid/columns/column'
], function (Column) {
    'use strict';

    return Column.extend({
        defaults: {
            bodyTmpl: 'Ambros_Inventory/sales/order/grid/columns/sources.html',
            itemsToDisplay: 5
        },

        /**
         * @param {Array} record
         * @returns {Array}
         */
        getTooltipData: function (record) {
            return record[this.index];
        },

        /**
         * @param {Object} record - Record object
         * @returns {Array} Result array
         */
        getSources: function (record) {
            return this.getTooltipData(record).slice(0, this.itemsToDisplay);
        }
    });
});