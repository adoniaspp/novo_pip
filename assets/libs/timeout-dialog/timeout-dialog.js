/*
 * timeout-dialog.js v1.0.1, 01-03-2012
 * 
 * @author: Rodrigo Neri (@rigoneri)
 * 
 * (The MIT License)
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE. 
 */


/* String formatting, you might want to remove this if you already use it.
 * Example:
 * 
 * var location = 'World';
 * alert('Hello {0}'.format(location));
 */
String.prototype.format = function () {
    var s = this,
            i = arguments.length;

    while (i--) {
        s = s.replace(new RegExp('\\{' + i + '\\}', 'gm'), arguments[i]);
    }
    return s;
};

!function ($) {
    $.timeoutDialog = function (options) {

        var settings = {
            timeout: 1200,
            countdown: 60,
            div_modal_alerta: 'div_modal_alerta',
            div_modal_logout: 'div_modal_logout',
            title: 'Your session is about to expire!',
            message: 'You will be logged out in {0} seconds.',
            question: 'Do you want to stay signed in?',
            keep_alive_button_text: 'Yes, Keep me signed in',
            sign_out_button_text: 'No, Sign me out',
            keep_alive_url: '/keep-alive',
            logout_url: null,
            logout_redirect_url: '/',
            restart_on_yes: true,
            dialog_width: 350
        }

        $.extend(settings, options);

        var TimeoutDialog = {
            init: function () {
                this.setupDialogTimer();
            },
            setupDialogTimer: function () {
                var self = this;
                window.setTimeout(function () {
                    self.setupDialog();
                }, (settings.timeout - settings.countdown) * 1000);
            },
            setupDialog: function () {
                var self = this;
                self.destroyDialog();
                /*
                 $('<div id="timeout-dialog">' +
                 '<p id="timeout-message">' + settings.message.format('<span id="timeout-countdown">' + settings.countdown + '</span>') + '</p>' + 
                 '<p id="timeout-question">' + settings.question + '</p>' +
                 '</div>')
                 .appendTo('body')
                 .dialog({
                 modal: true,
                 width: settings.dialog_width,
                 minHeight: 'auto',
                 zIndex: 10000,
                 closeOnEscape: false,
                 draggable: false,
                 resizable: false,
                 dialogClass: 'timeout-dialog',
                 title: settings.title,
                 buttons : {
                 'keep-alive-button' : { 
                 text: settings.keep_alive_button_text,
                 id: "timeout-keep-signin-btn",
                 click: function() {
                 self.keepAlive();
                 }
                 },
                 'sign-out-button' : {
                 text: settings.sign_out_button_text,
                 id: "timeout-sign-out-button",
                 click: function() {
                 self.signOut(true);
                 }
                 }
                 }
                 });
                 */

                $("#" + settings.div_modal_alerta).modal({
                    closable: false,
                    onDeny: function () {
                        self.signOut(true);
                        return false;
                    },
                    onApprove: function () {
                        self.keepAlive();
                    }
                }).modal('show');
                /*
                 
                 $('.coupled.modal').modal({allowMultiple: false, closable: false});
                 // show first now
                 $('.first.modal').modal({
                 closable: false,
                 onDeny: function () {
                 self.signOut(true);
                 return false;
                 },
                 onApprove: function () {
                 self.keepAlive();
                 }
                 }).modal('show');
                 
                 */

                self.startCountdown();
            },
            destroyDialog: function () {
//                if ($("#timeout-dialog").length) {
//                    $(this).dialog("close");
//                    $('#timeout-dialog').remove();
//                }
                $("#" + settings.div_modal_alerta).modal('hide');
//                $('.second.modal').modal('show')
//                        .modal({
//                            onHidden: function () {
//                                window.alert('Wait not yet!');
//                                return false;
//                            }});

                /*
                 if (settings.logout_url != null) {
                 $.post(settings.logout_url, function (data) {
                 self.redirectLogout(is_forced);
                 });
                 }
                 else {
                 self.redirectLogout(is_forced);
                 }
                 */

            },
            startCountdown: function () {
                var self = this, counter = settings.countdown;

                this.countdown = window.setInterval(function () {
                    counter -= 1;
                    $("#timeout-countdown").html(counter);

                    if (counter <= 0) {
                        window.clearInterval(self.countdown);
                        self.signOut(false);
                    }

                }, 1000);
            },
            keepAlive: function () {
                var self = this;
                this.destroyDialog();
                window.clearInterval(this.countdown);

                $.post(settings.keep_alive_url, {hdnEntidade: "Usuario", hdnAcao: "renovarSessao"}, function (resposta) {
                    if (resposta.resultado == 1) {
                        if (settings.restart_on_yes) {
                            self.setupDialogTimer();
                        }
                    }
                    else {
                        self.signOut(false);
                    }
                }, "json");
            },
            signOut: function (is_forced) {
                var self = this;
                //alert('Você foi deslogado! \n ...redirecionando...');

                this.destroyDialog();
                if (settings.logout_url != null) {
                    $.post(settings.keep_alive_url, {hdnEntidade: "Usuario", hdnAcao: "logout"}, function (resposta) {
                        self.redirectLogout(is_forced);
                    }, "json");
                }
                else {
                    self.redirectLogout(is_forced);
                }

            },
            redirectLogout: function (is_forced) {
                var target = settings.logout_redirect_url;// + '?next=' + encodeURIComponent(window.location.pathname + window.location.search);
                //if (!is_forced)
                //    target += '&timeout=t';
                $("#" + settings.div_modal_logout).modal({
                    closable: true,
                    onHidden: function () {
                        //alert('bla');
                        window.location = target;
                    }
                }).modal('show');
            }
        };

        TimeoutDialog.init();
    };
}(window.jQuery);