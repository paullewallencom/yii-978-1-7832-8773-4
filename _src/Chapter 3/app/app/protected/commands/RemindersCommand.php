<?php

class RemindersCommand extends CConsoleCommand
{
	/**
	 * Sends all reminders scheduled between the called 5 minute interval, and the next 5 minutes interval - 1 second
	 * @param int $interval     The time interval in minutes
	 */
	public function actionSendReminders($interval)
	{
		// Get the current time, and create an interval between the previous 5 minute interval
		// and the next $interval minute interval
		$time = time();
		$start = $time - ($time % $interval * 60);
		$end = $start + (($interval *60) - 1));

		// Create the Between Criteria
		$criteria = new CDbCriteria;
		$criteria->addBetweenCondition('offset', $start, $end);

		// Find all the Reminders that match this criteria
		$reminders = Reminders::model()->findAll($criteria);

		// Iterate through all the reminders, and send an email to their owner
		foreach ($reminders as $reminder)
		{
		   // Load the PHPMailer Class
			$mail = new PHPMailer;

		   // Tell PHP Mailer to use SMTP with authentication
			$mail->isSMTP();
			$mail->SMTPAuth = true;

		      // Specify the Host and Port we should connect to
			$mail->Host = Yii::app()->params['smtp']['host']; 
			$mail->Port = Yii::app()->params['smtp']['port'];

		   // Specify the username and password we should use
		   // (if required by our SMTP server)
			$mail->Username = Yii::app()->params['smtp']['username'];
			$mail->Password = Yii::app()->params['smtp']['password'];

		   // Set the security type of required
			$mail->SMTPSecure = 'tls'; 

		   // Set the from and to addresses
			$mail->from = Yii::app()->params['smtp']['from'];
			$mail->addAddress($reminder->event->user->email);

		   // This should be an HTML email
			$mail->isHTML(true); 

			// Set the subject and body
		    $mail->Subject  ='Reminder from Scheduled Reminders';
			$mail->Body = 'This is a reminder that '.$reminder->event->title.' is due on '. gmdate("Y-m-d H:i UTC", $reminder->offset) . '. This event has the following details:<br />' . $reminder->event->data;

		   // Then send the email
			if (!$mail->send())
				echo $mail->ErrorInfo . "\n";
			else
				echo ".";
		}

	}
}