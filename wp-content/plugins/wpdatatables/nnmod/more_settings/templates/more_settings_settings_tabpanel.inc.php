<!-- Loading Indicator settings -->
<div role="tabpanel" class="tab-pane" id="loading-indicator-settings">
    <!-- .row -->
    <div class="row">
        <!-- Loading Indicator checkbox-->
        <div class="col-sm-4 m-b-16 wdt-toggle-loading-indicator-block">
            <h4 class="c-title-color m-b-4">
                <?php _e('Loading Indicator', 'wpdatatables'); ?>
                <i class="wpdt-icon-info-circle-thin" data-toggle="tooltip" data-placement="right"
                   title="<?php _e('Enable this to turn the Loading Indicator functionality on for this table.', 'wpdatatables'); ?>"></i>
            </h4>
            <div class="toggle-switch" data-ts-color="blue">
                <input id="wdt-toggle-loading-indicator" type="checkbox" hidden="hidden">
                <label for="wdt-toggle-loading-indicator"
                       class="ts-label"><?php _e('Enable loading indicator functionality', 'wpdatatables'); ?></label>              
            </div>
        </div>
        <!-- /Loading Indicator checkbox -->
    </div>
    <!-- /.row -->

</div>
<!-- /Loading Indicator settings -->
