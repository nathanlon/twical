<!DOCTYPE html>
<html lang="en">
<head>
<title>twiCal - your Calendar tweets</title>
</head>
<body>
<h1>TwiCal <span>an open source cal-tweet web service</span></h1>
<img src="/images/twical-icon.png" class="logo" />
<div id="introbox">TwiCal allows you upload your own calendar schedules and receive reminders via twitter for upcoming events , with the goal to use geo lookups as well. The service will allow granular control to the user.</div>

<?php if ($loggedIn): ?>
  <div class="loggedIn">
    <p>You are logged in</p>

    <p>Please look at your calendar settings pages OR upload a new calendar now</p>

    <?php echo form_tag_for($form, '@person_modify') ?>

      <label><?php echo $form['upload']->renderLabel() ?></label>
      <?php echo $form['upload']->render() ?>
      <input type="submit" value="Submit" />
    </form>



  </div>
<?php else: ?>
  <div class="logIn">
  <?php echo link_to(image_tag('/twitteroauth/images/darker.png', array('border' => 0, "class" => 'twitterlogin')), '@login') ?>
  </div>
<?php endif; ?>

</body>
</html>