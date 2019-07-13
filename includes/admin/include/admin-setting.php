<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

if ( ! function_exists('is_plugin_active')){ include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); }

class Woolentor_Admin_Settings {

    private $settings_api;

    function __construct() {
        $this->settings_api = new Woolentor_Settings_API();

        add_action( 'admin_init', array( $this, 'admin_init' ) );
        add_action( 'admin_menu', array( $this, 'admin_menu' ), 220 );
        add_action( 'wsa_form_bottom_woolentor_general_tabs', array( $this, 'woolentor_html_general_tabs' ) );
        add_action( 'wsa_form_top_woolentor_elements_tabs', array( $this, 'woolentor_html_popup_box' ) );
        add_action( 'wsa_form_bottom_woolentor_themes_library_tabs', array( $this, 'woolentor_html_themes_library_tabs' ) );
        add_action( 'wsa_form_bottom_woolentor_template_library_tabs', array( $this, 'woolentor_html_template_library_tabs' ) );
        
        add_action( 'wsa_form_bottom_woolentor_buy_pro_tabs', array( $this, 'woolentor_html_buy_pro_tabs' ) );

    }

    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->woolentor_admin_get_settings_sections() );
        $this->settings_api->set_fields( $this->woolentor_admin_fields_settings() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    // Plugins menu Register
    function admin_menu() {
        add_menu_page( 
            __( 'WooLentor', 'woolentor' ),
            __( 'WooLentor', 'woolentor' ),
            'manage_options',
            'woolentor',
            array ( $this, 'plugin_page' ),
            // 'dashicons-admin-generic',
            WOOLENTOR_ADDONS_PL_URL.'includes/admin/assets/images/menu-icon.png',
            100
        );
    }

    // Options page Section register
    function woolentor_admin_get_settings_sections() {
        $sections = array(
            
            array(
                'id'    => 'woolentor_general_tabs',
                'title' => esc_html__( 'General', 'woolentor' )
            ),

            array(
                'id'    => 'woolentor_woo_template_tabs',
                'title' => esc_html__( 'WooCommerce Template', 'woolentor' )
            ),

            array(
                'id'    => 'woolentor_elements_tabs',
                'title' => esc_html__( 'Elements', 'woolentor' )
            ),

            array(
                'id'    => 'woolentor_themes_library_tabs',
                'title' => esc_html__( 'Theme Library', 'woolentor' )
            ),

            array(
                'id'    => 'woolentor_template_library_tabs',
                'title' => esc_html__( 'Template Library', 'woolentor' )
            ),

            array(
                'id'    => 'woolentor_buy_pro_tabs',
                'title' => esc_html__( 'Buy Pro', 'woolentor' )
            ),

        );
        return $sections;
    }

    // Options page field register
    protected function woolentor_admin_fields_settings() {

        $settings_fields = array(

            'woolentor_general_tabs' => array(),

            'woolentor_woo_template_tabs' => array(

                array(
                    'name'  => 'enablecustomlayout',
                    'label'  => __( 'Enable / Disable Template Builder', 'woolentor' ),
                    'desc'  => __( 'Enable', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                ),

                array(
                    'name'  => 'shoppageproductlimit',
                    'label' => __( 'Product Limit', 'woolentor' ),
                    'desc' => wp_kses_post( 'You can Handle Shop page product limit.', 'woolentor' ),
                    'min'               => 1,
                    'max'               => 100,
                    'step'              => '1',
                    'type'              => 'number',
                    'sanitize_callback' => 'floatval'
                ),

                array(
                    'name'    => 'singleproductpage',
                    'label'   => __( 'Single Product Template', 'woolentor' ),
                    'desc'    => __( 'You can select Custom Product details layout', 'woolentor' ),
                    'type'    => 'select',
                    'default' => '0',
                    'options' => woolentor_elementor_template()
                ),

                array(
                    'name'    => 'productarchivepage',
                    'label'   => __( 'Product Archive Page Template', 'woolentor' ),
                    'desc'    => __( 'You can select Custom Product Shop page layout', 'woolentor' ),
                    'type'    => 'select',
                    'default' => '0',
                    'options' => woolentor_elementor_template()
                ),

                array(
                    'name'    => 'productcartpagep',
                    'label'   => __( 'Cart Page Template', 'woolentor' ),
                    'desc'    => __( 'You can select Custom cart page layout <span>( Pro )</span>', 'woolentor' ),
                    'type'    => 'select',
                    'default' => '0',
                    'options' => array(
                        'select'=>'Select Template',
                    ),
                    'class'=>'proelement',
                ),

                array(
                    'name'    => 'productcheckoutpagep',
                    'label'   => __( 'Checkout Page Template', 'woolentor' ),
                    'desc'    => __( 'You can select Custom checkout page layout <span>( Pro )</span>', 'woolentor' ),
                    'type'    => 'select',
                    'default' => '0',
                    'options' => array(
                        'select'=>'Select Template',
                    ),
                    'class'=>'proelement',
                ),

                array(
                    'name'    => 'productthankyoupagep',
                    'label'   => __( 'Thank You Page Template', 'woolentor' ),
                    'desc'    => __( 'You can select Custom thank you page layout <span>( Pro )</span>', 'woolentor' ),
                    'type'    => 'select',
                    'default' => '0',
                    'options' => array(
                        'select'=>'Select Template',
                    ),
                    'class'=>'proelement',
                ),

                array(
                    'name'    => 'productmyaccountpagep',
                    'label'   => __( 'My Account Page Template', 'woolentor' ),
                    'desc'    => __( 'You can select Custom my account page layout <span>( Pro )</span>', 'woolentor' ),
                    'type'    => 'select',
                    'default' => '0',
                    'options' => array(
                        'select'=>'Select Template',
                    ),
                    'class'=>'proelement',
                ),

                array(
                    'name'    => 'productmyaccountloginpagep',
                    'label'   => __( 'My Account Login page Template', 'woolentor' ),
                    'desc'    => __( 'You can select Custom my account login page layout <span>( Pro )</span>', 'woolentor' ),
                    'type'    => 'select',
                    'default' => '0',
                    'options' => array(
                        'select'=>'Select Template',
                    ),
                    'class'=>'proelement',
                ),

            ),

            'woolentor_elements_tabs' => array(

                array(
                    'name'  => 'product_tabs',
                    'label'  => __( 'Product Tab', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'universal_product',
                    'label'  => __( 'Universal Product', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'add_banner',
                    'label'  => __( 'Add Banner', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wb_archive_product',
                    'label'  => __( 'Product Archive', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wb_product_title',
                    'label'  => __( 'Product Title', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wb_product_related',
                    'label'  => __( 'Related Product', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wb_product_add_to_cart',
                    'label'  => __( 'Add To Cart Button', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wb_product_additional_information',
                    'label'  => __( 'Additional Information', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wb_product_data_tab',
                    'label'  => __( 'Product data Tab', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wb_product_description',
                    'label'  => __( 'Product Description', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wb_product_short_description',
                    'label'  => __( 'Product Short Description', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wb_product_price',
                    'label'  => __( 'Product Price', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wb_product_rating',
                    'label'  => __( 'Product Rating', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wb_product_reviews',
                    'label'  => __( 'Product Reviews', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wb_product_image',
                    'label'  => __( 'Product Image', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wb_product_upsell',
                    'label'  => __( 'Product Upsell', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wb_product_stock',
                    'label'  => __( 'Product Stock Status', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wb_product_meta',
                    'label'  => __( 'Product Meta Info', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wl_custom_archive_layoutp',
                    'label'  => __( 'Product Archive Layout <span>( Pro )</span>', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_cart_tablep',
                    'label'  => __( 'Product Cart Table <span>( Pro )</span>', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_cart_totalp',
                    'label'  => __( 'Product Cart Total <span>( Pro )</span>', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_cross_sellp',
                    'label'  => __( 'Product Cross Sell <span>( Pro )</span>', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_checkout_additional_formp',
                    'label'  => __( 'Checkout Additional.. <span>( Pro )</span>', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_checkout_billingp',
                    'label'  => __( 'Checkout Billing Form <span>( Pro )</span>', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_checkout_shipping_formp',
                    'label'  => __( 'Checkout Shipping Form <span>( Pro )</span>', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_checkout_paymentp',
                    'label'  => __( 'Checkout Payment <span>( Pro )</span>', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_order_reviewp',
                    'label'  => __( 'Checkout Order Review <span>( Pro )</span>', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_myaccount_dashboardp',
                    'label'  => __( 'Myaccount Dashboard <span>( Pro )</span>', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_myaccount_downloadp',
                    'label'  => __( 'Myaccount Download <span>( Pro )</span>', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_myaccount_edit_accountp',
                    'label'  => __( 'My Account <span>( Pro )</span>', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_myaccount_addressp',
                    'label'  => __( 'Myaccount Address <span>( Pro )</span>', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_myaccount_login_formp',
                    'label'  => __( 'Login Form <span>( Pro )</span>', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_myaccount_register_formp',
                    'label'  => __( 'Register Form <span>( Pro )</span>', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_myaccount_logoutp',
                    'label'  => __( 'Myaccount Logout <span>( Pro )</span>', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_myaccount_orderp',
                    'label'  => __( 'Myaccount Order <span>( Pro )</span>', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_thankyou_orderp',
                    'label'  => __( 'Thankyou Order <span>( Pro )</span>', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_thankyou_customer_address_detailsp',
                    'label'  => __( 'Thankyou Cus.. Address <span>( Pro )</span>', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_thankyou_order_detailsp',
                    'label'  => __( 'Thankyou Order Details <span>( Pro )</span>', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_product_advance_thumbnailsp',
                    'label'  => __( 'Advance Product Image <span>( Pro )</span>', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_social_sherep',
                    'label'  => __( 'Product Social Share <span>( Pro )</span>', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woolentor_table_row pro',
                ),

            ),

            'woolentor_themes_library_tabs' => array(),
            'woolentor_template_library_tabs' => array(),
            'woolentor_buy_pro_tabs' => array(),

        );
        
        return array_merge( $settings_fields );
    }


    function plugin_page() {

        echo '<div class="wrap">';
            echo '<h2>'.esc_html__( 'Woolentor Settings','woolentor' ).'</h2>';
            $this->save_message();
            $this->settings_api->show_navigation();
            $this->settings_api->show_forms();
        echo '</div>';

    }

    function save_message() {
        if( isset($_GET['settings-updated']) ) { ?>
            <div class="updated notice is-dismissible"> 
                <p><strong><?php esc_html_e('Successfully Settings Saved.', 'woolentor') ?></strong></p>
            </div>
            <?php
        }
    }

    // Custom Markup

    // General tab
    function woolentor_html_general_tabs(){
        ob_start();
        ?>
            <div class="woolentor-general-tabs">

                <div class="woolentor-document-section">
                    <div class="woolentor-column">
                        <a href="https://hasthemes.com/blog-category/woolentor/" target="_blank">
                            <img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/video-tutorial.jpg" alt="<?php esc_attr_e( 'Video Tutorial', 'woolentor' ); ?>">
                        </a>
                    </div>
                    <div class="woolentor-column">
                        <a href="https://demo.hasthemes.com/doc/woolentor/index.html" target="_blank">
                            <img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/online-documentation.jpg" alt="<?php esc_attr_e( 'Online Documentation', 'woolentor' ); ?>">
                        </a>
                    </div>
                    <div class="woolentor-column">
                        <a href="https://hasthemes.com/contact-us/" target="_blank">
                            <img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/genral-contact-us.jpg" alt="<?php esc_attr_e( 'Contact Us', 'woolentor' ); ?>">
                        </a>
                    </div>
                </div>

                <div class="different-pro-free">
                    <h3 class="wooolentor-section-title"><?php echo esc_html__( 'WooLentor Free VS WooLentor Pro.', 'woolentor' ); ?></h3>

                    <div class="woolentor-admin-row">
                        <div class="features-list-area">
                            <h3><?php echo esc_html__( 'WooLentor Free', 'woolentor' ); ?></h3>
                            <ul>
                                <li><?php echo esc_html__( '18 Elements', 'woolentor' ); ?></li>
                                <li><?php echo esc_html__( 'Shop Page Builder ( Default Layout )', 'woolentor' ); ?></li>
                                <li class="wldel"><del><?php echo esc_html__( 'Shop Page Builder ( Custom Design )', 'woolentor' ); ?></del></li>
                                <li><?php echo esc_html__( '3 Product Custom Layout', 'woolentor' ); ?></li>
                                <li><?php echo esc_html__( 'Single Product Template Builder', 'woolentor' ); ?></li>
                                <li class="wldel"><del><?php echo esc_html__( 'Single Product Individual Layout', 'woolentor' ); ?></del></li>
                                <li class="wldel"><del><?php echo esc_html__( 'Product Archive Category Wise Individual layout', 'woolentor' ); ?></del></li>
                                <li class="wldel"><del><?php echo esc_html__( 'Cart Page Builder', 'woolentor' ); ?></del></li>
                                <li class="wldel"><del><?php echo esc_html__( 'Checkout Page Builder', 'woolentor' ); ?></del></li>
                                <li class="wldel"><del><?php echo esc_html__( 'Thank You Page Builder', 'woolentor' ); ?></del></li>
                                <li class="wldel"><del><?php echo esc_html__( 'My Account Page Builder', 'woolentor' ); ?></del></li>
                                <li class="wldel"><del><?php echo esc_html__( 'My Account Login page Builder', 'woolentor' ); ?></del></li>
                            </ul>
                            <a class="button button-primary" href="<?php echo esc_url( admin_url() ); ?>/plugin-install.php" target="_blank"><?php echo esc_html__( 'Install Now', 'woolenror' ); ?></a>
                        </div>
                        <div class="features-list-area">
                            <h3><?php echo esc_html__( 'WooLentor Pro', 'woolentor' ); ?></h3>
                            <ul>
                                <li><?php echo esc_html__( '41 Elements', 'woolentor' ); ?></li>
                                <li><?php echo esc_html__( 'Shop Page Builder ( Default Layout )', 'woolentor' ); ?></li>
                                <li><?php echo esc_html__( 'Shop Page Builder ( Custom Design )', 'woolentor' ); ?></li>
                                <li><?php echo esc_html__( '15 Product Custom Layout', 'woolentor' ); ?></li>
                                <li><?php echo esc_html__( 'Single Product Template Builder', 'woolentor' ); ?></li>
                                <li><?php echo esc_html__( 'Single Product Individual Layout', 'woolentor' ); ?></li>
                                <li><?php echo esc_html__( 'Product Archive Category Wise Individual layout', 'woolentor' ); ?></li>
                                <li><?php echo esc_html__( 'Cart Page Builder', 'woolentor' ); ?></li>
                                <li><?php echo esc_html__( 'Checkout Page Builder', 'woolentor' ); ?></li>
                                <li><?php echo esc_html__( 'Thank You Page Builder', 'woolentor' ); ?></li>
                                <li><?php echo esc_html__( 'My Account Page Builder', 'woolentor' ); ?></li>
                                <li><?php echo esc_html__( 'My Account Login page Builder', 'woolentor' ); ?></li>
                            </ul>
                            <a class="button button-primary" href="https://hasthemes.com/plugins/woolentor-pro/" target="_blank"><?php echo esc_html__( 'Buy Now', 'woolenror' ); ?></a>
                        </div>
                    </div>

                </div>

            </div>
        <?php
        echo ob_get_clean();
    }

    // Pop up Box
    function woolentor_html_popup_box(){
        ob_start();
        ?>
            <div id="woolentor-dialog" title="<?php esc_html_e( 'Go Premium', 'woolentor' ); ?>" style="display: none;">
                <div class="wldialog-content">
                    <span><i class="dashicons dashicons-warning"></i></span>
                    <p>
                        <?php
                            echo __('Purchase our','woolentor').' <strong><a href="'.esc_url( 'https://hasthemes.com/plugins/woolentor-pro/' ).'" target="_blank" rel="nofollow">'.__( 'premium version', 'woolentor' ).'</a></strong> '.__('to unlock these pro elements!','woolentor');
                        ?>
                    </p>
                </div>
            </div>

            <script>
                ( function( $ ) {
                    
                    $(function() {
                        $( '.woolentor_table_row.pro,.proelement label' ).click(function() {
                            $( "#woolentor-dialog" ).dialog({
                                modal: true,
                                minWidth: 500,
                                buttons: {
                                    Ok: function() {
                                      $( this ).dialog( "close" );
                                    }
                                }
                            });
                        });
                        $(".woolentor_table_row.pro input[type='checkbox'],.proelement select").attr("disabled", true);
                    });

                } )( jQuery );
            </script>
        <?php
        echo ob_get_clean();
    }

    // Theme Library
    function woolentor_html_themes_library_tabs() {
        ob_start();
        ?>
        <div class="woolentor-themes-laibrary">
            <p><?php echo esc_html__( 'Use Our WooCommerce Theme for your online Store.', 'woolentor' ); ?></p>
            <div class="woolentor-themes-area">
                <div class="woolentor-themes-row">
                    
                    <div class="woolentor-single-theme"><img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/parlo.png" alt="">
                        <div class="woolentor-theme-content">
                            <h3><?php echo esc_html__( 'Parlo - WooCommerce Theme', 'woolentor' ); ?></h3>
                            <a href="http://demo.shrimpthemes.com/1/parlo/" class="woolentor-button" target="_blank"><?php echo esc_html__( 'Preview', 'woolentor' ); ?></a>
                            <a href="https://freethemescloud.com/item/parlo-free-woocommerce-theme/" class="woolentor-button"><?php echo esc_html__( 'Download', 'woolentor' ); ?></a>
                        </div>
                    </div>
                    
                    <div class="woolentor-single-theme"><img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/daniel-home-1.png" alt="">
                        <div class="woolentor-theme-content">
                            <h3><?php echo esc_html__( 'Daniel - WooCommerce Theme', 'woolentor' ); ?> <span><?php echo esc_html__( '( Pro )', 'woolentor' ); ?></span></h3>
                            <a href="http://demo.shrimpthemes.com/2/daniel/" class="woolentor-button" target="_blank"><?php echo esc_html__( 'Preview', 'woolentor' ); ?></a>
                        </div>
                    </div>
                    
                    <div class="woolentor-single-theme"><img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/hurst-home-1.png" alt="">
                        <div class="woolentor-theme-content">
                            <h3><?php echo esc_html__( 'Hurst - WooCommerce Theme', 'woolentor' ); ?> <span><?php echo esc_html__( '( Pro )', 'woolentor' ); ?></span></h3>
                            <a href="http://demo.shrimpthemes.com/4/hurstem/" class="woolentor-button" target="_blank"><?php echo esc_html__( 'Preview', 'woolentor' ); ?></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <?php
        echo ob_get_clean();
    }

    // Template library
    function woolentor_html_template_library_tabs(){
        ob_start();
        ?>
        <div class="woolentor-template-laibrary">
            <h3><?php echo esc_html__( 'Elementor Template Library', 'woolentor' ); ?></h3>
            <p><?php echo esc_html__( 'Use Our Readymade Elementor templates and build your pages easily.', 'woolentor' ); ?></p>

            <div class="woolentor-admin-tab-area">
                <ul class="woolentor-admin-tabs">
                    <li><a class="wlactive" href="#homepage"><?php echo esc_html__( 'Home Page', 'woolentor' ); ?></a></li>
                    <li><a href="#shoppage"><?php echo esc_html__( 'Shop Page', 'woolentor' ); ?></a></li>
                    <li><a href="#productdetailspage"><?php echo esc_html__( 'Product Details Page', 'woolentor' ); ?></a></li>
                    <li><a href="#otherspage"><?php echo esc_html__( 'Others Page', 'woolentor' ); ?></a></li>
                </ul>
            </div>

            <div class="woolentor-admin-tab-pane wlactive" id="homepage">
                <div class="woolentor-template-area">
                    <div class="woolentor-themes-row">

                        <div class="woolentor-single-theme">
                            <img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/parlo-home-1.png" alt="">
                            <div class="woolentor-theme-content">
                                <h3><?php echo esc_html__( 'Home Page One', 'woolentor' ); ?></h3>
                                <a href="http://demo.shrimpthemes.com/1/parlo/" class="woolentor-button" target="_blank"><?php echo esc_html__( 'Preview', 'woolentor' ); ?></a>
                                <a href="https://freethemescloud.com/download/parlo-home-page-one/" class="woolentor-button"><?php echo esc_html__( 'Download', 'woolentor' ); ?></a>
                            </div>
                        </div>

                        <div class="woolentor-single-theme">
                            <img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/parlo-home-2.png" alt="">
                            <div class="woolentor-theme-content">
                                <h3><?php echo esc_html__( 'Home Page Two', 'woolentor' ); ?> <span><?php echo esc_html__( '( Pro )', 'woolentor' ); ?></span></h3>
                                <a href="http://demo.shrimpthemes.com/1/parlo/home-two/?footerlayout=1" class="woolentor-button" target="_blank"><?php echo esc_html__( 'Preview', 'woolentor' ); ?></a>
                            </div>
                        </div>

                        <div class="woolentor-single-theme">
                            <img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/parlo-home-3.png" alt="">
                            <div class="woolentor-theme-content">
                                <h3><?php echo esc_html__( 'Home Page Three', 'woolentor' ); ?> <span><?php echo esc_html__( '( Pro )', 'woolentor' ); ?></span></h3>
                                <a href="http://demo.shrimpthemes.com/1/parlo/home-three/?footerlayout=1" class="woolentor-button" target="_blank"><?php echo esc_html__( 'Preview', 'woolentor' ); ?></a>
                            </div>
                        </div>

                        <div class="woolentor-single-theme">
                            <img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/daniel-home-1.png" alt="">
                            <div class="woolentor-theme-content">
                                <h3><?php echo esc_html__( 'Daniel Home Page One', 'woolentor' ); ?> <span><?php echo esc_html__( '( Pro )', 'woolentor' ); ?></span></h3>
                                <a href="http://demo.shrimpthemes.com/2/daniel/" class="woolentor-button" target="_blank"><?php echo esc_html__( 'Preview', 'woolentor' ); ?></a>
                            </div>
                        </div>

                        <div class="woolentor-single-theme">
                            <img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/daniel-home-2.png" alt="">
                            <div class="woolentor-theme-content">
                                <h3><?php echo esc_html__( 'Daniel Home Page Two', 'woolentor' ); ?> <span><?php echo esc_html__( '( Pro )', 'woolentor' ); ?></span></h3>
                                <a href="http://demo.shrimpthemes.com/2/daniel/home-two/?footer_layout=1" class="woolentor-button" target="_blank"><?php echo esc_html__( 'Preview', 'woolentor' ); ?></a>
                            </div>
                        </div>

                        <div class="woolentor-single-theme">
                            <img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/hurst-home-1.png" alt="">
                            <div class="woolentor-theme-content">
                                <h3><?php echo esc_html__( 'Hurst Home Page One', 'woolentor' ); ?> <span><?php echo esc_html__( '( Pro )', 'woolentor' ); ?></span></h3>
                                <a href="http://demo.shrimpthemes.com/4/hurstem/" class="woolentor-button" target="_blank"><?php echo esc_html__( 'Preview', 'woolentor' ); ?></a>
                            </div>
                        </div>

                        <div class="woolentor-single-theme">
                            <img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/hurst-home-2.png" alt="">
                            <div class="woolentor-theme-content">
                                <h3><?php echo esc_html__( 'Hurst Home Page Two', 'woolentor' ); ?> <span><?php echo esc_html__( '( Pro )', 'woolentor' ); ?></span></h3>
                                <a href="http://demo.shrimpthemes.com/4/hurstem/" class="woolentor-button" target="_blank"><?php echo esc_html__( 'Preview', 'woolentor' ); ?></a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="woolentor-admin-tab-pane" id="shoppage">
                <div class="woolentor-template-area">
                    <div class="woolentor-themes-row">

                        <div class="woolentor-single-theme">
                            <img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/archive-layout-1.png" alt="">
                            <div class="woolentor-theme-content">
                                <h3><?php echo esc_html__( 'Shop Page Style One', 'woolentor' ); ?></h3>
                                <a href="http://demo.wphash.com/woolentor/shop/" class="woolentor-button" target="_blank"><?php echo esc_html__( 'Preview', 'woolentor' ); ?></a>
                                <a href="https://freethemescloud.com/download/woolentor-shop-page-one/" class="woolentor-button"><?php echo esc_html__( 'Download', 'woolentor' ); ?></a>
                            </div>
                        </div>

                        <div class="woolentor-single-theme">
                            <img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/archive-layout-2.png" alt="">
                            <div class="woolentor-theme-content">
                                <h3><?php echo esc_html__( 'Shop Page Style Two', 'woolentor' ); ?> <span><?php echo esc_html__( '( Pro )', 'woolentor' ); ?></span></h3>
                                <a href="http://demo.wphash.com/woolentor/product-category/music/" class="woolentor-button" target="_blank"><?php echo esc_html__( 'Preview', 'woolentor' ); ?></a>
                            </div>
                        </div>

                        <div class="woolentor-single-theme">
                            <img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/archive-layout-3.png" alt="">
                            <div class="woolentor-theme-content">
                                <h3><?php echo esc_html__( 'Shop Page Style Three', 'woolentor' ); ?> <span><?php echo esc_html__( '( Pro )', 'woolentor' ); ?></span></h3>
                                <a href="http://demo.wphash.com/woolentor/product-category/clothing/hoodies/" class="woolentor-button" target="_blank"><?php echo esc_html__( 'Preview', 'woolentor' ); ?></a>
                            </div>
                        </div>

                        <div class="woolentor-single-theme">
                            <img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/archive-layout-4.png" alt="">
                            <div class="woolentor-theme-content">
                                <h3><?php echo esc_html__( 'Shop Page Style Four', 'woolentor' ); ?> <span><?php echo esc_html__( '( Pro )', 'woolentor' ); ?></span></h3>
                                <a href="http://demo.wphash.com/woolentor/product-category/clothing/" class="woolentor-button" target="_blank"><?php echo esc_html__( 'Preview', 'woolentor' ); ?></a>
                            </div>
                        </div>

                        <div class="woolentor-single-theme">
                            <img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/archive-layout-5.png" alt="">
                            <div class="woolentor-theme-content">
                                <h3><?php echo esc_html__( 'Shop Page Style Five', 'woolentor' ); ?> <span><?php echo esc_html__( '( Pro )', 'woolentor' ); ?></span></h3>
                                <a href="http://demo.wphash.com/woolentor/product-category/clothing/t-shirts/" class="woolentor-button" target="_blank"><?php echo esc_html__( 'Preview', 'woolentor' ); ?></a>
                            </div>
                        </div>

                        <div class="woolentor-single-theme">
                            <img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/archive-layout-6.png" alt="">
                            <div class="woolentor-theme-content">
                                <h3><?php echo esc_html__( 'Shop Page Style Six', 'woolentor' ); ?> <span><?php echo esc_html__( '( Pro )', 'woolentor' ); ?></span></h3>
                                <a href="http://demo.wphash.com/woolentor/product-category/music/albums/" class="woolentor-button" target="_blank"><?php echo esc_html__( 'Preview', 'woolentor' ); ?></a>
                            </div>
                        </div>

                        <div class="woolentor-single-theme">
                            <img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/archive-layout-7.png" alt="">
                            <div class="woolentor-theme-content">
                                <h3><?php echo esc_html__( 'Shop Page Style Seven', 'woolentor' ); ?> <span><?php echo esc_html__( '( Pro )', 'woolentor' ); ?></span></h3>
                                <a href="http://demo.wphash.com/woolentor/product-category/music/singles/" class="woolentor-button" target="_blank"><?php echo esc_html__( 'Preview', 'woolentor' ); ?></a>
                            </div>
                        </div>

                        <div class="woolentor-single-theme">
                            <img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/archive-layout-8.png" alt="">
                            <div class="woolentor-theme-content">
                                <h3><?php echo esc_html__( 'Shop Page Style Eight', 'woolentor' ); ?> <span><?php echo esc_html__( '( Pro )', 'woolentor' ); ?></span></h3>
                                <a href="http://demo.wphash.com/woolentor/product-category/posters/" class="woolentor-button" target="_blank"><?php echo esc_html__( 'Preview', 'woolentor' ); ?></a>
                            </div>
                        </div>

                        <div class="woolentor-single-theme">
                            <img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/archive-layout-9.png" alt="">
                            <div class="woolentor-theme-content">
                                <h3><?php echo esc_html__( 'Shop Page Style Nine', 'woolentor' ); ?> <span><?php echo esc_html__( '( Pro )', 'woolentor' ); ?></span></h3>
                                <a href="http://demo.wphash.com/woolentor/product-category/fashion/" class="woolentor-button" target="_blank"><?php echo esc_html__( 'Preview', 'woolentor' ); ?></a>
                            </div>
                        </div>

                        <div class="woolentor-single-theme">
                            <img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/archive-layout-10.png" alt="">
                            <div class="woolentor-theme-content">
                                <h3><?php echo esc_html__( 'Shop Page Style Ten', 'woolentor' ); ?> <span><?php echo esc_html__( '( Pro )', 'woolentor' ); ?></span></h3>
                                <a href="http://demo.wphash.com/woolentor/product-category/lighting/" class="woolentor-button" target="_blank"><?php echo esc_html__( 'Preview', 'woolentor' ); ?></a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="woolentor-admin-tab-pane" id="productdetailspage">
                <div class="woolentor-template-area">
                    <div class="woolentor-themes-row">

                        <div class="woolentor-single-theme">
                            <img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/product-details-1.png" alt="">
                            <div class="woolentor-theme-content">
                                <h3><?php echo esc_html__( 'Product Details Style One', 'woolentor' ); ?></h3>
                                <a href="http://demo.wphash.com/woolentor/product/flying-ninja/" class="woolentor-button" target="_blank"><?php echo esc_html__( 'Preview', 'woolentor' ); ?></a>
                                <a href="https://freethemescloud.com/download/woolentor-product-details/" class="woolentor-button"><?php echo esc_html__( 'Download', 'woolentor' ); ?></a>
                            </div>
                        </div>

                        <div class="woolentor-single-theme">
                            <img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/product-details-2.png" alt="">
                            <div class="woolentor-theme-content">
                                <h3><?php echo esc_html__( 'Product Details Style Two', 'woolentor' ); ?></h3>
                                <a href="http://demo.wphash.com/woolentor/product/ninja-silhouette/" class="woolentor-button" target="_blank"><?php echo esc_html__( 'Preview', 'woolentor' ); ?></a>
                                <a href="https://freethemescloud.com/download/woolentor-product-details-two/" class="woolentor-button"><?php echo esc_html__( 'Download', 'woolentor' ); ?></a>
                            </div>
                        </div>

                        <div class="woolentor-single-theme">
                            <img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/product-details-3.png" alt="">
                            <div class="woolentor-theme-content">
                                <h3><?php echo esc_html__( 'Product Details Style Three', 'woolentor' ); ?></h3>
                                <a href="http://demo.wphash.com/woolentor/product/patient-ninja/" class="woolentor-button" target="_blank"><?php echo esc_html__( 'Preview', 'woolentor' ); ?></a>
                                <a href="https://freethemescloud.com/download/woolentor-product-details-three/" class="woolentor-button"><?php echo esc_html__( 'Download', 'woolentor' ); ?></a>
                            </div>
                        </div>

                        <div class="woolentor-single-theme">
                            <img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/product-details-4.png" alt="">
                            <div class="woolentor-theme-content">
                                <h3><?php echo esc_html__( 'Product Details Style Four', 'woolentor' ); ?> <span><?php echo esc_html__( '( Pro )', 'woolentor' ); ?></span></h3>
                                <a href="http://demo.wphash.com/woolentor/product/premium-quality/" class="woolentor-button" target="_blank"><?php echo esc_html__( 'Preview', 'woolentor' ); ?></a>
                            </div>
                        </div>

                        <div class="woolentor-single-theme">
                            <img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/product-details-5.png" alt="">
                            <div class="woolentor-theme-content">
                                <h3><?php echo esc_html__( 'Product Details Style Five', 'woolentor' ); ?> <span><?php echo esc_html__( '( Pro )', 'woolentor' ); ?></span></h3>
                                <a href="http://demo.wphash.com/woolentor/product/happy-ninja/" class="woolentor-button" target="_blank"><?php echo esc_html__( 'Preview', 'woolentor' ); ?></a>
                            </div>
                        </div>

                        <div class="woolentor-single-theme">
                            <img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/product-details-6.png" alt="">
                            <div class="woolentor-theme-content">
                                <h3><?php echo esc_html__( 'Product Details Style Six', 'woolentor' ); ?> <span><?php echo esc_html__( '( Pro )', 'woolentor' ); ?></span></h3>
                                <a href="http://demo.wphash.com/woolentor/product/ninja-silhouette-2/" class="woolentor-button" target="_blank"><?php echo esc_html__( 'Preview', 'woolentor' ); ?></a>
                            </div>
                        </div>

                        <div class="woolentor-single-theme">
                            <img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/product-details-7.png" alt="">
                            <div class="woolentor-theme-content">
                                <h3><?php echo esc_html__( 'Product Details Style Seven', 'woolentor' ); ?> <span><?php echo esc_html__( '( Pro )', 'woolentor' ); ?></span></h3>
                                <a href="http://demo.wphash.com/woolentor/product/premium-quality-2/" class="woolentor-button" target="_blank"><?php echo esc_html__( 'Preview', 'woolentor' ); ?></a>
                            </div>
                        </div>

                        <div class="woolentor-single-theme">
                            <img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/product-details-8.png" alt="">
                            <div class="woolentor-theme-content">
                                <h3><?php echo esc_html__( 'Product Details Style Eight', 'woolentor' ); ?> <span><?php echo esc_html__( '( Pro )', 'woolentor' ); ?></span></h3>
                                <a href="http://demo.wphash.com/woolentor/product/ship-your-idea/" class="woolentor-button" target="_blank"><?php echo esc_html__( 'Preview', 'woolentor' ); ?></a>
                            </div>
                        </div>

                        <div class="woolentor-single-theme">
                            <img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/product-details-9.png" alt="">
                            <div class="woolentor-theme-content">
                                <h3><?php echo esc_html__( 'Product Details Style Nine', 'woolentor' ); ?> <span><?php echo esc_html__( '( Pro )', 'woolentor' ); ?></span></h3>
                                <a href="http://demo.wphash.com/woolentor/product/ship-your-idea-3/" class="woolentor-button" target="_blank"><?php echo esc_html__( 'Preview', 'woolentor' ); ?></a>
                            </div>
                        </div>

                        <div class="woolentor-single-theme">
                            <img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/product-details-10.png" alt="">
                            <div class="woolentor-theme-content">
                                <h3><?php echo esc_html__( 'Product Details Style Ten', 'woolentor' ); ?> <span><?php echo esc_html__( '( Pro )', 'woolentor' ); ?></span></h3>
                                <a href="http://demo.wphash.com/woolentor/product/woo-album-1/" class="woolentor-button" target="_blank"><?php echo esc_html__( 'Preview', 'woolentor' ); ?></a>
                            </div>
                        </div>

                        <div class="woolentor-single-theme">
                            <img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/product-details-11.png" alt="">
                            <div class="woolentor-theme-content">
                                <h3><?php echo esc_html__( 'Product Details Style Eleven', 'woolentor' ); ?> <span><?php echo esc_html__( '( Pro )', 'woolentor' ); ?></span></h3>
                                <a href="http://demo.wphash.com/woolentor/product/woo-album-2/" class="woolentor-button" target="_blank"><?php echo esc_html__( 'Preview', 'woolentor' ); ?></a>
                            </div>
                        </div>

                        <div class="woolentor-single-theme">
                            <img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/product-details-12.png" alt="">
                            <div class="woolentor-theme-content">
                                <h3><?php echo esc_html__( 'Product Details Style Twelve', 'woolentor' ); ?> <span><?php echo esc_html__( '( Pro )', 'woolentor' ); ?></span></h3>
                                <a href="http://demo.wphash.com/woolentor/product/woo-album-3/" class="woolentor-button" target="_blank"><?php echo esc_html__( 'Preview', 'woolentor' ); ?></a>
                            </div>
                        </div>

                        <div class="woolentor-single-theme">
                            <img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/product-details-13.png" alt="">
                            <div class="woolentor-theme-content">
                                <h3><?php echo esc_html__( 'Product Details Style Thirteen', 'woolentor' ); ?> <span><?php echo esc_html__( '( Pro )', 'woolentor' ); ?></span></h3>
                                <a href="http://demo.wphash.com/woolentor/product/woo-album-4/" class="woolentor-button" target="_blank"><?php echo esc_html__( 'Preview', 'woolentor' ); ?></a>
                            </div>
                        </div>

                        <div class="woolentor-single-theme">
                            <img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/product-details-14.png" alt="">
                            <div class="woolentor-theme-content">
                                <h3><?php echo esc_html__( 'Product Details Style Fourteen', 'woolentor' ); ?> <span><?php echo esc_html__( '( Pro )', 'woolentor' ); ?></span></h3>
                                <a href="http://demo.wphash.com/woolentor/product/woo-single-1/" class="woolentor-button" target="_blank"><?php echo esc_html__( 'Preview', 'woolentor' ); ?></a>
                            </div>
                        </div>

                        <div class="woolentor-single-theme">
                            <img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/product-details-15.png" alt="">
                            <div class="woolentor-theme-content">
                                <h3><?php echo esc_html__( 'Product Details Style Fifteen', 'woolentor' ); ?> <span><?php echo esc_html__( '( Pro )', 'woolentor' ); ?></span></h3>
                                <a href="http://demo.wphash.com/woolentor/product/woo-ninja-2/" class="woolentor-button" target="_blank"><?php echo esc_html__( 'Preview', 'woolentor' ); ?></a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="woolentor-admin-tab-pane" id="otherspage">
                <div class="woolentor-template-area">
                    <div class="woolentor-themes-row">

                        <div class="woolentor-single-theme">
                            <img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/about-us.png" alt="">
                            <div class="woolentor-theme-content">
                                <h3><?php echo esc_html__( 'About Us Page', 'woolentor' ); ?></h3>
                                <a href="http://demo.shrimpthemes.com/1/parlo/about-us/" class="woolentor-button" target="_blank"><?php echo esc_html__( 'Preview', 'woolentor' ); ?></a>
                                <a href="https://freethemescloud.com/download/parlo-about-us-page/" class="woolentor-button"><?php echo esc_html__( 'Download', 'woolentor' ); ?></a>
                            </div>
                        </div>

                        <div class="woolentor-single-theme">
                            <img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/contact-us.png" alt="">
                            <div class="woolentor-theme-content">
                                <h3><?php echo esc_html__( 'Contact Us Page', 'woolentor' ); ?></h3>
                                <a href="http://demo.shrimpthemes.com/1/parlo/contact-us/" class="woolentor-button" target="_blank"><?php echo esc_html__( 'Preview', 'woolentor' ); ?></a>
                                <a href="https://freethemescloud.com/download/parlo-contact-us-page/" class="woolentor-button"><?php echo esc_html__( 'Download', 'woolentor' ); ?></a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
        <?php
        echo ob_get_clean();
    }

    // Buy Pro
    function woolentor_html_buy_pro_tabs(){
        ob_start();
        ?>
            <div class="woolentor-admin-tab-area">
                <ul class="woolentor-admin-tabs">
                    <li><a href="#oneyear" class="wlactive"><?php echo esc_html__( 'One Year', 'woolentor' ); ?></a></li>
                    <li><a href="#lifetime"><?php echo esc_html__( 'Life Time', 'woolentor' ); ?></a></li>
                    <li><a href="#themeseller"><?php echo esc_html__( 'Theme Seller', 'woolentor' ); ?></a></li>
                </ul>
            </div>
            
            <div id="oneyear" class="woolentor-admin-tab-pane wlactive">
                <div class="woolentor-admin-row">

                    <div class="woolentor-price-plan">
                        <h3><?php echo esc_html__( 'Personal', 'woolentor' ); ?></h3>
                        <div class="woolentor-price">
                            <span class="sell-price"><?php echo esc_html__( '$19', 'woolentor' ); ?></span>
                            <span class="regular-price"><del><?php echo esc_html__( '$29', 'woolentor' ); ?></del></span>
                        </div>
                        <ul>
                            <li><?php echo esc_html__( '1 Website', 'woolentor' ); ?></li>
                            <li><?php echo esc_html__( '1 Year Update', 'woolentor' ); ?></li>
                            <li><?php echo esc_html__( '1 Year Support', 'woolentor' ); ?></li>
                        </ul>
                        <a class="button button-primary" href="https://hasthemes.com/plugins/woolentor-pro/" target="_blank"><?php echo esc_html__( 'Buy Now', 'woolenror' ); ?></a>
                    </div>

                    <div class="woolentor-price-plan">
                        <h3><?php echo esc_html__( 'Developer License', 'woolentor' ); ?></h3>
                        <div class="woolentor-price">
                            <span class="sell-price"><?php echo esc_html__( '$39', 'woolentor' ); ?></span>
                            <span class="regular-price"><del><?php echo esc_html__( '$59', 'woolentor' ); ?></del></span>
                        </div>
                        <ul>
                            <li><?php echo esc_html__( 'Unlimited Websites', 'woolentor' ); ?></li>
                            <li><?php echo esc_html__( '1 Year Update', 'woolentor' ); ?></li>
                            <li><?php echo esc_html__( '1 Year Support', 'woolentor' ); ?></li>
                        </ul>
                        <a class="button button-primary" href="https://hasthemes.com/plugins/woolentor-pro/" target="_blank"><?php echo esc_html__( 'Buy Now', 'woolenror' ); ?></a>
                    </div>

                </div>
            </div>

            <div id="lifetime" class="woolentor-admin-tab-pane">
                
                <div class="woolentor-admin-row">
                    <div class="woolentor-price-plan">
                        <h3><?php echo esc_html__( 'Personal', 'woolentor' ); ?></h3>
                        <div class="woolentor-price">
                            <span class="sell-price"><?php echo esc_html__( '$29', 'woolentor' ); ?></span>
                            <span class="regular-price"><del><?php echo esc_html__( '$39', 'woolentor' ); ?></del></span>
                        </div>
                        <ul>
                            <li><?php echo esc_html__( '1 Website', 'woolentor' ); ?></li>
                            <li><?php echo esc_html__( 'Lifetime Update', 'woolentor' ); ?></li>
                            <li><?php echo esc_html__( 'Lifetime Support', 'woolentor' ); ?></li>
                        </ul>
                        <a class="button button-primary" href="https://hasthemes.com/plugins/woolentor-pro/" target="_blank"><?php echo esc_html__( 'Buy Now', 'woolenror' ); ?></a>
                    </div>
                    <div class="woolentor-price-plan">
                        <h3><?php echo esc_html__( 'Developer License', 'woolentor' ); ?></h3>
                        <div class="woolentor-price">
                            <span class="sell-price"><?php echo esc_html__( '$59', 'woolentor' ); ?></span>
                            <span class="regular-price"><del><?php echo esc_html__( '$69', 'woolentor' ); ?></del></span>
                        </div>
                        <ul>
                            <li><?php echo esc_html__( 'Unlimited Websites', 'woolentor' ); ?></li>
                            <li><?php echo esc_html__( 'Lifetime Update', 'woolentor' ); ?></li>
                            <li><?php echo esc_html__( 'Lifetime Support', 'woolentor' ); ?></li>
                        </ul>
                        <a class="button button-primary" href="https://hasthemes.com/plugins/woolentor-pro/" target="_blank"><?php echo esc_html__( 'Buy Now', 'woolenror' ); ?></a>
                    </div>
                </div>

            </div>

            <div id="themeseller" class="woolentor-admin-tab-pane">
                <div class="woolentor-admin-row">
                    <div class="woolentor-price-plan">
                        <h3><?php echo esc_html__( 'Single Theme', 'woolentor' ); ?></h3>
                        <div class="woolentor-price">
                            <span class="sell-price"><?php echo esc_html__( '$59', 'woolentor' ); ?></span>
                            <span class="regular-price"><del><?php echo esc_html__( '$99', 'woolentor' ); ?></del></span>
                        </div>
                        <ul>
                            <li><?php echo esc_html__( 'Can be distributed with one Theme', 'woolentor' ); ?></li>
                        </ul>
                        <a class="button button-primary" href="https://hasthemes.com/plugins/woolentor-pro/" target="_blank"><?php echo esc_html__( 'Buy Now', 'woolenror' ); ?></a>
                    </div>
                    <div class="woolentor-price-plan">
                        <h3><?php echo esc_html__( 'Unlimited Theme', 'woolentor' ); ?></h3>
                        <div class="woolentor-price">
                            <span class="sell-price"><?php echo esc_html__( '$99', 'woolentor' ); ?></span>
                            <span class="regular-price"><del><?php echo esc_html__( '$199', 'woolentor' ); ?></del></span>
                        </div>
                        <ul>
                            <li><?php echo esc_html__( 'Can be distributed with unlimited Themes', 'woolentor' ); ?></li>
                        </ul>
                        <a class="button button-primary" href="https://hasthemes.com/plugins/woolentor-pro/" target="_blank"><?php echo esc_html__( 'Buy Now', 'woolenror' ); ?></a>
                    </div>
                </div>
            </div>
        <?php
        echo ob_get_clean();
    }
    

}

new Woolentor_Admin_Settings();