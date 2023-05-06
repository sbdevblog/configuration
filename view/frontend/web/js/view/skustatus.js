/**
 * @copyright Copyright (c) sbdevblog (http://www.sbdevblog.com)
 */

define([
    "jquery",
    "jquery/ui",
    'Magento_Ui/js/modal/alert'
], function ($, ui, alert) {
    "use strict";
    $.widget('sbdevblog.skustatus', {
        options: {
            postcode: 'postcode',
            triggerEvent: 'click'
        },
        _create: function () {
            this._bind();
        },
        _bind: function () {
            var self = this;
            self.element.on(self.options.triggerEvent, function () {
                self._checkStatus();
            });
        },
        _checkStatus: function () {
            if (this.options.skuConfig.length === 0) {
                this._showAlert("Something is wrong!", "Please contact support team");
                return;
            }
            let postcode = $("#" + this.options.postcode).val();
            if (!postcode || postcode === undefined) {
                this._showAlert("Invalid Request", "Please Enter Postcode");
                return;
            }
            let self = this;
            let result = $.map(this.options.skuConfig, function (value, index) {
                if (value.postcode.toString() === postcode.toString() && value.sku.toString() === self.options.productSku.toString()) {
                    return value;
                }
            });
            let title = 'Availability of the product: ' + self.options.productSku;
            let msg = result.length > 0 ? "Congrats, Total " + result[0].qty + " qty available in your region " + +postcode : "Sorry, Product is not available in your region " + postcode;
            this._showAlert(title, msg);
        },
        _showAlert: function (title, msg) {
            alert({
                title: title,
                content: msg,
                actions: {
                    always: function () {
                    }
                }
            });
        }
    });
    return $.sbdevblog.skustatus;
});
