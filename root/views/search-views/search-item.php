<?php
	function output_search_item($type, $name, $image, $description) {
	?>
		<div class="search-item">
			<div class="search-type-img">
				<?php echo "<img src='/images/search-icons/$image.png'/>";?>
			</div>
			<div class="search-type">
				<?php echo $type?>
			</div>
			<div class="search-name"><?php echo $name?></div>
			<div class="search-description"><?php echo $description?></div>
		</div>
	<?php
	}
	
	?>
	