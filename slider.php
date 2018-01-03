<?php if( have_rows('soft_img_slider') ): ?>

	<section class="soft-slider-wr"> 
		<div class="soft-slider-bg">
			<div id="prev"></div>
			<div id="next"></div>
			<ul class="soft-slider">
				<?php while( have_rows('soft_img_slider') ): the_row(); 
				$img = get_sub_field('soft_img_slider_item');
				$label = get_sub_field('item_name_col'); ?>

				<li>
					<?php if( $label ): ?>
						<span class="label"><?php echo $label ?></span>
					<?php endif; ?>
					<a href="<?php echo $img['url']; ?>" data-lightbox="mebus"><img src="<?php echo $img['url']; ?>" alt="<?php echo $img['title']; ?>"></a>
				</li>
			<?php endwhile; ?>
		</ul>
	</div>
	<div class="soft-slider-sm">
		<div class="soft-slider-sm-inner">
			<div id="bx-soft-pager">
				
				<?php 
				$count = 0;
				while( have_rows('soft_img_slider') ): the_row(); 
				$img = get_sub_field('soft_img_slider_item'); ?>

				<a data-slide-index="<?php echo $count; ?>" href=""><img src="<?php echo $img['url']; ?>" alt="<?php echo $img['title']; ?>"/></a>
				<?php 
				$count++;
				endwhile; ?>

			</div>
		</div>
	</div>
</section>
<?php endif; ?>