<h1>Welcome to TwiCal.net</h1>

<div>TwiCal allows you receive reminders via twitter for upcoming events in your Google Calendar</div>

<?php if ($loggedIn): ?>
<div class="loggedIn">You are logged in</div>
<?php else: ?>
<div class="loggedIn"><?php echo link_to('Log in using Twitter', '@login') ?></div>
<?php endif; ?>