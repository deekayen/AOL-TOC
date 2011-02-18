<h2>TAC Introduction and Explanation</h2>

<p>
TAC is the core class file of the TAC package.  All the other classes in this package depend on TAC's portability and function base.
</p>
TAC provides a framework from which to work with all the adjoining classes in the package.  From this class, a user can maintain a portable codebase for which to make his/her own AOL(r) Instant Messenger(tm) informational bot.
</p>
<p>
For an example of how to use the base files, please see the following links:
<ul>
<li><a href="examples/lib/Callbacks.phps">lib/Callbacks.php</a></li>
<li><a href="examples/bot.phps">bot.php</a></li>
</ul>
</p>
<p>
<b>bot.php</b> is the initialization script, and within this, you can find all of the runtime options and preferences (you must change the screenname/password, that's required).  The callback file (<b>lib/Callbacks.php</b>) defines a class of functions that our handlers (as listed in bot.php) must use in order to provide a server to the messages recieved.
<hr>
<!-- Display class functions -->
<h2>Functions provided by TAC</h2>
<?php
if (!empty($_GET['class'])) {
    print "<ul>\n";
    foreach ($xml->getFunctionList() as $f) {
        $data = $xml->getFunctionData($f);
	if ($data['access'] == 'private') {
	    $style = 'style="color:red"';
	} else {
	    $style = '';
	}
        $display = ($f == $_GET['function']) ? '<b>'.$f.'</b>' : $f;
        print "<li><a " . $style . " href=\"index.php?class=".$_GET['class']."&function=".$f."\">".$display."</a></li>\n";
    }
    print "</ul>\n";
}
?>  