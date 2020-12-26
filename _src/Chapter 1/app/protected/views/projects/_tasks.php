<div>
	<div class="pull-left">
		<p><strong><?php echo CHtml::link(CHtml::encode($data->title), $this->createUrl('/tasks/save', array('id' => $data->id))); ?></strong></p>
		<p>Due on <?php echo date('m/d/Y', $data->due_date); ?></p>
	</div>
	<div class="pull-right">
		<?php echo CHtml::link(NULL, $this->createUrl('/tasks/save', array('id' => $data->id)), array('class' => 'glyphicon glyphicon-pencil')); ?>
		<?php echo CHtml::link(NULL, $this->createUrl('/tasks/complete', array('id'  => $data->id)), array('title' => $data->completed == 1 ? 'uncomplete' : 'complete', 'class' => 'glyphicon glyphicon-check')); ?>
		<?php echo CHtml::link(NULL, $this->createUrl('/tasks/delete', array('id' => $data->id)), array('class' => 'glyphicon glyphicon-remove')); ?>
	</div>
	<div class="clearfix"></div>
</div>
<hr />