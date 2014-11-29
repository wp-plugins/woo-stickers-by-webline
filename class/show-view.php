<?php
class wooStickerView {
	public function __construct() {
		if (ENABLE_STICKER == "yes") {
			if (ENABLE_NEW_PRODUCT == "yes") {
				if (ENABLE_STICKER_LISTING == "yes") {
					remove_action ( 'woocommerce_before_shop_loop_item_title', array (
							$this,
							'wli_woocommerce_show_product_loop_new_badge' 
					), 30 );
					add_action ( 'woocommerce_before_shop_loop_item_title', array (
							$this,
							'wli_woocommerce_show_product_loop_new_badge' 
					), 30 );
				}
				if (ENABLE_STICKER_DETAIL == "yes") {
					remove_action ( 'woocommerce_single_product_summary', array (
							$this,
							'wli_woocommerce_show_product_loop_new_badge' 
					), 30 );
					add_action ( 'woocommerce_before_single_product_summary', array (
							$this,
							'wli_woocommerce_show_product_loop_new_badge' 
					), 30 );
				}
			}
			if (ENABLE_SALE_PRODUCT == "yes") {
				if (ENABLE_STICKER_LISTING == "yes") {
					add_filter ( 'woocommerce_sale_flash', array (
							$this,
							'wli_woocommerce_show_product_loop_sale_badge' 
					), 10, 3 );
				} else {
					add_filter ( 'woocommerce_sale_flash', array (
							$this,
							'wli_woocommerce_show_product_loop_sale_badge_remove' 
					), 10, 3 );
				}
				if (ENABLE_STICKER_DETAIL == "yes") {
					remove_action ( 'woocommerce_before_single_product_summary', array (
							$this,
							'wli_woocommerce_show_product_loop_sale_badge' 
					), 30 );
					add_filter ( 'woocommerce_before_single_product_summary', array (
							$this,
							'wli_woocommerce_show_product_loop_sale_badge' 
					), 10, 3 );
				} else {
					add_filter ( 'woocommerce_before_single_product_summary', array (
							$this,
							'wli_woocommerce_show_product_loop_sale_badge_remove' 
					), 10, 3 );
				}
			} else {
				add_filter ( 'woocommerce_sale_flash', array (
						$this,
						'wli_woocommerce_show_product_loop_sale_badge_remove' 
				), 10, 3 );
			}
		} else {
			add_filter ( 'woocommerce_sale_flash', array (
					$this,
					'wli_woocommerce_show_product_loop_sale_badge_remove' 
			), 10, 3 );
		}
	}
	
	/**
	 * Call back function for show new product badge.
	 *
	 * @return void
	 * @var No arguments passed
	 * @author Weblineindia
	 */
	function wli_woocommerce_show_product_loop_new_badge() {
		$postdate = get_the_time ( 'Y-m-d' );
		$postdatestamp = strtotime ( $postdate );
		
		$newness = NEW_PRODUCT_DAYS;
		
		$class = (ENABLE_NEW_PRODUCT_STYLE == "ribbon") ? "new_ribbon" : "new_round";
		if ((time () - (60 * 60 * 24 * $newness)) < $postdatestamp && ENABLE_NEW_PRODUCT == "yes") {
			// // If the product was published within the newness time frame display the new badge /////
			echo '<span class="woosticker ' . $class . '">' . __ ( 'New', 'woocommerce-new-badge' ) . '</span>';
		}
	}
	
	/**
	 * Call back function for show sale product badge.
	 *
	 * @return void
	 * @var No arguments passed
	 * @author Weblineindia
	 */
	function wli_woocommerce_show_product_loop_sale_badge() {
		global $product;
		$classSale = (ENABLE_SALE_PRODUCT_STYLE == "ribbon") ? "woosticker onsale_ribbon" : "woosticker onsale_round";
		$classSold= (ENABLE_SOLD_PRODUCT_STYLE == "ribbon") ? "woosticker soldout_ribbon" : "woosticker soldout_round";
		if (! $product->is_in_stock ()) {
			if(ENABLE_SOLD_PRODUCT=="yes")
			echo '<span class="'.$classSold.'">Sold Out</span>';
		} else {
			return '<span class="' . $classSale . '"> Sale </span>';
		}
	}
	/**
	 * Remove the sale badge on details page.
	 *
	 * @return void
	 * @var No arguments passed
	 * @author Weblineindia
	 */
	function wli_woocommerce_show_product_loop_sale_badge_remove() {		
		
		remove_action ( 'woocommerce_before_single_product_summary', array (
				$this,
				'wli_woocommerce_show_product_loop_sale_badge' 
		), 30 );		
		return false;
	}
}
;
new wooStickerView();
