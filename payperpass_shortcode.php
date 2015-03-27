<?php

class Payperpass_Shortcode{

    public function __construct()
    {
        add_shortcode('payperpass', array($this, 'payperpass_shortcode'));
        add_shortcode('payperpass_security', 'ppp_security_shortcode');
        add_action('init', array($this, 'payperpass_add_buttons'));
    }

    function payperpass_shortcode($atts, $content){

        $atts = shortcode_atts(array(
            'idproduit'=>'',
            'idservice'=>'',
            'theme'=>'light'
        ), $atts);
        extract($atts);

        return $content.
        '<style>
            @media screen and (max-width:1024px){.embed-container {min-height: 500px;	min-width: 415px;}}
            @media screen and (min-width:1024px){.embed-container {min-height: 570px;	min-width: 565px;}}
            .embed-container{display:block; position: relative;overflow: hidden;}
            .embed-container iframe{position: absolute;top: 0;left: 0;width: 100%;height: 100%;}
        </style>
        <div class="embed-container">
            <iframe src="https://paiement.payperpass.eu/?p='.$idproduit.'&s='.$idservice.'&theme='.$theme.'" height="580" width="550" frameborder="0" marginwidth="0" marginheight="0" scrolling="no"></iframe>
        </div>';
    }

    function ppp_security_shortcode($atts, $content){

        $atts = shortcode_atts(array(
            'idproduit'=>'',
            'idservice'=>'',
            'theme'=>'light'
        ), $atts);
        extract($atts);
        return $content.
        '<noscript><meta http-equiv="Refresh" content="0; url=https://paiement.payperpass.eu/verifPaiement.aspx?codeErreur=600"/></noscript>
	    <script src="https://paiement.payperpass.eu/verifPaiement.aspx?p='.$idproduit.'&s='.$idservice.'" langage="javascript"></script>';
    }

    function payperpass_add_buttons(){
        if(current_user_can('edit_posts') && current_user_can('edit_pages')){
            add_filter('mce_external_plugins', array($this, 'payperpass_add_plugins'));
            add_filter('mce_buttons', array($this, 'payperpass_register_buttons'));

            //	Output the JavaScript
            ?>
            <script type='text/javascript'>
                var PPP_Data = {
                    'apikey': '<?php echo get_option('payperpass_ppp_apikey'); ?>'
                }
            </script>
        <?php
        }
    }

    function payperpass_add_plugins($plugins){
        $plugins['payperpass'] = plugins_url('assets/js/payperpass.js',__FILE__ );
        $plugins['payperpass_paiement'] = plugins_url('assets/js/payperpass.js',__FILE__ );
        return $plugins;
    }

    function payperpass_register_buttons($buttons){
        array_push($buttons,'payperpass');
        array_push($buttons,'payperpass_paiement');
        return $buttons;
    }
}