$(document).ready(function() {
    // If the table exists, populate DataTable and make it stylish.
    if ($('#sourcestable').length) {
        $('#sourcestable').DataTable();
    }
    $('#ImportRecordsBtn').tooltip(); //Tooltip for import records added as the data-toggle attribute is used to trigger the modal
} );

// Select groups on submission of form
function select_groups() {
    $(".groupsSelected").find('option').each(function () {
        $(this).attr('selected', 'selected');
    });
}

// Set proper hyperlinks to uploaders in the modal
$('#addVariantsModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); 
    var sourceId = button.data('id'); 
    var sourceDesc = button.data('description'); 
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this);
    modal.find('.modal-title').text('Add Records To ' + sourceDesc);
    modal.find('#bulkImport').attr('href', baseurl + "Upload/Bulk/" + sourceId);
    modal.find('#phenoPacketsImport').attr('href', baseurl + "Upload/Json/" + sourceId);
    modal.find('#VCFImport').attr('href', baseurl + "Upload/VCF/" + sourceId);
  })

