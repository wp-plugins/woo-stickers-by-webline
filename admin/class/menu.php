<?php
class wooStickerMenu {
	
	/**
	 *
	 * Unique identifier for your plugin.
	 *
	 *
	 * For easier overriding we declared the keys
	 * here as well as our tabs array which is populated
	 * when registering settings
	 *
	 * @since 1.0.0
	 * @author Weblineindia
	 *        
	 *        
	 */
	private $general_settings_key = 'general_settings';
	private $new_product_settings_key = 'new_product_settings';
	private $sale_product_settings_key = 'sale_settings';
	private $sold_product_settings_key = 'sold_settings';
	private $plugin_options_key = 'wli-stickers';
	private $plugin_settings_tabs = array ();
	public function __construct() {
		$this->load_settings ();
		add_action ( 'admin_init', array (
				&$this,
				'register_general_settings' 
		) );
		add_action ( 'admin_init', array (
				&$this,
				'register_new_product_settings' 
		) );
		add_action ( 'admin_init', array (
				&$this,
				'register_sale_product_settings' 
		) );
		add_action ( 'admin_init', array (
		&$this,
				'register_sold_product_settings'
		) );
		add_action ( 'admin_menu', array (
				&$this,
				'add_admin_menus' 
		) );
		$widget_ops = array (
				'classname' => 'wli_woo_stickers',
				'description' => __ ( "WLI Woocommerce Stickers", "wli_woo_stickers_widget" ) 
		);
	}
	/**
	 * Loads settings from
	 * the database into their respective arrays.
	 * Uses
	 * array_merge to merge with default values if they're
	 * missing.
	 *
	 * @since 1.0.0
	 * @var No arguments passed
	 * @return void
	 * @author Weblineindia
	 */
	function load_settings() {
		$this->general_settings = ( array ) get_option ( $this->general_settings_key );
		$this->new_product_settings = ( array ) get_option ( $this->new_product_settings_key );
		$this->sale_product_settings = ( array ) get_option ( $this->sale_product_settings_key );
		$this->sold_product_settings = ( array ) get_option ( $this->sold_product_settings_key );
		// Merge with defaults
		$this->general_settings = array_merge ( array (
				'enable_sticker' => 'no',
				'enable_sticker_list' => 'no',
				'enable_sticker_detail' => 'no' 
		), $this->general_settings );
		
		$this->new_product_settings = array_merge ( array (
				'enable_new_product_sticker' => 'no',
				'enable_new_product_style' => 'ribbon' 
		), $this->new_product_settings );
		
		$this->sale_product_settings = array_merge ( array (
				'enable_sale_product_sticker' => 'no',
				'enable_sale_product_style' => 'ribbon' 
		), $this->sale_product_settings );
		
		$this->sold_product_settings = array_merge ( array (
				'enable_sold_product_sticker' => 'no',
				'enable_sold_product_style' => 'ribbon'
		), $this->sold_product_settings );
		
		define ( "ENABLE_STICKER", $this->general_settings ['enable_sticker'] );
		define ( "ENABLE_STICKER_LISTING", $this->general_settings ['enable_sticker_list'] );
		define ( "ENABLE_STICKER_DETAIL", $this->general_settings ['enable_sticker_detail'] );
		define ( "ENABLE_NEW_PRODUCT", $this->new_product_settings ['enable_new_product_sticker'] );
		define ( "ENABLE_SALE_PRODUCT", $this->sale_product_settings ['enable_sale_product_sticker'] );
		define ( "ENABLE_SALE_PRODUCT_STYLE", $this->sale_product_settings ['enable_sale_product_style'] );
		define ( "ENABLE_NEW_PRODUCT_STYLE", $this->new_product_settings ['enable_new_product_style'] );
		define ( "ENABLE_SOLD_PRODUCT", $this->sold_product_settings ['enable_sold_product_sticker'] );
		define ( "ENABLE_SOLD_PRODUCT_STYLE", $this->sold_product_settings ['enable_sold_product_style']);
	}
	/**
	 * Registers the general settings via the Settings API,
	 * appends the setting to the tabs array of the object.
	 * Tab Name will defined here.
	 *
	 * @since 1.0.0
	 * @var No arguments passed
	 * @return void
	 * @author Weblineindia
	 */
	function register_general_settings() {
		$this->plugin_settings_tabs [$this->general_settings_key] = 'General Configuration';
		
		register_setting ( $this->general_settings_key, $this->general_settings_key );
		add_settings_section ( 'section_general', 'General Plugin Settings', array (
				&$this,
				'section_general_desc' 
		), $this->general_settings_key );
		
		add_settings_field ( 'enable_sticker', 'Enable Product Sticker:', array (
				&$this,
				'enable_sticker' 
		), $this->general_settings_key, 'section_general' );
		
		add_settings_field ( 'enable_sticker_list', 'Enable Sticker On Product Listing Page:', array (
				&$this,
				'enable_sticker_list' 
		), $this->general_settings_key, 'section_general' );
		
		add_settings_field ( 'enable_sticker_detail', 'Enable Sticker On Product Details Page:', array (
				&$this,
				'enable_sticker_detail' 
		), $this->general_settings_key, 'section_general' );
	}
	
