$("#summernote").summernote({
  tabsize: 2,
  height: 500,
  toolbar: [
    ['style', ['style']],
    ['font', ['bold', 'underline', 'clear']],
    ['color', ['color']],
    ['para', ['ul', 'ol', 'paragraph']],
    ['table', ['table']],
    ['insert', [
        'link', 
        // 'picture', 
        'video'
      ]
    ],
    ['view', ['fullscreen', 'codeview', 'help']]
  ]
})