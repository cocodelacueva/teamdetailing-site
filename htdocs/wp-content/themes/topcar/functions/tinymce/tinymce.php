<?php
$absolute_path = __FILE__;
$path_to_file = explode('wp-content', $absolute_path);
$path_to_wp = $path_to_file[0];

//WP
require_once( $path_to_wp . '/wp-load.php' );
?>
<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8">
	<style>
		#main-shortcodes { width: 95%; }
		#ozy-shortcodes label { font-weight: bold; }
		#ozy-shortcodes label em { font-weight: normal; }
		#ozy-shortcodes th { padding: 18px 10px; }
		#ozy-shortcodes .red { color: red; }
		#ozy-shortcode-tr { display:none; }
	</style>
    
    <script type="text/javascript" src="<?php echo get_template_directory_uri() . '/scripts/icon-select.js'; ?>"></script>
</head>
<body>

<div id="main-shortcodes">

	<table id="ozy-shortcodes" class="form-table">

		<tbody>

			<!-- dropdown -->
			<tr>

				<th class="label">

					<label for="shortcode-dropdown"><?php _e('Shortcodes', 'ozy_backoffice'); ?></label>

				</th>

				<td class="field">
			
					<select name="shortcode-dropdown" id="shortcode-dropdown" class="widefat">
						<option value=""><?php _e('Pick a Shortcode', 'ozy_backoffice'); ?></option>
						<optgroup label="- <?php _e('Content', 'ozy_backoffice'); ?> - ">
							<option value="button-code"><?php _e('Button', 'ozy_backoffice'); ?></option>
							<option value="dropcap"><?php _e('Dropcap', 'ozy_backoffice'); ?></option>
							<option value="list"><?php _e('List', 'ozy_backoffice'); ?></option>
							<option value="highlight-text"><?php _e('Hightlighted Text', 'ozy_backoffice'); ?></option>
							<option value="lightbox"><?php _e('Lightbox', 'ozy_backoffice'); ?></option>
							<option value="typeicon"><?php _e('Type Icon', 'ozy_backoffice'); ?></option>
                            <option value="badge_label"><?php _e('Badge &amp; Label', 'ozy_backoffice'); ?></option>
						</optgroup>
					</select>

				</td>

			</tr>

			<!-- highlight -->
			<tr class="option highlight-text">

				<th class="label">

					<label for="highlight-text-text"><?php _e('Highlighted Text', 'ozy_backoffice'); ?></label>
                    					
				</th>

				<td class="field">
				
                	<input type="text" name="highlight-text-text" id="highlight-text-text" value="" class="widefat">

				</td>

			</tr>      

			<!-- button-code -->
			<tr class="option button-code">

				<th class="label">

					<label for="button-code-content"><?php _e('Text', 'ozy_backoffice'); ?><span class="red">*</span></label>

				</th>

				<td class="field">
				
					<input type="text" name="button-code-content" id="button-code-content" value="" class="widefat">

				</td>

			</tr>

			<tr class="option button-code">

				<th class="label">

					<label for="button-code-url"><?php _e('URL', 'ozy_backoffice'); ?><span class="red">*</span></label>

				</th>

				<td class="field">
				
					<input type="text" name="button-code-url" id="button-code-url" value="" class="widefat">

				</td>

			</tr>
            
			<tr class="option button-code">

				<th class="label">

					<label for="button-code-size"><?php _e('Button Size', 'ozy_backoffice'); ?></label>

				</th>

				<td class="field">
				
					<select name="button-code-size" id="button-code-size" class="widefat">
                        <option value="wpb_regularsize">medium</option>
                        <option value="wpb_btn-large">large</option>
                        <option value="wpb_btn-small">small</option>
                        <option value="wpb_btn-mini">mini</option>
                    </select>

				</td>

			</tr>            

			<tr class="option button-code">

				<th class="label">

					<label for="button-code-style"><?php _e('Icon', 'ozy_backoffice'); ?></label>

				</th>

				<td class="field">
	                <input type="text" name="button-code-icon" id="button-code-icon" value="" class="widefat type-icon-select-box">
				</td>

			</tr>
            
			<tr class="option button-code">

				<th class="label">

					<label for="button-lightbox"><?php _e('LightBox', 'ozy_backoffice'); ?></label>

				</th>

				<td class="field">
				
					<select name="button-lightbox" id="button-lightbox" class="widefat">
                        <option value="false">false</option>
                        <option value="true">true</option>
                    </select>

				</td>

			</tr>
            
			<tr class="option button-code">

				<th class="label">

					<label for="button-lightbox_group"><?php _e('LightBox Group Name', 'ozy_backoffice'); ?></label>

				</th>

				<td class="field">
	                <input type="text" name="button-lightbox_group" id="button-lightbox_group" value="" class="widefat">
				</td>

			</tr>            

			<!-- dropcap -->
			<tr class="option dropcap">

				<th class="label">

					<label for="dropcap-content"><?php _e('Text', 'ozy_backoffice'); ?><span class="red">*</span></label>

				</th>


				<td class="field">
					
					<input type="text" name="dropcap-content" id="dropcap-content" value="" class="widefat">

				</td>

			</tr>

			<tr class="option dropcap">

				<th class="label">

					<label for="dropcap-size"><?php _e('Size', 'ozy_backoffice'); ?></label>

				</th>

				<td class="field">
				
					<select name="dropcap-size" id="dropcap-size" class="widefat">
                    <?php
						$selected = "";
						for($i=6; $i<=128; $i++) {
							$selected = ($i == 22 ? ' selected' : '');
							echo '<option value="' . $i . '" ' . $selected . '>' . $i . 'px</option>';
						}
					?>
                    </select>

				</td>

			</tr>

			<tr class="option dropcap">

				<th class="label">

					<label for="dropcap-type"><?php _e('Background', 'ozy_backoffice'); ?><span class="red">*</span></label>

				</th>

				<td class="field">
				
					<select name="dropcap-type" id="dropcap-type" class="widefat">
						<option value="clean" selected><?php _e('Clean', 'ozy_backoffice'); ?></option>
						<option value="rounded"><?php _e('Rounded Background', 'ozy_backoffice'); ?></option>
                        <option value="rectangle"><?php _e('Rectangle Background', 'ozy_backoffice'); ?></option>
					</select>
                    
				</td>

			</tr>

			<!-- typeicon -->            
			<tr class="option typeicon">

				<th class="label">

					<label for="typeicon-icon"><?php _e('Icon', 'ozy_backoffice'); ?></label>

				</th>

				<td class="field">
	                <input type="text" name="typeicon-icon" id="typeicon-icon" value="" class="widefat type-icon-select-box">
				</td>

			</tr>
            
			<tr class="option typeicon">

				<th class="label">

					<label for="typeicon-size"><?php _e('Size', 'ozy_backoffice'); ?></label>

				</th>

				<td class="field">
				
					<select name="typeicon-size" id="typeicon-size" class="widefat">
                    <?php
						$selected = "";
						for($i=6; $i<=128; $i++) {
							$selected = ($i == 12 ? ' selected' : '');
							echo '<option value="' . $i . '" ' . $selected . '>' . $i . 'px</option>';
						}
					?>
                    </select>

				</td>

			</tr>            
            
			<!-- list -->
			<tr class="option list">

				<th class="label">

					<label for="list-style"><?php _e('Icon', 'ozy_backoffice'); ?></label>

				</th>

				<td class="field">
					<input type="text" name="list-icon" id="list-icon" value="" class="widefat type-icon-select-box">
				</td>

			</tr>
            
			<tr class="option list">

				<th class="label">

					<label for="list-list-style"><?php _e('or use Classic', 'ozy_backoffice'); ?></label>

				</th>

				<td class="field">
					<select name="list-list-style" id="list-list-style" class="widefat">
                    	<option value="">--------</option>
                        <option value="none">none</option>
                        <option value="armenian">armenian</option>
                        <option value="circle">circle</option>
                        <option value="disc">disc</option>
                        <option value="square">square</option>
                        <option value="cjk-ideographic">cjk-ideographic</option>
                        <option value="decimal">decimal</option>
                        <option value="decimal-leading-zero">decimal-leading-zero</option>
                        <option value="georgian">georgian</option>
                        <option value="hebrew">hebrew</option>
                        <option value="hiragana">hiragana</option>
                        <option value="hiragana-iroha">hiragana-iroha</option>
                        <option value="katakana">katakana</option>
                        <option value="katakana-iroha">katakana-iroha</option>
                        <option value="lower-alpha">lower-alpha</option>
                        <option value="lower-greek">lower-greek</option>
                        <option value="lower-latin">lower-latin</option>
                        <option value="lower-roman">lower-roman</option>
                        <option value="upper-alpha">upper-alpha</option>
                        <option value="upper-latin">upper-latin</option>
                        <option value="upper-roman">upper-roman</option>
                    </select>
				</td>

			</tr>            


			<tr class="option list">

				<th class="label">

					<label for="list-content"><?php _e('Content', 'ozy_backoffice'); ?><span class="red">*</span></label>

				</th>

				<td class="field">
				
					<textarea name="list-content" id="list-content" cols="30" rows="5" class="widefat"></textarea>
					<em>Each line will be processed as a list item</em>
				</td>

			</tr>

			<!-- lightbox -->
			<tr class="option lightbox">

				<th class="label">

					<label for="lightbox-type"><?php _e('Type', 'ozy_backoffice'); ?></label>

				</th>

				<td class="field">

					<select name="lightbox-type" id="lightbox-type" class="widefat">
						<option value="colorbox-image" selected><?php _e('Image / Gallery', 'ozy_backoffice'); ?></option>
						<option value="colorbox-iframe"><?php _e('Iframe', 'ozy_backoffice'); ?></option>
					</select>

				</td>

			</tr>

			<tr class="option lightbox">

				<th class="label">

					<label for="lightbox-full"><?php _e('Full (URL)', 'ozy_backoffice'); ?><span class="red">*</span></label>

				</th>

				<td class="field">
					
					<input type="text" name="lightbox-full" id="lightbox-full" value="" class="widefat">

				</td>

			</tr>

			<tr class="option lightbox">

				<th class="label">

					<label for="lightbox-title"><?php _e('Title', 'ozy_backoffice'); ?></label>

				</th>

				<td class="field">
					
					<input type="text" name="lightbox-title" id="lightbox-title" value="" class="widefat">

				</td>

			</tr>

			<tr class="option lightbox">

				<th class="label">

					<label for="lightbox-group"><?php _e('Group name (lowercase)', 'ozy_backoffice'); ?><br /><em><?php _e('(use to build image gallery)', 'ozy_backoffice'); ?></em></label>

				</th>

				<td class="field">
					
					<input type="text" name="lightbox-group" id="lightbox-group" value="" class="widefat">

				</td>

			</tr>

			<tr class="option lightbox">

				<th class="label">

					<label for="lightbox-content"><?php _e('Content', 'ozy_backoffice'); ?><span class="red">*</span></label>

				</th>

				<td class="field">
				
					<textarea name="lightbox-content" id="lightbox-content" cols="30" rows="2" class="widefat"></textarea>

				</td>

			</tr>
            
			<!-- bootstrap label & badge -->
			<tr class="option badge_label">

				<th class="label">

					<label for="badge_label-content"><?php _e('Content', 'ozy_backoffice'); ?></label>

				</th>

				<td class="field">
					<input type="text" name="badge_label-content" id="badge_label-content" value="" class="widefat">
				</td>

			</tr>
            
			<tr class="option badge_label">

				<th class="label">

					<label for="badge_label-style"><?php _e('Style', 'ozy_backoffice'); ?></label>

				</th>

				<td class="field">
					<select name="badge_label-style" id="badge_label-style" class="widefat">
                    	<option value="">default</option>
                        <option value="success">success</option>
                        <option value="warning">warning</option>
                        <option value="important">important</option>
                        <option value="info">info</option>
                        <option value="inverse">inverse</option>
                    </select>
				</td>

			</tr>            

			<tr class="option badge_label">

				<th class="label">

					<label for="badge_label-type"><?php _e('Type', 'ozy_backoffice'); ?></label>

				</th>

				<td class="field">
					<select name="badge_label-type" id="badge_label-type" class="widefat">
                        <option value="label">label</option>
                    	<option value="badge">badge</option>
                    </select>
				</td>

			</tr> 
       

			<!-- shortcode attributes zone -->
			<tr id="ozy-shortcode-tr">

				<th class="label">

					<label for="shortcode-dropdown"><?php _e('Current shortcode with all available attributes', 'ozy_backoffice'); ?><br />					
					<em><?php _e('Inputs which marked with', 'ozy_backoffice') ?> <span class="red">*</span> <?php _e('are required', 'ozy_backoffice'); ?></em></label>

				</th>

				<td class="field">

					<code id="shortcode"></code>

				</td>

			</tr>

			<!-- insert shortcode button -->
			<tr>

				<th class="label"></th>

				<td class="field">

					<p><button id="insert-shortcode" class="button-primary"><?php _e('Insert Shortcode', 'ozy_backoffice'); ?></button></p>

				</td>

			</tr>

		</tbody>

	</table>
	
</div><!-- end #main -->

<script>jQuery('.option').hide();</script>

</body>
</html>