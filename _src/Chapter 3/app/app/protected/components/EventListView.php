<?php

Yii::import('zii.widgets.CListView');
class EventListView extends CListView
{
	/**
	 * Retrieves the date that will be used for displaying information
	 * @return date("Y-m-d")
	 */
	public function getDate()
	{
        if (isset($_GET['date']))
        	return $_GET['date'];
        
        return gmdate("Y-m-d");
	}

	/**
	 * Renders the data item list.
	 */
	public function renderItems()
	{
		echo CHtml::openTag('div', array('class' => 'event_container'));

			// Month Year Picker
			echo CHtml::openTag('div', array('class' => 'month_year_picker'));
				echo CHtml::link(NULL, $this->controller->createUrl('/event', array('date' => gmdate("Y-m-d", strtotime($this->date ." previous year")))), array('class' => 'fa fa-angle-double-left pull-left'));
				echo CHtml::link(NULL, $this->controller->createUrl('/event', array('date' => gmdate("Y-m-d", strtotime($this->date ." previous month")))), array('class' => 'fa fa-angle-left pull-left'));
				echo CHtml::tag('span', array(), date('M Y', strtotime($this->date)));
				echo CHtml::link(NULL, $this->controller->createUrl('/event', array('date' => gmdate("Y-m-d", strtotime($this->date ." next year")))), array('class' => 'fa fa-angle-double-right pull-right'));
				echo CHtml::link(NULL, $this->controller->createUrl('/event', array('date' => gmdate("Y-m-d", strtotime($this->date ." next month")))), array('class' => 'fa fa-angle-right pull-right'));
			echo CHtml::closeTag('div');

			// Date Picker
			echo CHtml::openTag('div', array('class' => 'day_picker'));
				echo CHtml::openTag('ul');
					$this->renderDays(gmdate('Y-m-d', strtotime($this->date . ' -15 days')), $this->date);
					$this->renderDays($this->date, gmdate('Y-m-d', strtotime($this->date . ' +15 days')));
				echo CHtml::closeTag('ul');
			echo CHtml::closeTag('div');

			// Outer container for Details
			echo CHtml::openTag('div', array('class' => 'outer_container'));

				echo CHtml::openTag('div', array('class' => 'inner_container'));
					echo CHtml::openTag('div', array('class' => 'selected_date'));
						echo CHtml::tag('span', array('class' => 'selected_date_date'), gmdate("l F d Y", strtotime($this->date)));
					echo CHtml::closeTag('div');
					$this->renderSorter();
					parent::renderItems();
				echo CHtml::closeTag('div');

				// Details container is populated via Ajax Request
				echo CHtml::tag('div', array('class' => 'details'), NULL);
				echo CHtml::tag('div', array('class' => 'clearfix'), NULL);
			echo CHtml::closeTag('div');
		echo CHtml::closeTag('div');

		Yii::app()->clientScript->registerScript('li_click', '
			$(".items li").click(function() {
				var id = $(this).attr("data-attr-id");
				$.get("/event/details/" + id, function(data) { 
					$(".details").replaceWith(data); 

					$(".fa-times").click(function() {
						var id = $(this).parent().attr("id");
						var self = $(this).parent();
						$.post("/reminder/delete/id/" + id, function() {
							$(self).remove();
						})
					});
				});
			});
		');
	}

	/**
	 * Renders the days between 2 days
	 * @param  date $start The start date
	 * @param  date $end   The end date
	 * @see    self::renderDay($date);
	 */
	private function renderDays($start, $end)
	{
		$start    = new DateTime($start);
		$end      = new DateTime($end);
		$interval = new DateInterval('P1D');
		$period   = new DatePeriod($start, $interval, $end);

		foreach ($period as $dt)
			$this->renderDay($dt->format('Y-m-d'));
	}

	/**
	 * Renders a day
	 * @param  date("Y-m-d")   $date   The date to render
	 */
	private function renderDay($date)
	{
		$class = 'day';
		if ($this->date == $date)
			$class .= ' selected';
		echo CHtml::openTag('li', array('class' => $class));
			echo CHtml::tag('span', array('class' => 'day_string'), gmdate('D', strtotime($date)));
			echo CHtml::link(date('d', strtotime($date)), $this->controller->createUrl('/event', array('date' => gmdate('Y-m-d', strtotime($date)))), array('class' => 'day_date'));
		echo CHtml::closeTag('li');
	}
}