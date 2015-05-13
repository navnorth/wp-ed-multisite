jQuery(document).ready(function() {
    jQuery('.delete-organization').click(function(event) {
        if (confirm("You are about to permamently delete the selected items.\n'Cancel' to stop, 'Ok' to delete.") == false)
            event.preventDefault()
    })
})