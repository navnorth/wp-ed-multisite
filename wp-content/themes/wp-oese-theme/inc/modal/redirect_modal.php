<div id="redirectModal" class="oese-modal modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $modal_header; ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <?php echo $modal_content; ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function($){
        $("#redirectModal").modal('show');
    });
</script>
<style type="text/css">
    .oese-modal .modal-header{
        background-image: url("<?php echo get_template_directory_uri(); ?>/images/overlay-diamonds.png");
    }
</style>