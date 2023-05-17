<?php
/*
* Plugin Name: Increase file Upload Size limit
* Description: Increases the file upload size limit. Also, control it from the admin panel.
* Version: 1.0
* Author: Sabbir Mahmud
* Author URI: https://profiles.wordpress.org/sabbirmr/
* Author Email: sabbirsp38@gmail.com
* Text Domain: increase-file-upload-size-limit
* License: GPL2
* Requires at least: 5.6
* Tested up to: 6.2
* 
*/

// Add the admin menu
function increase_upload_size_add_admin_menu() {
    add_options_page(
        'Increase Upload Size',
        'Increase Upload Size',
        'manage_options',
        'increase_upload_size',
        'increase_upload_size_options_page'
    );
}
add_action('admin_menu', 'increase_upload_size_add_admin_menu');

// Render the admin options page
function increase_upload_size_options_page() {
    // Check if the user has permission to access the options page
    if (!current_user_can('manage_options')) {
        wp_die('You do not have sufficient permissions to access this page.');
    }

    // Process the form submission
    if (isset($_POST['submit'])) {
        $upload_size = (int) $_POST['upload_size'];
        update_option('upload_size_limit', $upload_size);
        echo '<div class="notice notice-success"><p>Upload size limit updated successfully!</p></div>';
    }

    // Get the current upload size limit
    $current_upload_size = get_option('upload_size_limit', 50);

    // Display the options form
    ?>
    <div class="wrap">
        <h1>Increase Upload File Size</h1>
        <form method="post" action="">
            <table class="form-table">
                <tr>
                    <th scope="row">Upload Size Limit</th>
                    <td>
                        <input type="number" name="upload_size" min="1" step="1" value="<?php echo $current_upload_size; ?>" />
                        <p class="description">Enter the upload size limit in megabytes (MB).</p>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Increase the file upload size limit
function increase_upload_size_limit($upload_size_limit) {
    // Get the custom upload size limit from the options
    $new_upload_size_limit = get_option('upload_size_limit', 50) * 1024 * 1024;

    // Return the new upload size limit
    return $new_upload_size_limit;
}
add_filter('upload_size_limit', 'increase_upload_size_limit', 20);
