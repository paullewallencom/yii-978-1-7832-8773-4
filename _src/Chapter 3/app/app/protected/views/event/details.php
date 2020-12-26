<div class="details">
	<div class="detail_header">
		<h2><?php echo CHtml::encode($model->title); ?></h2>
	</div>
	<div class="detail_body">
		<p><?php echo CHtml::encode($model->data); ?></p>
	</div>
	<div class="reminders_header">
		<h2>Reminders</h2>
	</div>
	<div class="reminders">
		<ul>
		<?php foreach ($model->reminders as $reminder): ?>
			<li id="<?php echo $reminder->id; ?>">
				<?php echo gmdate("Y-m-d H:i", $reminder->time); ?>
				<span class="fa fa-times"></span>
			</li>
		<?php endforeach; ?>
		</ul>
	</div>
	<?php echo CHtml::link('Update Event', $this->createUrl('/event/save',  array('id' => $model->id)), array('class' => 'btn btn-primary btn-full')); ?>
</div>