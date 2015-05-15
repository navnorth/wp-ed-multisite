<div class="row dimension">
    <div class="col-md-1">
        <span class="dimension-count"><?php echo $n; ?>.</span>
    </div>
    
    <div class="col-md-10">
        <input type="text" class="dimension-title" size="30" spellcheck="true" autocomplete="off" />
        <?php wp_editor(NULL, "editor-" . $n, array("media_buttons" => FALSE, "teeny" => TRUE, "textarea_rows" => 1)); ?>
        <p class="clearfix"><span style="line-height: 2em;">Associated Videos:</span><button type="button" class="button pull-right">Add <i class="fa fa-plus"></i></button></p>
        <table class="wp-list-table widefat striped">
            <thead>
                <tr>
                    <th scope="col" class="manage-column">Label</th>
                    <th scope="col" class="manage-column">Youtube ID</th>
                    <th scope="col" class="manage-column">1</th>
                    <th scope="col" class="manage-column">2</th>
                    <th scope="col" class="manage-column">3</th>
                    <th scope="col" class="manage-column">4</th>
                    <th scope="col" class="manage-column">Remove</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Bridging Home and School through Technology</td>
                    <td>as24Yw64R</td>
                    <td><input type="checkbox" /></td>
                    <td><input type="checkbox" /></td>
                    <td><input type="checkbox" /></td>
                    <td><input type="checkbox" /></td>
                    <td align="center"><a href="#"><i class="dashicons dashicons-trash"></i></a></td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <div class="col-md-1">
        <a href="#" class="dimension-remove"><i class="dashicons dashicons-trash"></i></a>
        <a href="#" class="dimension-move"><i class="dashicons dashicons-arrow-up-alt"></i></a>
    </div>
</div>