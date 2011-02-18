<h2>Buddy Introduction and Explanation</h2>

<p>
The Buddy class provides a means for the client to add, remove and update users to the client's buddylist.
</p>
<p>
With the reverse engineering of the TOC2.0 protocol complete, the buddylist no longer needs to be saved on the client-side, as the TOC servers now handle the buddylists and user info (much like OSCAR).
</p>
<hr>
<!-- Display class functions -->
<h2>Functions provided by Buddy</h2>
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