	/**
	 * Registers the New Product settings via the Settings API,
	 * appends the setting to the tabs array of the object.
	 * Tab Name will defined here.
	 *
	 * @since 1.0.0
	 * @var No arguments passed
	 * @return void
	 * @author Weblineindia
	 */
	function register_new_product_settings() {
		$this->plugin_settings_tabs [$this->new_product_settings_key] = 'Sticker Configurations for New Product';
		
		register_setting ( $this->new_product_settings_key, $this->new_product_settings_key );
		add_settings_section ( 'section_new_product', 'New Product Sticker Configurations', array (
				&$this,
				'section_new_product_desc' 
		), $this->new_product_settings_key );
		
		add_settings_field ( 'enable_new_product_sticker', 'Enable Product Sticker:', array (
				&$this,
				'enable_new_product_sticker' 
		), $this->new_product_settings_key, 'section_new_product' );
		
		add_settings_field ( 'enable_new_product_style', 'Enable Sticker On New Product:', array (
				&$this,
				'enable_new_product_style' 
		), $this->new_product_settings_key, 'section_new_product' );
	}
	
	/**
	 * Registers the Sale Product settings via the Settings API,
	 * appends the setting to the tabs array of the object.
	 * Tab Name will defined here.
	 *
	 * @return void
	 * @var No arguments passed
	 * @author Weblineindia
	 */
	function register_sale_product_settings() {
		$this->plugin_settings_tabs [$this->sale_product_settings_key] = 'Sticker Configurations for Products under Sale';
		
		register_setting ( $this->sale_product_settings_key, $this->sale_product_settings_key );
		add_settings_section ( 'section_sale_product', 'Sale Product Sticker Configurations', array (
				&$this,
				'section_sale_product_desc' 
		), $this->sale_product_settings_key );
		
		add_settings_field ( 'enable_sale_product_sticker', 'Enable Product Sticker:', array (
				&$this,
				'enable_sale_product_sticker' 
		), $this->sale_product_settings_key, 'section_sale_product' );
		
		add_settings_field ( 'enable_sale_product_style', 'Enable Sticker On Sale Product:', array (
				&$this,
				'enable_sale_product_style' 
		), $this->sale_product_settings_key, 'section_sale_product' );
	}
	/**
	 * Registers the Sold Product settings via the Settings API,
	 * appends the setting to the tabs array of the object.
	 * Tab Name will defined here.
	 *
	 * @return void
	 * @var No arguments passed
	 * @author Weblineindia
	 */
	function register_sold_product_settings() {
		$this->plugin_settings_tabs [$this->sold_product_settings_key] = 'Sticker Configurations for Products under Sold';
	
		register_setting ( $this->sold_product_settings_key, $this->sold_product_settings_key );
		add_settings_section ( 'section_sold_product', 'Sold Product Sticker Configurations', array (
		&$this,
		'section_sold_product_desc'
				), $this->sold_product_settings_key );
	
		add_settings_field ( 'enable_sold_product_sticker', 'Enable Product Sticker:', array (
		&$this,
		'enable_sold_product_sticker'
				), $this->sold_product_settings_key, 'section_sold_product' );
	
		add_settings_field ( 'enable_sold_product_style', 'Enable Sticker On Sold Product:', array (
		&$this,
		'enable_sold_product_style'
				), $this->sold_product_settings_key, 'section_sold_product' );
	}
	/**
	 * The following methods provide descriptions
	 * for their respective sections, used as callbacks
	 * with add_settings_section
	 *
	 * @return void
	 * @var No arguments passed
	 * @author Weblineindia
	 */
	function section_general_desc() {		
	}
	function section_new_product_desc() {				
	}
	function section_sale_product_desc() {		
	}
	function section_sold_product_desc() {		
	}
	
