    <div>
      <h2>Welcome to a Twitter OAuth PHP example.</h2>

      <p>This site is a basic showcase of Twitters new OAuth authentication method. If you are having issues try <a href='http://twitteroauth.labs.poseurtech.com/clearsessions.php'>clearing your session</a>.</p>

      <p>
        Links:
        <a href='http://github.com/abraham/twitteroauth'>Source Code</a> &amp;
        <a href='https://docs.google.com/View?docID=dcf2dzzs_2339fzbfsf4'>Documentation</a> |
        Contact @<a href='http://twitter.com/abraham'>abraham</a>
      </p>
      <hr />
      <?php if (isset($menu)) { ?>
        <?php echo $menu; ?>
      <?php } ?>
    </div>
    <?php if (isset($status_text)) { ?>
      <?php echo '<h3>'.$status_text.'</h3>'; ?>
    <?php } ?>
    <p>
        <?php echo $content; ?>
    </p>
