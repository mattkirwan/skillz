<?php include 'head.php'; ?>

<?php
	$submitted_data = array();
	$errors = array();

	if($_SERVER['REQUEST_METHOD'] === 'POST')
	{
		$request = new \Liberty\Request\Controller\Request(
			new \Liberty\Request\Model\ProcessRequest(
				new \Liberty\Request\Config\RequestConfigFactory()
			)
		);

		$request->add_config('sanitize', 'topic', array('filter' => FILTER_SANITIZE_STRING));		
		$request->add_config('sanitize', 'description', array('filter' => FILTER_SANITIZE_STRING));
		$request->add_config('validate', 'email', array('filter' => FILTER_VALIDATE_EMAIL));		

		$required_fields = array('topic', 'description', 'email');

		$submit_result = $request->submit($_POST);
		$submitted_data = $request->get_clean_data();
		$errors = $request->get_errors();

		foreach($required_fields as $field)
		{
			if(empty($submitted_data[$field]))
			{
				$errors[$field] = 'Required field.';
			}
		}

		if($submit_result && empty($errors))
		{
			
			$body = "The following DevSkillz was requested:\n\n";
			$body .= "Topic: {$submitted_data['topic']}\n";
			$body .= "Description: {$submitted_data['description']}\n";
			$body .= "Email: {$submitted_data['email']}";

			include '../mail_connection.php';

			$mailer = Swift_Mailer::newInstance($transport);

			$message = Swift_Message::newInstance()
				->setSubject('DevSkillz Request')
				->setFrom(array('matt@viacreative.co.uk' => 'DevSkillz'))
				->setTo(array('mail@mattkirwan.com'))
				->setBody($body);

			$result = $mailer->send($message);

			if(false === $result)
			{
				include 'messages/error.php';
			}

			$submitted_data = array();
			$submit_another_skill_message = true;
			include 'messages/request_success.php';
		}
		else
		{
			include 'messages/error.php';
		}	
	}
?>

            <div class="row">
                <div class="col-lg-12">
                    <h3>Request A Skill</h3>
                	    
                </div>
            </div>
      		<div class="row">
                <div class="col-lg-6"> 
                	<?php if($submit_another_skill_message){include 'messages/request_again.php';}?>
                	<p class="pull-right">*<small>required field</small></p>           
					<form role="form" method="post" action="">
						
						<div class="form-group<?php if(isset($errors['topic'])){echo ' has-error';} ?>">
							<label class="control-label" for="topic">What topic would you like to learn?*</label>
							<input type="text"
								name="topic"
								class="form-control"
								id="topic"
								placeholder="Eg: C++"
								value="<?=$submitted_data['topic']?>">
							<?php showErrorMessage($errors, 'topic'); ?>
						</div>

						<div class="form-group<?php if(isset($errors['description'])){echo ' has-error';} ?>">
							<label class="control-label" for="description">Provide some further specific information...*</label>
							<input type="text"
								name="description"
								class="form-control"
								id="description"
								placeholder="Eg: I would love to learn more about C++ data types."
								value="<?=$submitted_data['description']?>">
							<?php showErrorMessage($errors, 'description'); ?>
						</div>
						
						<div class="form-group<?php if(isset($errors['email'])){echo ' has-error';} ?>">
							<label class="control-label" for="email">Your Email*</label>
							<input type="email"
								name="email"
								class="form-control"
								id="email"
								placeholder="Email address"
								value="<?=$submitted_data['email']?>">
							<?php showErrorMessage($errors, 'email'); ?>
						</div>
						
						<button type="submit" class="btn btn-success btn-lg btn-block">Request A Skill</button>
					</form>
                	    
                </div>
                <div class="col-lg-6 well">
                	<h4>Request A Skill - Help</h4>
                	<hr />
                	<p><strong>What topic would you like to learn?</strong> - The skill you would like to <strong>learn</strong>. This can be anything...as loose as "Coffeescript" or as specific as "Coffeescript for Hobot".</p>
                	<p><strong>Provide some further specific information...</strong> - A little more information on the skill you would like to <strong>learn</strong> (eg: "I would love to delve into PHP Symfony Forms" or "I don't care, give me ALL your knowledge on this topic!")</p>
                	<hr />
                	<p>If you have any questions feel free to drop me an <a href="mailto:mail@mattkirwan.com">email</a> and i'll do my best to help out.</p>
                </div>            
          	</div>
          	<br />
<?php include 'foot.php'; ?>