	/**
	 * General Settings :: Enable Stickers
	 *
	 * @return void
	 * @var No arguments passed
	 * @author Weblineindia
	 */
	function enable_sticker() {
		?>
<select id='enable_sticker'
	name="<?php echo $this->general_settings_key; ?>[enable_sticker]">
	<option value='yes'
		<?php selected( $this->general_settings['enable_sticker'], 'yes',true );?>>Yes</option>
	<option value='no'
		<?php selected( $this->general_settings['enable_sticker'], 'no',true );?>>No</option>
</select>
<p class="description">Select wether you want to enable sticker feature or not.</p>
<?php
	}
	/**
	 * General Settings :: Enable Sticker On Product Listing Page
	 *
	 * @return void
	 * @var No arguments passed
	 * @author Weblineindia
	 */
	function enable_sticker_list() {
		?>
<select id='enable_sticker_list'
	name="<?php echo $this->general_settings_key; ?>[enable_sticker_list]">
	<option value='yes'
		<?php selected( $this->general_settings['enable_sticker_list'], 'yes',true );?>>Yes</option>
	<option value='no'
		<?php selected( $this->general_settings['enable_sticker_list'], 'no',true );?>>No</option>
</select>
<p class="description">Select wether you want to enable sticker feature on product listing page or not.</p>
<?php
	}
	/**
	 * General Settings :: Enable Sticker On Product Listing Page
	 *
	 * @return void
	 * @var No arguments passed
	 * @author Weblineindia
	 */
	function enable_sticker_detail() {
		?>
<select id='enable_sticker_list'
	name="<?php echo $this->general_settings_key; ?>[enable_sticker_detail]">
	<option value='yes'
		<?php selected( $this->general_settings['enable_sticker_detail'], 'yes',true );?>>Yes</option>
	<option value='no'
		<?php selected( $this->general_settings['enable_sticker_detail'], 'no',true );?>>No</option>
</select>
<p class="description">Select wether you want to enable sticker feature on product detail page or not.</p>
<?php
	}
	
	/**
	 * New Product Settings :: Enable Stickers
	 *
	 * @return void
	 * @var No arguments passed
	 * @author Weblineindia
	 */
	function enable_new_product_sticker() {
		?>
<select id='enable_new_product_sticker'
	name="<?php echo $this->new_product_settings_key; ?>[enable_new_product_sticker]">
	<option value='yes'
		<?php selected( $this->new_product_settings['enable_new_product_sticker'], 'yes',true );?>>Yes</option>
	<option value='no'
		<?php selected( $this->new_product_settings['enable_new_product_sticker'], 'no',true );?>>No</option>
</select>
<p class="description">Control sticker display for products which are marked as NEW in wooCommerce.</p>
<?php
	}
	/**
	 * New Product Settings :: Display style On New Product
	 *
	 * @return void
	 * @var No arguments passed
	 * @author Weblineindia
	 */
	function enable_new_product_style() {
		?>
<select id='enable_new_product_style'
	name="<?php echo $this->new_product_settings_key; ?>[enable_new_product_style]">
	<option value='ribbon'
		<?php selected( $this->new_product_settings['enable_new_product_style'], 'ribbon',true );?>>Ribbon</option>
	<option value='round'
		<?php selected( $this->new_product_settings['enable_new_product_style'], 'round',true );?>>Round</option>
</select>
<p class="description">Select sticker type to show on New Products.</p>
<?php
	}
	
	/**
	 * Sale Product Settings :: Enable Stickers
	 *
	 * @return void
	 * @var No arguments passed
	 * @author Weblineindia
	 */
	function enable_sale_product_sticker() {
		?>
<select id='enable_sale_product_sticker'
	name="<?php echo $this->sale_product_settings_key; ?>[enable_sale_product_sticker]">
	<option value='yes'
		<?php selected( $this->sale_product_settings['enable_sale_product_sticker'], 'yes',true );?>>Yes</option>
	<option value='no'
		<?php selected( $this->sale_product_settings['enable_sale_product_sticker'], 'no',true );?>>No</option>
</select>
<p class="description">Control sticker display for products which are marked as under sale in wooCommerce.</p>
<?php
	}
	/**
	 * Sale Product Settings :: Display style On Sale Product
	 *
	 * @return void
	 * @var No arguments passed
	 * @author Weblineindia
	 */
	function enable_sale_product_style() {
		?>
<select id='enable_sale_product_style'
	name="<?php echo $this->sale_product_settings_key; ?>[enable_sale_product_style]">
	<option value='ribbon'
		<?php selected( $this->sale_product_settings['enable_sale_product_style'], 'ribbon',true );?>>Ribbon</option>
	<option value='round'
		<?php selected( $this->sale_product_settings['enable_sale_product_style'], 'round',true );?>>Round</option>
</select>
<p class="description">Select sticker type to show on Products under sale.</p>
<?php
	}
	
