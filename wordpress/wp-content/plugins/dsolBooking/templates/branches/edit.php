<link href="<?php echo plugins_url(); ?>/dsolBooking/css/dsol_meetings.css" rel="stylesheet" type="text/css"/>
<div class=wrap>
	<div id="icon-options-general" class="icon32"></div>
	<h2>
		<?php _e( 'Book a Room Administration - Branches', 'book-a-room' ); ?>
	</h2>
</div>
<h2>
	<?php
	switch ( $action ) {
		case 'addCheck':
		case 'add':
			_e( 'Add Branch', 'book-a-room' );
			break;
		case 'editCheck':
		case 'edit':
			_e( 'Edit Branch', 'book-a-room' );
			break;
		default:
			wp_die( "ERROR: BAD ACTION on branch add/edit: " . $action );
			break;
	}
	?>
</h2>
<?php
# Display Errors if there are any
if ( !empty( $branchInfo[ 'errors' ] ) ) {
	?>
<p>
	<h3 style="color: red;"><strong><?php echo $branchInfo['errors']; ?></strong></h3>
</p>
<?php
}
?>
<pre>
	<?php
		print_r($branchInfo)
	?>
</pre>
<form id="form1" name="form1" method="post" action="?page=dsol_Settings_Branches&b_id=<?PHP echo $branchInfo['b_id']; ?>&action=<?php echo $action; ?>">
	<table class="tableMain">
		<tr>
			<td>
				<?php _e( 'Description', 'book-a-room' ); ?>
			</td>
			<td colspan="2">
				<?php _e( 'Setting', 'book-a-room' ); ?>
			</td>
		</tr>
		<tr>
			<td>
				<?php _e( 'Branch Name', 'book-a-room' ); ?>
			</td>
			<td colspan="2"><input name="b_name" type="text" id="b_name" value="<?php echo $branchInfo['b_name']; ?>" size="50" maxlength="64"/>
			</td>
		</tr>		
		<tr>
			<!-- -------------------------------------------------------------------------- -->
			<!-- days start -->
			<?php
			$days = array( 0 => __( 'Sunday Open/Close (HH:MM)', 'book-a-room' ), __( 'Monday Open/Close', 'book-a-room' ), __( 'Tuesday Open/Close', 'book-a-room' ), __( 'Wednesday Open/Close', 'book-a-room' ), __( 'Thursday Open/Close', 'book-a-room' ), __( 'Friday Open/Close', 'book-a-room' ), __( 'Saturday Open/Close', 'book-a-room' ) );
			foreach ( $days as $num => $dayName ) {
			?>
		</tr>
		<tr>
			<td>
				<?php echo $dayName; ?>
			</td>
			<td><input name="branchOpen_<?php echo $num; ?>" type="text" id="branchOpen_<?php echo $num; ?>" value="<?php echo $branchInfo['schedule'][$num]["open_time"]; ?>" size="5" maxlength="5"/>
			<input type="checkbox" name="branchOpen_<?php echo $num; ?>PM" id="branchOpen_<?php echo $num; ?>PM" />
				<?php _e( 'PM', 'book-a-room' ); ?>
			</td>
			<td><input name="branchClose_<?php echo $num; ?>" type="text" id="branchClose_<?php echo $num; ?>" value="<?php echo $branchInfo['schedule'][$num]["close_time"]; ?>" size="5" maxlength="5"/>
			<input type="checkbox" name="branchClose_<?php echo $num; ?>PM" id="branchClose_<?php echo $num; ?>PM" />
				<?php _e( 'PM', 'book-a-room' ); ?>
			</td>
		</tr>
		<?php
		}
		?>
		<!-- -------------------------------------------------------------------------- -->
		<!-- days end -->
		<tr>
			<td colspan="3"><input type="submit" name="button" id="button" value="<?php _e( 'Submit', 'book-a-room' ); ?>"/>
			</td>
		</tr>
	</table>
</form>
<p>
	<a href="?page=dsol_Settings_Branches">
		<?php _e( 'Return to Branches Home.', 'book-a-room' ); ?>
	</a>
</p>