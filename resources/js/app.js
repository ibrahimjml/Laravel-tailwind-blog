import 'tinymce/tinymce';
import 'tinymce/skins/ui/oxide/skin.min.css';
import 'tinymce/skins/content/default/content.min.css';
import 'tinymce/skins/content/default/content.css';
import 'tinymce/icons/default/icons';
import 'tinymce/themes/silver/theme';
import 'tinymce/models/dom/model';
import 'tinymce/plugins/image';
import 'tinymce/plugins/code';
import 'tinymce/plugins/codesample';
import 'tinymce/plugins/link';
import 'tinymce/plugins/lists';
import 'tinymce/plugins/media';
import mediumZoom from 'medium-zoom';
import Prism from 'prismjs';
import 'prismjs/plugins/toolbar/prism-toolbar';
import 'prismjs/plugins/toolbar/prism-toolbar.css';
import 'prismjs/plugins/copy-to-clipboard/prism-copy-to-clipboard';




window.addEventListener('DOMContentLoaded', () => {
  tinymce.init({
    selector: '#textarea',
    plugins: 'code codesample image link lists media',
    codesample_global_prismjs: true,
    codesample_dialog_width: 600,
    codesample_dialog_height: 425,
    toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | code codesample ',
    license_key: 'gpl', // using the GPL version
    
    // Image upload configuration
    images_upload_credentials: true,

    images_upload_handler: async function (blobInfo) {
      const formData = new FormData();
      formData.append('tiny-image', blobInfo.blob(), blobInfo.filename());
    
      const response = await fetch('/upload-image', {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: formData
      });
    
      let result;
    
      try {
        result = await response.json();
      } catch (e) {
        throw new Error('Upload failed: invalid JSON response');
        
      }
    
      if (!response.ok) {
        throw new Error(result?.error || `Upload failed with status ${response.status}`);
      }
    
      if (!result || typeof result.location !== 'string') {
        throw new Error('Invalid response format from server');
      }
    
      return result.location; 
    },
    

    
    
    setup(editor) {
      // on back | delete button remove images and delete them 
      editor.on("keydown", function(e) {
        if ((e.keyCode === 8 || e.keyCode === 46) && tinymce.activeEditor.selection) {
          const selectedNode = tinymce.activeEditor.selection.getNode();
          if (selectedNode && selectedNode.nodeName === 'IMG') {
            const imageSrc = selectedNode.getAttribute('src');
  
            if (imageSrc) {
              // Send delete request to Laravel route
              fetch('/image-delete', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ image: imageSrc })
              }).then(response => {
                if (!response.ok) {
                  console.error('Failed to delete image');
                }
                toastr.options = {
                  "closeButton": true,
                  "progressBar": true,
                  "positionClass": "toast-top-right",
                  "timeOut": 1000
                };
                toastr.success(`selected ${imageSrc} deleted `);
              }).catch(error => {
                console.error('Error:', error);
              });
            }
          }
        }
      });
      
    },
    content_css: '/tinymce.css',
    // add '/' at start of url 
    document_base_url: '/',
    relative_urls: false,
    remove_script_host: false,
    forced_root_block: false,
    skin: false,
  

  });
});

// apply zoom effect on images inside $post->description
document.addEventListener("DOMContentLoaded", () => {

  mediumZoom('.published-content img', {
    margin: 50, 
    background: '#000', 
  }).on('opened', () => {
    document.querySelector('.medium-zoom-overlay').style.zIndex = '50';
    document.querySelector('.medium-zoom-overlay').style.background = 'rgba(0,0,0,0.9)';
    document.querySelector('.medium-zoom-image--opened').style.zIndex = '50';
  });

  Prism.highlightAllUnder(document.querySelector('.published-content'));
});


