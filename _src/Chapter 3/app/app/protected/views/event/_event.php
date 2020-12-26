<li class="event" data-attr-id="<?php echo $data->id; ?>">
	<div class="time"><?php echo gmdate("H:i", $data->time); ?></div>
	<h2 class="title"><?php echo CHtml::encode($data->title); ?></h2>
</li>