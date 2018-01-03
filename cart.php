<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wc_print_notices();

do_action( 'woocommerce_before_cart' ); ?>

<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
	<?php do_action( 'woocommerce_before_cart_table' ); ?>

	<section class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
		<div>
			<?php do_action( 'woocommerce_before_cart_contents' ); ?>

			<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
					?>
					<article class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

						<p class="product-remove">
							<?php
							echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
								'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
								esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
								__( 'Remove this item', 'woocommerce' ),
								esc_attr( $product_id ),
								esc_attr( $_product->get_sku() )
								), $cart_item_key );
								?>
							</p>
							<div class="product-info-cart">

								<div class="product-thumbnail">
									<?php
									$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

									if ( ! $product_permalink ) {
										echo $thumbnail;
									} else {

										$img_url = get_the_post_thumbnail_url($product_id);
										printf( '<a href="%s" style="background-image: url(' . $img_url . ' )"></a>', esc_url( $product_permalink ) );
									}
									?>
								</div>

								<section class="more-product-info">
									<div class="product-info-inner">
										<p class="product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
											<a href="<?php echo the_permalink($product_id); ?>"><?php echo get_the_title($product_id); ?></a>
										</p>
										
										
										<?php 

										//products category
										$values = get_the_terms( $product_id, 'product_cat');
										if ($values ) {
											foreach ( $values as $value ) {
												echo '<p class="prod-attribute">' . $value->name . '</p>';

											}
										}   
										?>
										
										<?php 	do_action('woocommerce_cart_product_cats'); ?>

										<p class="product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
											<?php
											echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
											?>
										</p>


										<?php 
										//get product color
										$taxonomy = 'pa_dress-color';
										$meta = $_product->attributes[$taxonomy];
										$term = get_term_by('slug', $meta, $taxonomy);	?>


										<p class="product-color"><?php echo $term->name; ?></p>				

										<p class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
											<?php
											if ( $_product->is_sold_individually() ) {
												$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
											} else {
												$product_quantity = woocommerce_quantity_input( array(
													'input_name'  => "cart[{$cart_item_key}][qty]",
													'input_value' => $cart_item['quantity'],
													'max_value'   => $_product->get_max_purchase_quantity(),
													'min_value'   => '0',
													), $_product, false );
											}

											echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
											?>
										</p>

										<p class="product-subtotal" data-title="<?php esc_attr_e( 'Total', 'woocommerce' ); ?>">
											<?php
											echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
											?>
										</p>
									</div>
								</section>
							</div>
						</article>
						<?php
					}
				}
				?>

				<?php do_action( 'woocommerce_cart_contents' ); ?>

				<tr>
					<td colspan="6" class="actions">

						<?php if ( wc_coupons_enabled() ) { ?>
						<div class="coupon">
							<label for="coupon_code"><?php _e( 'Coupon:', 'woocommerce' ); ?></label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> <input type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>" />
							<?php do_action( 'woocommerce_cart_coupon' ); ?>
						</div>
						<?php } ?>

						<input type="submit" class="button hidden" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>" />

						<?php do_action( 'woocommerce_cart_actions' ); ?>

						<?php wp_nonce_field( 'woocommerce-cart' ); ?>
					</td>
				</tr>

				<?php do_action( 'woocommerce_after_cart_contents' ); ?>
			</div>
		</section>
		<?php do_action( 'woocommerce_after_cart_table' ); ?>
	</form>

	<div class="cart-collaterals">
		<?php
		/**
		 * woocommerce_cart_collaterals hook.
		 *
		 * @hooked woocommerce_cross_sell_display
		 * @hooked woocommerce_cart_totals - 10
		 */
		do_action( 'woocommerce_cart_collaterals' );
		?>
	</div>

	<?php do_action( 'woocommerce_after_cart' ); ?>
