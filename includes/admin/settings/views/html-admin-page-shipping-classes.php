<?php
/**
 * Shipping classes admin
 *
 * @package WooCommerce/Admin/Shipping
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<h2>
	<?php esc_html_e( 'Shipping classes', 'woocommerce' ); ?>
	<?php echo wc_help_tip( __( 'Shipping classes can be used to group products of similar type and can be used by some Shipping Methods (such as "Flat rate shipping") to provide different rates to different classes of product.', 'woocommerce' ) ); // @codingStandardsIgnoreLine ?>
</h2>

<table class="wc-shipping-classes widefat">
	<thead>
		<tr>
			<?php foreach ( $shipping_class_columns as $class => $heading ) : ?>
				<th class="<?php echo esc_attr( $class ); ?>"><?php echo esc_html( $heading ); ?></th>
			<?php endforeach; ?>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="<?php echo absint( count( $shipping_class_columns ) ); ?>">
				<button type="submit" name="save" class="button button-primary wc-shipping-class-save" value="<?php esc_attr_e( 'Save shipping classes', 'woocommerce' ); ?>" disabled><?php esc_html_e( 'Save shipping classes', 'woocommerce' ); ?></button>
				<a class="button button-secondary wc-shipping-class-add" href="#"><?php esc_html_e( 'Add shipping class', 'woocommerce' ); ?></a>
			</td>
		</tr>
	</tfoot>
	<tbody class="wc-shipping-class-rows"></tbody>
</table>

<script type="text/html" id="tmpl-wc-shipping-class-row-blank">
	<tr>
		<td class="wc-shipping-classes-blank-state" colspan="<?php echo absint( count( $shipping_class_columns ) ); ?>"><p><?php esc_html_e( 'No shipping classes have been created.', 'woocommerce' ); ?></p></td>
	</tr>
</script>

<script type="text/html" id="tmpl-wc-shipping-class-row">
	<tr data-id="{{ data.term_id }}">
		<?php
		foreach ( $shipping_class_columns as $class => $heading ) {
			echo '<td class="' . esc_attr( $class ) . '">';
			switch ( $class ) {
				case 'wc-shipping-class-name':
					?>
					<div class="view">
						{{ data.name }}
						<div class="row-actions">
							<a class="wc-shipping-class-edit" href="#"><?php esc_html_e( 'Edit', 'woocommerce' ); ?></a> | <a href="#" class="wc-shipping-class-delete"><?php esc_html_e( 'Remove', 'woocommerce' ); ?></a>
						</div>
					</div>
					<div class="edit">
						<input type="text" name="name[{{ data.term_id }}]" data-attribute="name" value="{{ data.name }}" placeholder="<?php esc_attr_e( 'Shipping class name', 'woocommerce' ); ?>" />
						<div class="row-actions">
							<a class="wc-shipping-class-cancel-edit" href="#"><?php esc_html_e( 'Cancel changes', 'woocommerce' ); ?></a>
						</div>
					</div>
					<?php
					break;
				case 'wc-shipping-class-slug':
					?>
					<div class="view">{{ data.slug }}</div>
					<div class="edit"><input type="text" name="slug[{{ data.term_id }}]" data-attribute="slug" value="{{ data.slug }}" placeholder="<?php esc_attr_e( 'Slug', 'woocommerce' ); ?>" /></div>
					<?php
					break;
				case 'wc-shipping-class-description':
					?>
					<div class="view">{{ data.description }}</div>
					<div class="edit"><input type="text" name="description[{{ data.term_id }}]" data-attribute="description" value="{{ data.description }}" placeholder="<?php esc_attr_e( 'Description for your reference', 'woocommerce' ); ?>" /></div>
					<?php
					break;
				case 'wc-shipping-class-max-weight':
					?>
					<div class="view">{{ data.max_weight }} <?php echo esc_html( $weight_unit ); ?></div>
					<div class="edit"><input type="number" name="max_weight[{{ data.term_id }}]" data-attribute="max_weight" value="{{ data.max_weight }}" placeholder="<?php esc_attr_e( 'Max weight', 'woocommerce' ); ?>" /></div>
					<?php
					break;
				case 'wc-shipping-class-max-dimensions':
					?>
					<div class="view">{{ data.max_length }}{{ !data.has_single_dimension ? 'x' + data.max_width : '' }}{{ !data.has_single_dimension ? 'x' + data.max_height : '' }} <?php echo esc_html( $dimension_unit ); ?></div>
					<div class="edit">
						<input class="dimensions-input {{ data.has_single_dimension ? 'single-dimension' : '' }}" type="number" name="max_length[{{ data.term_id }}]" data-attribute="max_length" value="{{ data.max_length }}" placeholder="<?php esc_attr_e( 'Max length', 'woocommerce' ); ?>" /><div class="has-multi-dimensions" style="{{ data.has_single_dimension ? 'display: none;' : '' }}"> x <input class="dimensions-input" type="number" name="max_width[{{ data.term_id }}]" data-attribute="max_width" value="{{ data.max_width }}" placeholder="<?php esc_attr_e( 'Max width', 'woocommerce' ); ?>" /> x <input class="dimensions-input" type="number" name="max_height[{{ data.term_id }}]" data-attribute="max_height" value="{{ data.max_height }}" placeholder="<?php esc_attr_e( 'Max height', 'woocommerce' ); ?>" /></div>
						<div class="row-actions">
							<p><input class="has-single-dimension" type="checkbox" name="has_single_dimension[{{ data.term_id }}]" data-attribute="has_single_dimension" value="{{ data.has_single_dimension }}" {{ data.has_single_dimension ? 'checked' : '' }} /><?php esc_html_e( 'Single dimension', 'woocommerce' ); ?></p>
						</div>
					</div>
					<?php
					break;
				case 'wc-shipping-class-has-insurance':
					?>
					<div class="view">{{ data.has_insurance ? '✔' : '✘' }}</div>
					<div class="edit"><input type="checkbox" name="has_insurance[{{ data.term_id }}]" data-attribute="has_insurance" value="{{ data.has_insurance }}" {{ data.has_insurance ? 'checked' : '' }} /></div>
					<?php
					break;
				case 'wc-shipping-class-count':
					?>
					<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=product&product_shipping_class=' ) ); ?>{{data.slug}}">{{ data.count }}</a>
					<?php
					break;
				default:
					do_action( 'woocommerce_shipping_classes_column_' . $class );
					break;
			}
			echo '</td>';
		}
		?>
	</tr>
</script>
