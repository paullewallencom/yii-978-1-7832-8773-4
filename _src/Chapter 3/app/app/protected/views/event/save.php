<h3><?php echo $model->isNewRecord ? 'Create New' : 'Update'; ?> Event</h3>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'project-form',
	'htmlOptions' => array(
		'class' => 'form-horizontal',
		'role' => 'form'
	)
)); ?>
	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'title', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
			<?php echo $form->textField($model,'title', array('class' => 'form-control')); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'data', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
			<?php echo $form->textArea($model,'data', array('class' => 'form-control')); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'time', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
			<div class="input-append date">
				<?php echo $form->textField($model, 'time', array('value' => $model->isNewRecord ? NULL : gmdate('Y-m-d H:i:s', $model->time), 'class' => 'form-control')); ?>
			</div>
		</div>
	</div>

	<!-- Reminders -->
	<?php if (!$model->isNewRecord): ?>
		<input type="hidden" id="event_id" value="<?php echo $model->id; ?>" />
		<hr />
		<h3>Reminders</h3>
		<div class="reminders_container">
			<?php foreach ($model->reminders as $reminder): ?>
				<div class="form-group">
					<?php echo CHtml::tag('label', array('class' => 'col-sm-2 control-label'), 'Reminder'); ?>
					<div class="col-sm-9">
						<?php echo CHtml::tag('input', array(
							'id' => $reminder->id, 
							'name' => 'Reminders[' . $reminder->id . '][time]', 
							'class' => 'form-control', 
							'value' => gmdate('Y-m-d H:i:s', $reminder->time)
						), NULL); ?>
					</div>
					<span class="fa fa-times"></span>
				</div>
			<?php endforeach; ?>
		</div>

		<div class="form-group template" style="display:none">
			<?php echo CHtml::tag('label', array('class' => 'col-sm-2 control-label'), 'Reminder'); ?>
			<div class="col-sm-9">
				<?php echo CHtml::tag('input', array(
					'id' => NULL, 
					'name' => 'Reminders[0][time]', 
					'class' => 'form-control'
				), NULL); ?>
			</div>
		</div>
	<?php endif; ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-primary pull-right col-md-offset-1')); ?>

		<?php if (!$model->isNewRecord): ?>
			<?php echo CHtml::link('Delete Event', $this->createUrl('/event/delete', array('id' => $model->id)), array('class' => 'btn btn-danger pull-right col-md-offset-1')); ?>
			<?php echo CHtml::link('Add Reminder', '#', array('class' => 'btn btn-success pull-right', 'id' => 'add_reminder')); ?>
		<?php endif; ?>
	</div>
<?php $this->endWidget(); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js', CCLientScript::POS_END); ?>

<?php Yii::app()->clientScript->registerScript('datetimepicker', '
	function bindDatetimePicker() 
	{
		$("#Events_time, [name^=Reminder]").datetimepicker({
			format: "yyyy-mm-dd hh:ii:00",
			autoclose: true
		});
	}

	// Execute the binding
	bindDatetimePicker();
	updateReminder();
'); ?>

<?php Yii::app()->clientScript->registerScript('remove_reminder', '
	$("[name^=Reminder]").parent().parent().find(".fa-times").click(function() {
		var id = $(this).parent().find("[name^=Reminder]").attr("id");
		var self = $(this).parent();
		$.post("/reminder/delete/id/" + id, function() {
			$(self).remove();
		});
	})
'); ?>

<?php Yii::app()->clientScript->registerScript('add_reminder', '
	$("#add_reminder").click(function() {
		var template = $(".template").clone();
		$(template).removeClass("template").show();
		$(".reminders_container").append(template);
		bindDatetimePicker();
		updateReminder();
	});
'); ?>

<?php Yii::app()->clientScript->registerScript('update_reminder', '
	function updateReminder()
	{
		$("[name^=Reminder]").change(function() {
			var self = $(this);
			var id = $(this).parent().find("[name^=Reminder]").attr("id");
			var url = null;

			if (id == undefined)
				url = "/reminder/save"
			else
				url = "/reminder/save/id/" + id;

			var date = new Date();
			$.post(url, { "Reminders" : { "event_id" : $("#event_id").val(), "time" : $(self).val(), "offset" : date.getTimezoneOffset() } }, function() {

			})
		});
	}
'); ?>