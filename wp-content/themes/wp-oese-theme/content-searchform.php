<?php
/**
 * Template for displaying search forms in Oese Theme
 * @package WordPress
 * @subpackage Oese Theme
 * @since Oese Theme 1.0
 */
?>

<form id="searchformContent" class="searchform" action="<?php echo site_url(); ?>" method="get" role="search">
    <div class="input-group to-focus">
        <label class="search-label" for="inputSuccess2Content">Search:</label>
        <input type="text" class="form-control full-search-input" id="inputSuccess2Content" placeholder="Search" name="s"/>
        <div class="input-group-append">
            <button class="btn btn-secondary custom-search-btn" type="button" onClick="jQuery(this).closest('form').submit()">
            <i class="fas fa-search"></i><span class="search-button-label">Search</span>
            </button>
        </div>
    </div>
</form>