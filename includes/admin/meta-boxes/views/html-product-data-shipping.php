<?php
/**
 * Product data shipping
 *
 * @package WooCommerce\Admin\Metaboxes\Views
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div id="shipping_product_data" class="panel woocommerce_options_panel hidden">
	<div class="options_group">
		<?php
		if ( wc_product_weight_enabled() ) {
			woocommerce_wp_text_input(
				array(
					'id'          => '_weight',
					'value'       => $product_object->get_weight( 'edit' ),
					'label'       => __( 'Weight', 'woocommerce' ) . ' (' . get_option( 'woocommerce_weight_unit' ) . ')',
					'placeholder' => wc_format_localized_decimal( 0 ),
					'desc_tip'    => true,
					'description' => __( 'Weight in decimal form', 'woocommerce' ),
					'type'        => 'text',
					'data_type'   => 'decimal',
				)
			);
		}

		if ( wc_product_dimensions_enabled() ) {
			?>
			<p class="form-field dimensions_field">
				<?php /* translators: WooCommerce dimension unit*/ ?>
				<label for="product_length"><?php printf( esc_html__( 'Dimensions (%s)', 'woocommerce' ), esc_html( get_option( 'woocommerce_dimension_unit' ) ) ); ?></label>
				<span class="wrap">
					<input id="product_length" placeholder="<?php esc_attr_e( 'Length', 'woocommerce' ); ?>" class="input-text wc_input_decimal" size="6" type="text" name="_length" value="<?php echo esc_attr( wc_format_localized_decimal( $product_object->get_length( 'edit' ) ) ); ?>" />
					<input id="product_width" placeholder="<?php esc_attr_e( 'Width', 'woocommerce' ); ?>" class="input-text wc_input_decimal" size="6" type="text" name="_width" value="<?php echo esc_attr( wc_format_localized_decimal( $product_object->get_width( 'edit' ) ) ); ?>" />
					<input id="product_height" placeholder="<?php esc_attr_e( 'Height', 'woocommerce' ); ?>" class="input-text wc_input_decimal last" size="6" type="text" name="_height" value="<?php echo esc_attr( wc_format_localized_decimal( $product_object->get_height( 'edit' ) ) ); ?>" />
				</span>
				<?php echo wc_help_tip( __( 'LxWxH in decimal form', 'woocommerce' ) ); ?>
			</p>
			<?php
		}

		if ( wc_product_weight_enabled() && wc_product_dimensions_enabled() ) {
			woocommerce_wp_checkbox(
				array(
					'id'          => '_automatic_shipping_class_selection',
					'value'       => $product_object->get_automatic_shipping_class_selection( 'edit' ) ? 'yes' : 'no',
					'label'       => __( 'Automatic shipping class selection', 'woocommerce' ),
					'description' => __( 'Enable this to select shipping class automatically based on weight and dimensions', 'woocommerce' ),
				)
			);
		}

		do_action( 'woocommerce_product_options_dimensions' );
		?>
	</div>

	<div class="options_group">
		<?php
		$shipping_zones = WC_Shipping_Zones::get_zones();
		$product_shipping_class_ids = $product_object->get_shipping_class_ids( 'edit' );

		foreach ( $shipping_zones as $shipping_zone ) {
			$shipping_zone_id = $shipping_zone['zone_id'];
			$shipping_zone_name = $shipping_zone['zone_name'];
			$shipping_zone_instance = new WC_Shipping_Zone( $shipping_zone['zone_id'] );
			$shipping_zone_shipping_class_ids = $shipping_zone_instance->get_zone_shipping_class_ids( 'edit' );
			$selected = array_key_exists( $shipping_zone_id, $product_shipping_class_ids ) ? $product_shipping_class_ids[ $shipping_zone_id ] : null;
			$args = array(
				'taxonomy'         => 'product_shipping_class',
				'hide_empty'       => 0,
				'show_option_none' => __( 'No shipping class', 'woocommerce' ),
				'name'             => 'shipping_class_ids[' . $shipping_zone_id . ']',
				'id'               => 'shipping_class_ids[' . $shipping_zone_id . ']',
				'selected'         => $selected,
				'class'            => 'select short shipping_class_id',
				'orderby'          => 'name',
				'include'          => $shipping_zone_shipping_class_ids,
			);

			?>
			<p class="form-field shipping_class_field">
				<label for="shipping_class_ids[<?php echo esc_attr( $shipping_zone_id ); ?>]"><?php esc_html_e( 'Shipping class', 'woocommerce' ); ?> - <?php echo esc_html( $shipping_zone_name ); ?></label>
				<?php wp_dropdown_categories( $args ); ?>
				<?php echo wc_help_tip( __( 'Shipping classes are used by certain shipping methods to group similar products.', 'woocommerce' ) ); ?>
			</p>
			<?php
		}

		do_action( 'woocommerce_product_options_shipping' );
		?>
	</div>
</div>
