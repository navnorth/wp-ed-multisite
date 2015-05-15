<style>
    * {
        box-sizing: border-box;
    }
    .row {
        margin: 0 -15px;
    }
    .clearfix:before,
    .clearfix:after {
        content: " ";
        display: table;
    }
    .clearfix:after {
        clear: both;
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
        color: #777;
        font-size: 15px;
        margin-top: 10px;
        display: block;
    }
    .dimension-remove,
    .dimension-move {
        display: block;
        text-align: center;
        color: #777;
        text-decoration: none;
        margin-top: 10px;
    }
</style>

<div class="dimensions">
    <?php $n = 1; include(GAT_PATH . "/gat_template/new_dimension.php"); ?> 
</div>

<p><button type="button" id="new-dimension" class="button">Add New Dimension</button></p>
