var selectedFiles = [];
var selectedFileNames = [];
var batch = false;

$(document).ready(function() {
    if ($('#datafilestable').length) {
        $('#datafilestable').DataTable(
            {
                'columnDefs': [{
                    'targets': [0],
                    'orderable': false
                }]
            }
    );
    }

    if ($('#taskstable').length) {
        $('#taskstable').DataTable();
    }

    let eventSource = new EventSource(baseurl + "ServiceApi/PollTasks");

    eventSource.onmessage = function(event) {
        id = event.lastEventId; // Task ID
        var edata = JSON.parse(event.data);
        var progress = edata.progress;
        var status = edata.status;
        var idString = id.toString(); // Task ID
        var fileId = edata.data_file_id;
        var isBatch = edata.batch;
        if (progress > -1) {
            if($('#progress-' + idString).length){

                $('#progress-' + idString).parent().find('span').hide();

                $('#batchProcessAllBtn').prop('disabled', true);

                $('#actionBtns-' + idString).children().hide();

                if ($('#check-' + fileId).prop('checked'))
                {
                    $('#check-' + fileId).click();
                }

                $('#check-' + fileId).prop('disabled', true);

                if (isBatch){
                    $('.batch-select').prop('disabled', true);
                    $('.actionBtns').hide();
                }

                if($('#progress-' + idString).html() == '')
                {
                    $('#progress-' + idString).html("<div class='progress'><div class='progress-bar' role='progressbar' id='progressbar-" + idString + "' style='width: 0%;' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100'>0%</div></div><p id='statusmessage-" + idString + "' style='font-size: 10px'></p>");
                }
                $('#progressbar-' + idString).text(progress.toString() + '%');
                $('#progressbar-' + idString).css( 'width', progress.toString() + '%' );
                $('#statusmessage-' + idString).html(status);
            }
            else{
                $('#status-' + fileId).html('');
                $('#status-' + fileId).append("<div id='progress-" + idString.toString() + "'></div>");
            }
        }
        else{
            $('.batch-select').prop('disabled', false);

            $('.actionBtns').show();
        }

        if(progress == 100 && status.toLowerCase() == 'finished')
        {
            $('#progressbar-' + id.toString()).addClass('bg-success');
            $('#actionBtns-' + fileId).children().show();
            $('#check-' + fileId).prop('disabled', false);
            countUploadedAndIportedFiles();
        }
    };

    eventSource.onerror = function(err) {
    };

    countUploadedAndIportedFiles();

});

function countUploadedAndIportedFiles(){

    var csrfTokenObj = getCSRFToken('keyvaluepair');
    var formData = {'sourceId': $('#sourceId').val()};
    var csrfTokenName = Object.keys(csrfTokenObj)[0];
    formData[csrfTokenName] = csrfTokenObj[csrfTokenName];

    $.ajax({
        type: 'POST',
        url: baseurl + 'AjaxApi/CountUploadedAndImportedFiles',
        data: formData,
        dataType: 'json',
        beforeSend: function (jqXHR, settings) {
            $('#uploadedImportedSpinner').show();
        },
        success: function (response) {
            if(response.status == 0){
                $('#uploadedImportedCount').html(response.count);
                $('#batchProcessAllBtn').prop('disabled', response.count == 0);
            }
            else{
                $('#uploadedImportedCount').html('?');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $('#uploadedImportedCount').html('?');
        },
        complete: function (jqXHR, settings) {
            $('#uploadedImportedSpinner').hide();
        }
    });
}

$('#name').on('change',function(){
    var fullFileName = $(this).val();
    var fileName = fullFileName.split('\\')[fullFileName.split('\\').length - 1];
    $(this).next('.custom-file-label').html(fileName);

    var selectedFileSize = $('#name')[0].files[0].size;
    var maxUploadFileSize = $('#maxUploadSize').data('bytevalue');
    $('#selectedFileSize').html((selectedFileSize/1048576).toFixed(2)+ ' MB');

    if (selectedFileSize > maxUploadFileSize){
        $('#uploadWarningText').html('Selected file size is larger than the maximum allowed file size for upload. Upload cannot proceed. Please contact the server administrator to increase the upload size or select another file.');
        $('#uploadWarningAlert').show();
        $('#uploadBtn').prop('disabled', 'disabled');
    }
    else
    {
        $('#uploadWarningAlert').hide();
        $('#uploadBtn').prop('disabled', false);
    }
});

$('#taskModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var modal = $(this);

    if (button.is('button'))
    {
        batch = true;

        var fileNames = '';
        // possibly multiple files
        if (selectedFileNames.length > 0) {
            for (i = 0; i < selectedFileNames.length; i++) {
                fileNames += "<span class='badge badge-light'>" + selectedFileNames[i] + "</span>";
            }
        }
        else{
            fileNames = 'All uploaded/imported files.';
        }
        modal.find('#fileName').html(fileNames);

    }
    else if (button.is('a'))
    {
        // single file
        batch = false;
        var fileId = button.data('fileid');
        var fileName = button.data('filename');
        modal.find('#fileId').val(fileId);
        modal.find('#fileName').html("<span class='badge badge-light'>" + fileName + "</span>");
    }

});

