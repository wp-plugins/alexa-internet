<?php
$updated = false;
$error = array();
$certify = "";
$verify = "";

//must check that the user has the required capability 
if (!current_user_can('manage_options')) {
    wp_die( __('You do not have sufficient permissions to access this page.') );
}

if (isset($_POST["alexacertify_hidden"]) && $_POST["alexacertify_hidden"] == "Y") {
	// Form set
	$certify = trim(stripslashes($_POST["alexacertify_certify"]));
	$verify = trim(stripslashes($_POST["alexacertify_verify"]));

	if ($certify) {
		if (!preg_match("|<script [^>]*>[^<]*</script><script [^>]*>[^<]*</script><noscript><img [^>]*></noscript>|", $certify)) {
			$error["certify"] = "Invalid Certify Code";
		}
	}

	if ($verify) {
	    if (!preg_match('/^([^\'"])+$/', $verify)) {
	        $error["verify"] = "Invalid Verifcation ID";
	    }
	}

	if (!count($error)) {
		update_option('alexacertify_certify', $certify);
		update_option('alexacertify_verify', $verify);
		$updated = true;
	}
} else {
	// Normal display
	$certify = get_option("alexacertify_certify");
	$verify = get_option("alexacertify_verify");
}

$formAction = str_replace( '%7E', '~', $_SERVER['REQUEST_URI']);
?>

<?php if ($updated): ?>
    <div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
<?php endif;?>   

<?php if (!empty($error)): ?>
    <div class="error"><?= implode("<br />\n", $error) ?></div>
<?php endif; ?>

<div class="wrap">
    <h2> The Official Alexa WordPress Plugin </h2>

	<form name="alexacertify_form" method="post" action="<?php echo $formAction ?>">
        <input type="hidden" name="alexacertify_hidden" value="Y"/>
        
        <h3> Claim Your Site </h3>
        <p>
            To claim your site on Alexa, enter your verification ID below and then press the "Verify my ID" button at 
            <a href="http://www.alexa.com/" target="_blank">Alexa.com</a>.
            <br/>
            If you need a verification ID, please visit Alexa's 
            <a href="http://www.alexa.com/siteowners/claim" target="_blank">Claim Your Site</a> page.
        </p>    
	    <p>
	        Verification ID:
            <br/>
	        <input type="text" name="alexacertify_verify" value="<?= htmlspecialchars($verify) ?>" size="40">
            <br/>
            example: kbgNFC70SGDf0pmgwT0VGoKlRtI
        </p>
        
        <br/>
        <h3>
            Certified Site Metrics
        </h3>
        <p>
            Alexa Pro customers have the opportunity to have their website traffic
            Certified by Alexa. To learn more, visit Alexa's 
            <a href="http://www.alexa.com/products" target="_blank">professional products</a> page.
	        <br/>
	        If you are an Alexa Pro customer, paste your Certify Code into the box
	        below and the Certification process will begin shortly.
        </p>    
        <p>
	        Certify Code:
            <br />
            <textarea name="alexacertify_certify" style="width: 80%; height: 8em;"><?= htmlspecialchars($certify) ?></textarea>
        </p>
        <p class="submit">  
           <input type="submit" name="Submit" value="Update Options" />  
        </p>
    </form>
</div>
