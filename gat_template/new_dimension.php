<div class="row dimension">
    <div class="col-md-1">
        <span class="dimension-count"><?php echo $n; ?>.</span>
    </div>
    
    <div class="col-md-10">
        <input type="text" class="dimension-title" size="30" spellcheck="true" autocomplete="off" />
        
        <div id="wp-<?php echo $id; ?>-wrap" class="wp-core-ui wp-editor-wrap tmce-active"> 
            <div id="wp-<?php echo $id; ?>-editor-tools" class="wp-editor-tools hide-if-no-js">
                <div class="wp-editor-tabs">
                    <button type="button" id="<?php echo $id; ?>-tmce" class="wp-switch-editor switch-tmce" onclick="switchEditors.switchto(this);">Visual</button>
                    <button type="button" id="<?php echo $id; ?>-html" class="wp-switch-editor switch-html" onclick="switchEditors.switchto(this);">Text</button>
                </div>
            </div>
            
            <div id="wp-<?php echo $id; ?>-editor-container" class="wp-editor-container">
                <textarea class="wp-editor-area" id="<?php echo $id; ?>"></textarea>
            </div>
        </div>
        
        <p class="clearfix"><span style="line-height: 2em;">Associated Videos:</span><button type="button" class="button new-media pull-right">Add <i class="fa fa-plus"></i></button></p>
        
        <table class="wp-list-table widefat striped">
            <thead>
                <tr>
                    <th scope="col" class="manage-column media-label">Label</th>
                    <th scope="col" class="manage-column media-youtube">Youtube ID</th>
                    <th scope="col" class="manage-column media-cb">1</th>
                    <th scope="col" class="manage-column media-cb">2</th>
                    <th scope="col" class="manage-column media-cb">3</th>
                    <th scope="col" class="manage-column media-cb">4</th>
                    <th scope="col" class="manage-column media-button">Remove</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="media-label">
                        <input type="text" placeholder="Label" />
                    </td>
                    <td class="media-youtube">
                        <input type="text" placeholder="Youtube ID" />
                    </td>
                    <td><input type="checkbox" /></td>
                    <td><input type="checkbox" /></td>
                    <td><input type="checkbox" /></td>
                    <td><input type="checkbox" /></td>
                    <td class="media-button">
                        <a href="#" class="delete-media"><i class="dashicons dashicons-trash"></i></a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <div class="col-md-1">
        <a href="#" class="dimension-remove"><i class="dashicons dashicons-trash"></i></a>
        <a href="#" class="dimension-move <?php echo ($n == 1) ? "down" : "up"; ?>"><i class="dashicons dashicons-arrow-<?php echo ($n == 1) ? "down" : "up"; ?>-alt"></i></a>
    </div>
</div>