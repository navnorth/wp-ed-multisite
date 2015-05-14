<div class="wrap">
    <h2 id="new-organization"> Add New Organization</h2>
    <?php
        if($success): ?>
        <div id="message" class="updated notice notice-success is-dismissible below-h2"><p>Organization created. <a href="admin.php?page=get-organizations">View organizations</a></div>
    <?php
        endif; ?>
    <form method="post" id="new-organization" action="admin.php?page=get-organizations&action=new-organization">
        <?php wp_nonce_field("gat-new-organization", "gat-new-organization-nonce"); ?>
        <table class="form-table">
            <tbody>
                <tr class="form-field <?php if($create === FALSE AND $organization->FIPST == NULL) echo "form-invalid "; ?>form-required">
                    <th scope="row">
                        <label for="FIPST"><?php echo __("State", PLUGIN_DOMAIN); ?> <span class="description">(required)</span></label>
                    </th>
                    <td>
                        <input name="FIPST" type="text" id="FIPST" value="<?php echo $organization->FIPST; ?>" aria-required="true">
                        <p class="description">ANSI1 State Code</p>
                    </td>
                </tr>
                <tr class="form-field <?php if($create === FALSE AND $organization->LEAID == NULL) echo "form-invalid "; ?>form-required">
                    <th scope="row">
                        <label for="LEAID"><?php echo __("LEAID", PLUGIN_DOMAIN); ?> <span class="description">(required)</span></label>
                    </th>
                    <td>
                        <input name="LEAID" type="text" id="LEAID" value="<?php echo $organization->LEAID; ?>" aria-required="true">
                        <p class="description">NCES Local Education Agency ID</p>
                    </td>
                </tr>
                <tr class="form-field <?php if($create === FALSE AND $organization->LEANM == NULL) echo "form-invalid "; ?>form-required">
                    <th scope="row">
                        <label for="LEANM"><?php echo __("LEANM", PLUGIN_DOMAIN); ?> <span class="description">(required)</span></label>
                    </th>
                    <td>
                        <input name="LEANM" type="text" id="LEANM" value="<?php echo $organization->LEANM; ?>" aria-required="true">
                        <p class="description">Name of Education Agency</p>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <p class="submit"><?php submit_button(__("Add New Organization", PLUGIN_DOMAIN), "primary", "submit"); ?></p></p>
    </form>
</div>