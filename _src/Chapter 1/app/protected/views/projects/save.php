<h1><?php echo $model->isNewRecord ? 'Create New' : 'Update'; ?> Project</h1>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'project-form',
	'htmlOptions' => array(
		'class' => 'form-horizontal',
		'role' => 'form'
	)
)); ?>
	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'name', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
			<?php echo $form->textField($model,'name', array('class' => 'form-control')); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'completed', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
			<?php echo $form->dropDownList($model,'completed', array('0' => 'No','1' => 'Yes'), array('class' => 'form-control')); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'due_date', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
			<div class="input-append date">
				MM/DD/YYYY
				<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
				    'model' => $model,
				    'attribute' => 'due_date',
				    'htmlOptions' => array(
				        'size' => '10',
				        'maxlength' => '10',
				        'class' => 'form-control',
				        'value' => $model->due_date == "" ? "" : date("m/d/Y", $model->due_date)
				    ),
				)); ?>
			</div>
		</div>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-primary pull-right')); ?>
	</div>

<?php $this->endWidget(); ?>