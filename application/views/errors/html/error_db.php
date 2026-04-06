<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Set default values untuk undefined variables
$code = isset($code) ? $code : '';
$message = isset($message) ? $message : '';
$filepath = isset($filepath) ? $filepath : '';
$line = isset($line) ? $line : '';
?>
<div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;">
<h4>A Database Error Occurred</h4>
<p>Error Number: <?php echo $code; ?></p>
<p><?php echo $message; ?></p>
<p>Filename: <?php echo $filepath; ?></p>
<p>Line Number: <?php echo $line; ?></p>
</div>
