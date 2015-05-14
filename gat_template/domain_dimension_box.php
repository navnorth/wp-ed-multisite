<style>
    * {
        box-sizing: border-box;
    }
    .row {
        margin: 0 -15px;
    }
    .row:after {
        display: table;
        content: " ";
        clear: both;
    }
    .row:before {
        display: table;
        content: " ";
    }
    :after, :before {
        box-sizing: border-box;
    }
    .col-md-1, .col-md-10 {
        float: left;
        padding-right: 15px;
        padding-left: 15px;
        position: relative;
        min-height: 1px;
    }
    .col-md-1 {
        width: 8.33333333%;
    }
    .col-md-10 {
        width: 83.33333333%;
    }
    .dimension-title {
        padding: 3px 8px;
        font-size: 1.7em;
        line-height: 100%;
        height: 1.7em;
        width: 100%;
        outline: 0;
        margin: 0 0 3px;
        background-color: #fff;
    }
    .dimension {
        margin-top: 25px;
    }
    .dimension-count {
        font-weight: bold;
        color: #A0A5AA;
        font-size: 15px;
        margin-top: 10px;
        display: block;
    }
    .dimension-remove,
    .dimension-move {
        display: block;
        text-align: center;
        color: #a0a5aa;
        text-decoration: none;
        margin-top: 10px;
    }
</style>
<div class="row dimension">
    <div class="col-md-1">
        <span class="dimension-count">1.</span>
    </div>
    
    <div class="col-md-10">
        <input type="text" class="dimension-title" size="30" spellcheck="true" autocomplete="off" />
        <?php wp_editor(NULL, "editor-one", array("media_buttons" => FALSE, "teeny" => TRUE, "textarea_rows" => 1)); ?>
        <p style="text-align: right;"><button type="button" class="button">Add <i class="fa fa-plus"></i></button></p>
    </div>
    
    <div class="col-md-1">
        <a href="#" class="dimension-remove"><i class="dashicons dashicons-trash"></i></a>
        <a href="#" class="dimension-move"><i class="dashicons dashicons-arrow-down-alt"></i></a>
    </div>
</div>
<div class="row dimension">
    <div class="col-md-1">
        <span class="dimension-count">2.</span>
    </div>
    
    <div class="col-md-10">
        <input type="text" class="dimension-title" size="30" spellcheck="true" autocomplete="off" />
        <?php wp_editor(NULL, "editor-two", array("media_buttons" => FALSE, "teeny" => TRUE, "textarea_rows" => 1)); ?>
        <p style="text-align: right;"><button type="button" class="button">Add <i class="fa fa-plus"></i></button></p>
    </div>
    
    <div class="col-md-1">
        <a href="#" class="dimension-remove"><i class="dashicons dashicons-trash"></i></a>
        <a href="#" class="dimension-move"><i class="dashicons dashicons-arrow-up-alt"></i></a>
    </div>
</div>
<p>
<button type="button" class="button">Add New Dimension</button></p>
