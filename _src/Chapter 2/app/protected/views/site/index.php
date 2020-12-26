<div class="col-xs-12 col-sm-9">
	<div id="map-canvas" style="width: 100%; min-height: 500px"></div>
</div>
<div class="col-xs-6 col-sm-3 sidebar-offcanvas">
	<h3>Locations</h3>
	<hr />
	<form role="form">
		<div class="form-group">
			<?php $selected = array('options' => array(isset($_GET['id']) ? $_GET['id'] : NULL => array('selected' => true))); ?>
			<?php echo CHtml::dropDownList('id', array(), CHtml::listData(Location::model()->findAll(),'id','name'), CMap::mergeArray($selected, array('empty' => 'Select a Location'))); ?>
		</div>
		<button type="submit" class="pull-right btn btn-primary">Search</button>
	</form>
	<div class="clearfix"></div>
	<?php $cs = Yii::app()->getClientScript(); ?>
	<?php if (!empty($places['results'])): ?>
		<?php $cs->registerScript('loadMap', "Main.loadMap({$location->lat}, {$location->long});"); ?>
		<?php 
			// Center the map with the origin marker
			$lat = $location->lat;
			$long = $location->long;
			$name = $location->name;
			$cs->registerScript('origin', "
					Main.addMarker(
						Main.createLocation('{$lat}', '{$long}'), 
						\"{$name}\",
						true
					);
				");
		?>
		<hr />
		<h3>What's Nearby?</h3>
		<ul>
			<?php foreach ($places['results'] as $place): ?>
				<li><?php echo $place['name']; ?></li>
				<?php

					// Add the nearby POI's
					$lat = $place['geometry']['location']['lat'];
					$long = $place['geometry']['location']['lng'];
					$name = $place['name'];
					$icon = $place['icon'];
					$cs->registerScript('loadMarker-' . $place['id'], "
						Main.addMarker(
							Main.createLocation('{$lat}', '{$long}'), 
							\"{$name}\"
						);
					");
					?>
			
			<?php endforeach; ?>
		</ul>
	<?php else: ?>
		<?php $cs->registerScript('loadMap', "Main.loadMap();"); ?>
	<?php endif; ?>
</div>