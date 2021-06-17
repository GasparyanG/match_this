function match() {
    let fd = new FormData();
    let files = $('#file')[0].files;

    // Check file selected or not
    if(files.length > 0 ) {
        fd.append('file', files[0]);

        $.ajax({
            url: '/match',
            type: 'POST',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response) {
                if(response != 0) {
                    console.log(response)
                } else{
                    alert('file not uploaded');
                }
            },
        });
    } else {
        alert("Please select a file.");
    }
}