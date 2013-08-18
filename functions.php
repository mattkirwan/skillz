<?php
	function showErrorMessage($errors, $field)
	{
		if(isset($errors[$field]))
		{
			echo '<span class="help-block text-danger"> - '.$errors[$field].'</span>';
		}	
	}