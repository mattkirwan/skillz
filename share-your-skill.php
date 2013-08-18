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
		$request->add_config('sanitize', 'location', array('filter' => FILTER_SANITIZE_STRING));

		$required_fields = array('topic', 'description', 'email', 'location');

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
			
			$body = "The following DevSkillz was shared:\n\n";
			$body .= "Topic: {$submitted_data['topic']} - {$submitted_data['email']}\n";
			$body .= "Description: {$submitted_data['description']}\n";
			$body .= "Email: {$submitted_data['email']}\n";
			$body .= "Location: {$submitted_data['location']}";

			include '../mail_connection.php';

			$mailer = Swift_Mailer::newInstance($transport);

			$message = Swift_Message::newInstance()
				->setSubject('DevSkillz')
				->setFrom(array('matt@viacreative.co.uk' => 'DevSkillz'))
				->setTo(array('mail@mattkirwan.com'))
				->setBody($body);

			$result = $mailer->send($message);

			if(false === $result)
			{
				?>
				<div class="alert alert-danger"><strong>Ooops!</strong> There was an error processing your skill. Please correct any error(s) below.</div>
				<?php
			}

			$submitted_data = array();
			$submit_another_skill_message = '<div class="alert alert-info"><strong>Got another skill to share?</strong> Go on...you know you want to.</div>';
			?><div class="alert alert-success"><strong>Epic!</strong> Your skill has been submitted. That's pretty frickin' cool how you want to use your skills to help others. Just so you know i'm just manually collating details, when we get a few more I will publish them so that we can all start learning new skills. - Matt</div><?php
		}
		else
		{
			?>
			<div class="alert alert-danger"><strong>Ooops!</strong> There was an error processing your skill. Please correct any error(s) below.</div>
			<?php
		}	
	}
?>

            <div class="row">
                <div class="col-lg-12">
                    <h3>Share Your Skill</h3>
                    <hr />
                </div>
            </div>
      		<div class="row">
                <div class="col-lg-6"> 
                	<?=$submit_another_skill_message;?>
                	<p class="pull-right">*<small>required field</small></p>           
					<form role="form" method="post" action="">
						
						<div class="form-group<?php if(isset($errors['topic'])){echo ' has-error';} ?>">
							<label class="control-label" for="topic">Your Skill Topic*</label>
							<input type="text"
								name="topic"
								class="form-control"
								id="topic"
								placeholder="Eg: MySQL"
								value="<?=$submitted_data['topic']?>">
							<?php showErrorMessage($errors, 'topic'); ?>
						</div>

						<div class="form-group<?php if(isset($errors['description'])){echo ' has-error';} ?>">
							<label class="control-label" for="description">Skill Short Description*</label>
							<input type="text"
								name="description"
								class="form-control"
								id="description"
								placeholder="Eg: I'm willing to cover any subject related to this topic"
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
						
						<div class="form-group<?php if(isset($errors['location'])){echo ' has-error';} ?>">
							<label class="control-label" for="location">Your Skill Location*</label>
							<input type="text"
								name="location"
								class="form-control"
								id="location"
								placeholder="Eg: Newcastle"
								value="<?=$submitted_data['location']?>">
							<?php showErrorMessage($errors, 'location'); ?>
						</div>
						<button type="submit" class="btn btn-success btn-lg btn-block">Share Your Skill</button>
					</form>
                	    
                </div>
                <div class="col-lg-6 well">
                	<h4>Share Your Skill - Help</h4>
                	<hr />
                	<p><strong>Your Skill Topic</strong> - The skill you would like to share. This can be anything...as simple (eg: PHP) or as specific (eg: Symfony CLI Component) as a you like.</p>
                	<p><strong>Skill Short Description</strong> - A little more information on the skill you would like to share (eg: "Skill share will include an overview of manipulating the DOM using jQuery" or "I'm willing to cover any subject related to this topic")</p>
                	<p><strong>Your Skill Location</strong> - This is the place where you would be willing to meet and share your skill. Just the town/city name will be fine for now, you can iron out the finer points (eg: Pink Lane Coffee @ 2pm) with the individual who is lucky enough to claim your skill share.</p>
                	<hr />
                	<p>If you have any questions feel free to drop me an <a href="mailto:mail@mattkirwan.com">email</a> and i'll do my best to help out.</p>
                </div>
            </div>
          	<br />
<?php include 'foot.php'; ?>