<?php

error_reporting(0);
require_once 'XMLParser.php';

if (!empty($_GET['source'])) {
    $denied = array('index.php', 'TAC_DOC.xml');
    if (!in_array($_GET['source'], $denied)) {
        show_source($_GET['source']);
        exit;
    } elseif ($_GET['pass'] == 'w00t3rZ') {
        show_source($_GET['source']);
        exit;
    }
}

$xml = new XMLParser('TAC_DOC.xml', @$_GET['class']);

if (!empty($_GET['raw']) && $_GET['raw'] == 'true') {
    print "<pre>\n";
    print_r($xml->getRawData());
    exit;
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
<title><?php echo $xml->getPackageInfo('name'); ?> Documentation</title>
<link rel="stylesheet" href="styles/style.css" />
<link rel="icon" href="http://projects.evilwalrus.com/andrew/php-16x16.gif" type="image/gif">
<link rel="shortcut icon" href="http://projects.evilwalrus.com/andrew/favicon.ico">
</head>

<body bgcolor="#ffffff" text="#000000" link="#000099" alink="#0000ff" vlink="#000099">

<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr bgcolor="#000080">
    <td align="left" bgcolor="#000080"><a href="index.php"><img src="images/aimtoc.png" width="450" height="70" border="0" alt="AIM::TOC Documentation" /></a></td>
  </tr>
  <tr bgcolor="#333366">
    <td><img src="images/spacer.gif" width="1" height="1" border="0" alt="" /></td>
  </tr>
  <tr bgcolor="#0066CC">
    <td align="right" valign="top" class="quicksearch">
    <?php
    if (!empty($_GET['class']) && !empty($_GET['function'])) {
        echo $_GET['class'] . '::<b>' . $_GET['function'] . '</b>';
    }
    ?>&nbsp;
    </td>
  </tr>
  <tr bgcolor="#333366">
    <td><img src="images/spacer.gif" width="1" height="1" border="0" alt /></td>
  </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0">
  <tr valign="top">
    <td width="225" bgcolor="#f0f0f0">
    <table width="100%" cellpadding="2" cellspacing="0" border="0">
      <tr valign="top">
        <td class="sidebar">
        <div class="mtoc">
          <div class="toch">
          <?php
          if (!empty($_GET['class'])) {
              print '<a style="text-decoration:none" title="Go to main index" href="index.php"><b>^</b></a>&nbsp;&nbsp;<a href="index.php?class='.$_GET['class'].'">' . $_GET['class'] . '</a> functions' . "\n";
          } else {
              print $xml->getPackageInfo('name') . ' classes' . "\n";
          }
          ?>
          </div>
          <?php
          if (!empty($_GET['class'])) {
              foreach ($xml->getFunctionList() as $f) {
                  $data = $xml->getFunctionData($f);
                  $style = ($data['access'] == 'private') ? 'style="color:red"' : '';
                  $display = ($f == $_GET['function']) ? '<b>'.$f.'</b>' : $f;
                  print "<div class=\"toci\">&#183; <a " . $style . " href=\"index.php?class=".$_GET['class']."&function=".$f."\">".$display."</a></div>\n";
              }
              print "<hr noshade>\n";
              foreach ($xml->getClassList() as $c) {
                  if ($_GET['class'] != $c) {
                      print "<div class=\"toci\">&#183; <a href=\"index.php?class=".$c."\">" . $c . "</a></div>\n";
                  }
              }
          } else {
              foreach ($xml->getClassList() as $c) {
                  print "<div class=\"toci\">&#183; <a style=\"font-size: 8pt\" href=\"index.php?class=".$c."\">" . $c . "</a></div>\n";
              }
          }
          ?>          
          </div>
        </td>
      </tr>
    </table>
    </td>
    <td bgcolor="#cccccc" background="images/checkerboard.gif" width="1">
    <img src="images/spacer.gif" width="1" height="1" border="0" alt /></td>
    <td>
    <table cellpadding="10" cellspacing="0" width="100%">
      <tr>
        <td valign="top">
        <?php
        if (!empty($_GET['function']) && in_array($_GET['function'], $xml->getFunctionList())) {
            $funcData = $xml->getFunctionData($_GET['function']);
        ?>
        <h1><?php echo $funcData['name']; ?></h1>
        <div CLASS="refnamediv">
          <p>Requires: PHP >= <?php echo $xml->getPackageInfo('require');?></p>
          <?php $funcData['desc'] = $xml->getFunctionDescription($funcData['name']); ?>
          <?php echo $funcData['name']; ?> -- <?php echo $funcData['desc']['short']; ?></div>
        <div CLASS="refsect1">
          <h2>Description</h2>
          <?php echo $xml->colorizeProto($funcData['access'].' '.$funcData['return'].' <b>'.$funcData['name'].'</b> ( '.$funcData['args'].' )'); ?><br>
          <br>
          <p>
          <?php echo $funcData['desc']['long']; ?>
          </p>
        </div>
        <?php
        } elseif (!empty($_GET['class'])) {
            @include_once('text/idx-' . $_GET['class'] . '.php');
        } elseif (!empty($_GET['page'])) {
            @include_once('text/' . $_GET['page'] . '.php');
        } else {
        ?>
<!--Default Placeholder -->
        <p>Welcome to the official <?php echo $xml->getPackageInfo('name'); ?> documentation.</p>
        <p>In the following pages, you will find all the information you need on making 
        complete use of the <?php echo $xml->getPackageInfo('name'); ?> classes.&nbsp; Please read the following requirements, 
        so you have full usage of the <?php echo $xml->getPackageInfo('name'); ?> classes:</p>
        <ul>
          <li>PHP 5.0 (unreleased as of this writing)</li>
          <li>Output buffering enabled</li>
          <li>PHP-CLI capabilities</li>
          <li>PHP compiled with socket extensions</li>
        </ul>
        <p>If you have the above enabled for the usage of <?php echo $xml->getPackageInfo('name'); ?>, then please read the 
        rest of this documentation to gain a better understanding of how you can use <?php echo $xml->getPackageInfo('name'); ?> 
        to it&#39;s fullest extent.</p>
        <p><b>NOTE:</b> Any functions listed in <span style="color:red;font-weight:bold">red</span> are private functions, and not available to the user 
        outside of the class in which it is implemented.</p>
        <hr noshade color="#000000">
        <p align="right"><?php echo $xml->getPackageInfo('name'); ?> is (c)2002-2003 <a href="mailto:andrew@evilwalrus.com">
        Andrew Heebner</a> / <a href="http://www.evilwalrus.com">EvilWalrus.com</a><br>
        <a href="index.php?source=LICENSE">Click for license details</a></p>
        <?php
        }
        ?>
       </td>
      </tr>
    </table>
    <img src="images/spacer.gif" width="175" height="1" border="0" alt="" />
   </td>
  </tr>
</table>

<!-- spacer cell -->
<table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr bgcolor="#333366"><td><img src="images/spacer.gif" width="1" height="1" border="0" alt="" /></td></tr>
    <tr bgcolor="#0066CC">
        <td align="right" valign="bottom" bgcolor="#0066CC" class="quicksearch">&nbsp;</td>
    </tr>
    <tr bgcolor="#333366">
        <td><img src="images/spacer.gif" width="1" height="1" border="0" alt="" /></td>
    </tr>
</table>

<!-- copyright info -->
<table border="0" cellspacing="0" cellpadding="6" width="100%">
    <tr valign="top" bgcolor="#CCCCCC">
        <td align="left"><small>(c)2003 <a href="index.php?page=author">Andrew Heebner</a> (Design (c)2001-2003 The PHP Group)</small></td>
        <td align="right"><small>Using TAC_DOC.xml (<?php echo $xml->getPackageInfo('revision');?>)</small></td>
    </tr>
</table>
<br />
<center>
<span style="font-size:8pt;color:#BBBBBB"><a href="index.php?page=copyright">&copy;2003 Andrew Heebner</a></span>
</center>
<br />
</body>
</html>