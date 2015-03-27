(function($) {
    var apikey = PPP_Data['apikey'];

    tinymce.create('tinymce.plugins.payperpass',{
        init : function(ed,url){
            ed.addButton('payperpass', {
                title : 'Ajouter un iframe Payperpass',
                image : url + '/../images/ppp.png',
                cmd: 'ppp_shortcode_cmd'
            });
            ed.addCommand('ppp_shortcode_cmd',function() {
                ed.windowManager.open(
                    //	Window Properties
                    {
                        file: url + '/../../payperpass_dialog.html',
                        title: 'Choisissez votre produit:',
                        width: 600,
                        height: 645,
                        inline: 1
                    },
                    //	Windows Parameters/Arguments
                    {
                        apikey: apikey,
                        shortcode: 'payperpass',

                        editor: ed,
                        jquery: $ // PASS JQUERY
                    }
                );
            });
            ed.addButton('payperpass_paiement', {
                title : 'Ajouter le script de sécurité Payperpass',
                image : url + '/../images/ppp_secur.png',
                cmd: 'ppps_shortcode_cmd'
            });
            ed.addCommand('ppps_shortcode_cmd',function() {
                ed.windowManager.open(
                    //	Window Properties
                    {
                        file: url + '/../../payperpass_dialog.html',
                        title: 'Choisissez votre produit:',
                        width: 600,
                        height: 645,
                        inline: 1
                    },
                    //	Windows Parameters/Arguments
                    {
                        apikey: apikey,
                        shortcode: 'payperpass_security',

                        editor: ed,
                        jquery: $ // PASS JQUERY
                    }
                );
            });
        },
        createControl : function(n,cm){
            return null;
        }
    });
    tinymce.PluginManager.add('payperpass', tinymce.plugins.payperpass);
})(jQuery);