	/**
	 * Sold Product Settings :: Enable Stickers
	 *
	 * @return void
	 * @var No arguments passed
	 * @author Weblineindia
	 */
	function enable_sold_product_sticker() {
		?>
	<select id='enable_sold_product_sticker'
		name="<?php echo $this->sold_product_settings_key; ?>[enable_sold_product_sticker]">
		<option value='yes'
			<?php selected( $this->sold_product_settings['enable_sold_product_sticker'], 'yes',true );?>>Yes</option>
		<option value='no'
			<?php selected( $this->sold_product_settings['enable_sold_product_sticker'], 'no',true );?>>No</option>
	</select>
	<p class="description">Control sticker display for products which are marked as under sold in wooCommerce.</p>
	<?php
		}
		/**
		 * Sold Product Settings :: Display style On Sold Product
		 *
		 * @return void
		 * @var No arguments passed
		 * @author Weblineindia
		 */
		function enable_sold_product_style() {
			?>
	<select id='enable_sold_product_style'
		name="<?php echo $this->sold_product_settings_key; ?>[enable_sold_product_style]">
		<option value='ribbon'
			<?php selected( $this->sold_product_settings['enable_sold_product_style'], 'ribbon',true );?>>Ribbon</option>
		<option value='round'
			<?php selected( $this->sold_product_settings['enable_sold_product_style'], 'round',true );?>>Round</option>
	</select>
	<p class="description">Select sticker type to show on Products under sold.</p>
	<?php
		}
	
	/**
	 * Called during admin_menu, adds an options
	 * page under Settings called My Settings, rendered
	 * using the plugin_options_page method.
	 *
	 * @return void
	 * @var No arguments passed
	 * @author Weblineindia
	 */
	function add_admin_menus() {
		add_options_page ( 'WLI Woocommerce Stickers', 'WOO Stickers', 'manage_options', $this->plugin_options_key, array (
				&$this,
				'plugin_options_page' 
		) );
	}
	
	/**
	 * Plugin Options page rendering goes here, checks
	 * for active tab and replaces key with the related
	 * settings key.
	 * Uses the plugin_options_tabs method
	 * to render the tabs.
	 *
	 * @return void
	 * @var No arguments passed
	 * @author Weblineindia
	 */
	function plugin_options_page() {
		$tab = isset ( $_GET ['tab'] ) ? $_GET ['tab'] : $this->general_settings_key;
		?>
<div class="wrap">
    			<?php $this->plugin_options_tabs(); ?>
    			<form method="post" action="options.php">
    				<?php wp_nonce_field( 'update-options' ); ?>
    				<?php settings_fields( $tab ); ?>
    				<?php do_settings_sections( $tab ); ?>
    				<?php submit_button(); ?>
    			</form>
</div>
<?php
	}
	
	/**
	 * Renders our tabs in the plugin options page,
	 * walks through the object's tabs array and prints
	 * them one by one.
	 * Provides the heading for the
	 * plugin_options_page method.
	 *
	 * @return void
	 * @var No arguments passed
	 * @author Weblineindia
	 */
	function plugin_options_tabs() {
		$current_tab = isset ( $_GET ['tab'] ) ? $_GET ['tab'] : $this->general_settings_key;
		screen_icon ();
		echo '<h2 class="nav-tab-wrapper">';
		foreach ( $this->plugin_settings_tabs as $tab_key => $tab_caption ) {
			$active = $current_tab == $tab_key ? 'nav-tab-active' : '';
			echo '<a class="nav-tab ' . $active . '" href="?page=' . $this->plugin_options_key . '&tab=' . $tab_key . '">' . $tab_caption . '</a>';
		}
		echo '</h2>';
	}
}

new wooStickerMenu ();