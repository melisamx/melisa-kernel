<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if( function_exists('message')) :
    
    message(array(
        'line'=>__LINE__,
        'file'=>__FILE__,
        'msg'=>$heading.' => '.$message
    ));
    
else:
?>

<div id="container">
    <h1><?php echo $heading; ?></h1>
    <?php echo $message; ?>
</div>

<?php endif;

