<?php
	function output_search_item($type, $description) {
	?>
		<div class="search-item">
			<div class="search-type-img">
				<?php echo "<img src='/images/search-icon-$type.png'/>";?>
			</div>
			<div class="search-type">
				<?php echo $type?>
			</div>
			<div class="search-description"><?php echo $description?></div>
		</div>
	<?php
	}
	
	?>
	