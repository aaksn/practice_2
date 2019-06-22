
$(document).ready(
    function() {
        $('#actions').hide();
    });

function sendFiles(files) {
    console.log('Send');
    let maxFileSize = 5242880;
    let Data = new FormData();
    $(files).each(function(index, file) {
        if (file.size <= maxFileSize) {
            Data.append('files', file);
        };
    });
    
    $.post('/up', {                
        data: Data
    }).done(function(response) {
        alert (response);
    }).fail(function() {
        
    });
    /*
    $.ajax({
        url: 'up',
        type: dropZone.attr('method'),
        data: Data,
        contentType: false,
        processData: false,
        success: function(data) {
            alert ('Файлы были успешно загружены!');
        }
    });*/
}
/*
$('#form').submit(function(e){
    e.preventDefault();
    console.log('Sub2');
    let files = this.files;
    sendFiles(files);
});

document.getElementById("file-upload").onchange = function() {
    console.log('Sub1');
    let maxFileSize = 5242880;
    let Data = new FormData();
    let files = $('#form').files;
    $(files).each(function(index, file) {
        if (file.size <= maxFileSize) {
            Data.append('files[]', file, filename);
        };
    });
    
    $.post('/up', {                
        data: Data 
    }).done(function(response) {
        alert (response);
    }).fail(function() {
        console.log('Unable to send')
    });
    //sendFiles(files);
    //document.getElementById("form").submit();
};*/
document.getElementById("file-upload").onchange = function() {
    document.getElementById("form").submit();
};

function deletefile(source) {            
    $.post('/delete', {                
        id: source
    }).done(function(response) {
        $(response).detach()
    }).fail(function() {
        
    });
}

function showtable() {
    $('#actions').show();    
	$('#tablehelp').empty();
	$('#tableviewer').empty();
	$('#tablehelp').text('Подгружаем таблицу...');
	location.href = '#htable';            
    $.get('/showtable', {
        id: $("input[name='fileselector']:checked").attr("id")
    }).done(function(response) {
    	$('#tablehelp').empty();
        $('#tableviewer').html(response)
    }).fail(function() {
        $('#tablehelp').text('Unable to show')
    });            
}
