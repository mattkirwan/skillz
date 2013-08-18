<?php include '../vendor/autoload.php'; ?>
<?php include 'functions.php'; ?>
<!DOCTYPE html>
<html>
    <head>
    <title>Skillz</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/jumbotron-narrow.css" rel="stylesheet" media="screen">
    <script type="text/javascript">

      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-7628607-3']);
      _gaq.push(['_setDomainName', 'mattkirwan.com']);
      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();

    </script>    
    </head>
    <body>
        

        <div class="container">
            <div class="header">
                <ul class="nav nav-pills pull-right">
                    <li<?php if($_SERVER['REQUEST_URI'] == '/'){echo ' class="active"';}?>><a href="/">Home</a></li>
                    <li<?php if($_SERVER['REQUEST_URI'] == '/share-your-skill.php'){echo ' class="active"';}?>><a href="/share-your-skill.php">Share Your Skill</a></li>
                    <li<?php if($_SERVER['REQUEST_URI'] == '/request-a-skill.php'){echo ' class="active"';}?>><a href="/request-a-skill.php">Request A Skill</a></li>
                </ul>
                
                <h3 class="text-muted">DevSkillz</h3>
            </div>