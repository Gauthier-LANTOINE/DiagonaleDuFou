$(document).ready(function() {
        $('.summernote').summernote({
            height: 300,                
            minHeight: null,            
            maxHeight: null,             
            focus: false,
            lang: 'fr-FR',
            disableDragAndDrop: true,
            toolbar: [

            ['style', ['style']],
            ['style', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video', 'hr']],
            ['view', ['fullscreen']],
            ['help', ['help']]
          ]
          });
    });