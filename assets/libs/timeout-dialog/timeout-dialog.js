String.prototype.format=function(){var s=this,i=arguments.length;while(i--){s=s.replace(new RegExp('\\{'+i+'\\}','gm'),arguments[i]);}return s;};!function($){$.timeoutDialog=function(options){var settings={timeout:1200,countdown:60,div_modal_alerta:'div_modal_alerta',div_modal_logout:'div_modal_logout',title:'Your session is about to expire!',message:'You will be logged out in {0} seconds.',question:'Do you want to stay signed in?',keep_alive_button_text:'Yes, Keep me signed in',sign_out_button_text:'No, Sign me out',keep_alive_url:'/keep-alive',logout_url:null,logout_redirect_url:'/',restart_on_yes:true,dialog_width:350}
$.extend(settings,options);var TimeoutDialog={init:function(){this.setupDialogTimer();},setupDialogTimer:function(){var self=this;window.setTimeout(function(){self.setupDialog();},(settings.timeout-settings.countdown)*1000);},setupDialog:function(){var self=this;self.destroyDialog();$("#"+settings.div_modal_alerta).modal({closable:false,onDeny:function(){self.signOut(true);return false;},onApprove:function(){self.keepAlive();}}).modal('show');self.startCountdown();},destroyDialog:function(){$("#"+settings.div_modal_alerta).modal('hide');},startCountdown:function(){var self=this,counter=settings.countdown;this.countdown=window.setInterval(function(){counter-=1;$("#timeout-countdown").html(counter);if(counter<=0){window.clearInterval(self.countdown);self.signOut(false);}},1000);},keepAlive:function(){var self=this;this.destroyDialog();window.clearInterval(this.countdown);$.post(settings.keep_alive_url,{hdnEntidade:"Usuario",hdnAcao:"renovarSessao"},function(resposta){if(resposta.resultado==1){if(settings.restart_on_yes){self.setupDialogTimer();}}else{self.signOut(false);}},"json");},signOut:function(is_forced){var self=this;this.destroyDialog();if(settings.logout_url!=null){$.post(settings.keep_alive_url,{hdnEntidade:"Usuario",hdnAcao:"logout"},function(resposta){self.redirectLogout(is_forced);},"json");}else{self.redirectLogout(is_forced);}},redirectLogout:function(is_forced){var target=settings.logout_redirect_url;$("#"+settings.div_modal_logout).modal({closable:true,onHidden:function(){window.location=target;}}).modal('show');}};TimeoutDialog.init();};}(window.jQuery);