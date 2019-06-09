<?php $recap = $this->review_field('review_summary', true); if( ! empty( $recap ) ): ?>

<div class="rwp-summary-wrap">

	<span
        class="rwp-summary-label"
        style="color: <?php $this->template_field('template_summary_label_color') ?>;
        	   font-size: <?php $this->template_field('template_summary_label_font_size') ?>px;
        	   line-height: <?php $this->template_field('template_summary_label_font_size') ?>px;"><?php __($this->template_field('template_summary_label', true), 'reviewer') ?></span>

	<div class="rwp-summary" property="reviewBody"><?php
		$summary =  $this->review_field('review_summary', true);
		echo $summary;
	?></div>

</div> <!-- /summary -->

<?php endif ?>