$('#taskModal').on('hide.bs.modal', function (event) {
    var modal = $(this);
    modal.find('#fileId').val('-1');
    modal.find('#fileName').text('');
    modal.find('#pipeline').val(-1);
    modal.find('#pipeline').removeClass('is-invalid');
    modal.find('#statusMessage').html('');
    modal.find('#statusMessage').attr('class', '');
    batch = false;
});

$('#processBtn').on('click',function(event) {
    event.preventDefault();
    var fileId = $('#fileId').val();
    var fileIds = selectedFiles.join(',');
    var pipelineId = $('#pipeline').val();
    var sourceId = $('#sourceId').val();

    if (pipelineId == "-1"){
        $('#pipeline').addClass('is-invalid');
        return;
    }
    else{
        $('#pipeline').removeClass('is-invalid');
    }

    var endpoint = batch ? 'AjaxApi/ProcessFiles' : 'AjaxApi/ProcessFile';

    var csrfTokenObj = getCSRFToken('keyvaluepair');
    var formData = {'fileId': fileId, 'fileIds': fileIds, 'pipelineId': pipelineId, 'sourceId': sourceId};
    var csrfTokenName = Object.keys(csrfTokenObj)[0];
    formData[csrfTokenName] = csrfTokenObj[csrfTokenName];

    $.ajax({
        type: 'POST',
        url: baseurl + endpoint,
        data: formData,
        dataType: 'json',
        beforeSend:  function (jqXHR, settings) {
            enterLoading();
        },
        success: function(response)  {

            switch (response.status){
                case 0:
                    $('#statusMessage').addClass('text-success');
                    $('#statusMessage').html(response.message);

                    if (!batch)
                    {
                        var taskId = response.task_id;
                        $('#status-' + fileId).html('');
                        $('#status-' + fileId).append("<div id='progress-" + taskId.toString() + "'></div>");

                        //hide action div
                        $('#actionBtns-' + fileId).hide();
                        //disable checkbox
                        $('#check-' + fileId).prop('disabled', true);
                    }
                    else
                    {
                        $('.actionBtns').hide();
                        $('.batch-select:checked').click();
                        $('.batch-select').prop('disabled', true);
                    }

                    $('#batchProcessAllBtn').prop('disabled', true);
                    break;
                case 1:
                    $('#statusMessage').addClass('text-danger');
                    $('#statusMessage').html('There was an error while processing the request: <br> Error Message: ' + response.message);
                    break;
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $('#statusMessage').addClass('text-danger');
            $('#statusMessage').html('There was an error while processing the request: <br> Error Code: ' + jqXHR.status + '<br> Error Message: ' + errorThrown);

        },
        complete: function (jqXHR, settings) {
            exitLoading();

            // Close modal
            $('#taskModal').modal('hide');
        }
    });
});

$('#check-master').on('click', function (event) {
    if($(event.currentTarget).prop('checked'))
    {
        $('.batch-select:checked').click();
    }
    else
    {
        $('.batch-select:not(:checked)').click();
    }
    $('.batch-select').click();
});

$('.batch-select').on('click',function(event){
    if ($(event.currentTarget).prop('checked'))
    {
        selectedFiles.push($(event.currentTarget).val());
        selectedFileNames.push($(event.currentTarget).data('filename'));
    }
    else
    {
        selectedFiles.splice(
            selectedFiles.indexOf(
                $(event.currentTarget).val()
            ), 1
        );

        selectedFileNames.splice(
            selectedFileNames.indexOf(
                $(event.currentTarget).data('filename')
            ), 1
        );
    }
    $('.file-counter').html(selectedFiles.length);

    $('.batch-btn').prop('disabled', selectedFiles.length == 0);
});

function enterLoading() {
    $('#statusMessage').html('');
    $('#statusMessage').attr('class', '');
    $('#spinner').show();
    $('#processBtn').prop('disabled', true);
    $('#cancelBtn').prop('disabled', true);
}

function exitLoading() {
    $('#spinner').hide();
    $('#processBtn').prop('disabled', false);
    $('#cancelBtn').prop('disabled', false);
}


$("#importFiles").submit(function(event) {
    event.preventDefault();
});

function lookupDir(event) {
    var lookup_dir = $('#path').val();

    var csrfTokenObj = getCSRFToken('keyvaluepair');
    var formData = {'lookup_dir': $('#path').val()};
    var csrfTokenName = Object.keys(csrfTokenObj)[0];
    formData[csrfTokenName] = csrfTokenObj[csrfTokenName];


    if (lookup_dir == null || lookup_dir == '') {
        $('#path').addClass('is-invalid');
        return;
    }
    else{
        $('#path').removeClass('is-invalid');
    }

    $.ajax({
        type: 'POST',
        url: baseurl+'AjaxApi/LookupDirectory',
        data: formData,
        dataType: "json",
        beforeSend: function (jqXHR, settings) {
            showLoader();
            clearError();
            disableLookup();
            disableImport();
        },
        success: function(response)  {
            count = JSON.parse(response);
            if (count == 0){
                $('#lookupCount').text('No file was found.');
            }
            else if (count == 1){
                $('#lookupCount').text(count + ' file was found.');
            }
            else{
                $('#lookupCount').text(count + ' files were found.');
            }
            count > 0 ? enableImport() : disableImport();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            disableImport();
            showError(textStatus, errorThrown);
        },
        complete: function (jqXHR, settings) {
            hideLoader();
            enableLookup();
        }
    });
}

function importDir() {
    var source_id = $('#source_id').val();

    var csrfTokenObj = getCSRFToken('keyvaluepair');
    var formData = {'lookup_dir': $('#path').val(), 'source_id': source_id};
    var csrfTokenName = Object.keys(csrfTokenObj)[0];
    formData[csrfTokenName] = csrfTokenObj[csrfTokenName];

    $.ajax({
        type: 'POST',
        url: baseurl+'AjaxApi/ImportFromDirectory',
        data: formData,
        dataType: "json",
        beforeSend:  function (jqXHR, settings) {
            showLoader();
            clearError();
            disableLookup();
            disableImport();
        },
        success: function(response)  {
            if (response.saved_count == 0){
                textStatus = 'No file imported.';
            }
            else if(response.saved_count == 1){
                textStatus = response.saved_count + ' file was imported successfully.';
                $("#importFiles").trigger('reset');
                disableImport();
            }
            else{
                textStatus = response.saved_count + ' file(s) were imported successfully.';
                $("#importFiles").trigger('reset');
                disableImport();
            }

            if (response.unsaved_count == 1) {
                textStatus += response.unsaved_count + ' file failed to get imported.';
            }
            else if (response.unsaved_count > 1) {
                textStatus += response.unsaved_count + ' files failed to get imported.';
            }

            $('#lookupCount').text(textStatus);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            showError(textStatus, errorThrown);
        },
        complete: function (jqXHR, settings){
            hideLoader();
            enableLookup();
        }
    });
}

function showLoader() {
    $('#spinner').show();
}

function hideLoader() {
    $('#spinner').hide();
}

function showLookupBtn() {
    $('#lookupBtn').show();
}

function hideLookupBtn() {
    $('#lookupBtn').hide();
}

function showImportBtn() {
    $('#importBtn').show();
}

function hideImportBtn() {
    $('#importBtn').hide();
}

function disableImport() {
    $('#importBtn').prop('disabled', true);
}

function enableImport() {
    $('#importBtn').prop('disabled', false);
}

function showError(textStatus, errorThrown) {
    $('#lookupCount').text(textStatus + ': ' + errorThrown);
    $('#lookupCount').addClass('text-danger');
}

function clearError() {
    $('#lookupCount').text('');
    $('#lookupCount').removeClass('text-danger');
}

function disableLookup() {
    $('#path').prop('disabled', true);
    $('#lookupBtn').prop('disabled', true);
}

function enableLookup() {
    $('#path').prop('disabled', false);
    $('#lookupBtn').prop('disabled', false);
}

function getCSRFToken(format = 'string'){
    csrf_token = $('input[type=hidden]').val();
    csrf_token_name = $('input[type=hidden]').prop('name');

    switch (format) {
        case "string":
            return csrf_token_name + '=' + csrf_token;
        case "keyvaluepair":
            var csrfObj = {};
            csrfObj[csrf_token_name] = csrf_token;
            return csrfObj;
    }
}
