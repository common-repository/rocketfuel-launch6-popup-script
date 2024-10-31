<?php
/**
 * Admin Options Form
 *
 * Options form for the plugin.
 *
 * @package WordPress
 */

?>

<form method="post" action="" id="l6-options-form">
	<input type="hidden" name="nonce" value="<?php echo esc_html( wp_create_nonce( 'l6_nonce_admin_save' ) ); ?>" />
	<img id="l6-logo" src="<?php echo esc_url( L6_PLUGIN_URL . 'assets/img/logo.png' ); ?>">
	<fieldset>
		<legend>To install Launch6, paste your snippet code in the text box below and click <em>Save</em>. That's it!</legend>
		<p>
			At <b>Launch6</b>, we provide easy to use online tools to help you capture leads, go viral and 
			engage your customers to take action. We have taken 30 years of tested and proven scientific 
			laws and integrate them into highly customizable, pre-built templates that we offer to our 
			customers for free. To review our newest features, 
			<a href="http://launch6.com/features" target="_blank">click here</a>.
		</p>
		<table cellpadding="0" cellspacing="0">
			<tr>
				<td colspan="2">
					<textarea name="l6-footer" rows="10"><?php echo wp_kses( get_option( 'l6-footer-script' ), array(
					    'script' => array(
					        'src' => array(),
					        'async' => array(),
				    	),
					));
					?></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="submit" class="button" id="sub" name="sub" value="Save"/>
				</td>
			</tr>
		</table>
	</fieldset>
</form>

<?php require dirname( __FILE__ ) . '/admin.footer.php'; ?>
