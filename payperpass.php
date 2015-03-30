<?php
/*
Plugin Name: Payperpass
Description: Monétisez votre site avec la solution de micropaiement payperpass. Simple, sécurisé et gratuit, sans connaissances techniques particulières.
Version: 0.1
License: GNU
License URI: http://www.gnu.org/licenses/licenses.fr.html
Author: payperpass
Author URI: http://payperpass.eu
Plugin URI: http://payperpass.eu/plugins-payperpass-pour-wordpress/
*/

class Payperpass_Plugin{

    public function __construct()
    {
        include_once plugin_dir_path( __FILE__ ).'payperpass_shortcode.php';
        new Payperpass_Shortcode();

        add_action('admin_menu', array($this, 'payperpass_add_admin_menu'));
        add_action('admin_init', array($this, 'payperpass_register_settings'));

    }

    public function payperpass_add_admin_menu()
    {
        add_menu_page('Plugin Payperpass', 'Payperpass', 'manage_options', 'payperpass', array($this, 'payperpass_menu_html'), plugins_url('assets/images/ppp.png',__FILE__ ));
        add_submenu_page('payperpass', 'Plugins Payperpass', 'Payperpass', 'manage_options', 'payperpass', array($this, 'payperpass_menu_html'));
    }

    public function payperpass_menu_html()
    {
        echo '<h1>'.get_admin_page_title().'</h1>';

        if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] == true ) {
            echo "<div class='updated'><p>Votre API Key a été correctement enregistrée.</p></div>";
        }
        ?>
        <form method="post" action="options.php">
            <?php settings_fields('payperpass_settings') ?>
            <?php do_settings_sections('payperpass_settings') ?>
            <?php submit_button(); ?>
        </form>
        Plus d'informations sur <a href="http://www.payperpass.eu/plugins-payperpass-pour-wordpress/">la page du Plugin</a>.
    <?php
    }

    public function payperpass_register_settings()
    {
        register_setting('payperpass_settings', 'payperpass_ppp_apikey');

        add_settings_section('payperpass_section', 'Paramètres Payperpass', array($this, 'payperpass_section_html'), 'payperpass_settings');
        add_settings_field('payperpass_ppp_apikey', 'Payperpass API Key', array($this, 'payperpass_ppp_apikey_html'), 'payperpass_settings', 'payperpass_section');
    }
    
    public function payperpass_section_html()
    {
        echo 'Renseignez l\'API Key associé à votre compte Payperpass.';
    }

    public function payperpass_ppp_apikey_html()
    {?>
        <input type="text" name="payperpass_ppp_apikey" placeholder="Votre API Key Payperpass pour Wordpress" value="<?php echo get_option('payperpass_ppp_apikey')?>" style="min-width: 20px; width: 50%;"/>
        <p class="help"><a target="_blank" href="http://client.payperpass.eu/espaceClient/ficheClient.aspx">Obtenez votre API Key pour Wordpress ici.</a></p>
    <?php
    }
}

new Payperpass_Plugin();