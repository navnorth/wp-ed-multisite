<div class="wrap">
    <h2>Import Organizations</h2>
    <?php
        if($success): ?>
        <div id="message" class="updated notice notice-success is-dismissible below-h2"><p>Organizations imported. <a href="?page=get-organizations">View orgnizations</a></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>
    <?php
        endif; ?>
    <form enctype="multipart/form-data" method="post" class="media-upload-form" id="file-form">
        <p><input type="file" name="organizations" id="organizations"><input type="submit" name="html-upload" id="html-upload" class="button" value="Upload"></p>
        <div class="clear"></div>
        <p class="max-upload-size">Maximum upload file size: 32 MB.</p>
    </form>
</div>