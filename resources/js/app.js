import 'tinymce/tinymce';
import 'tinymce/skins/ui/oxide/skin.min.css';
import 'tinymce/skins/content/default/content.min.css';
import 'tinymce/skins/content/default/content.css';
import 'tinymce/icons/default/icons';
import 'tinymce/themes/silver/theme';
import 'tinymce/models/dom/model';
import 'tinymce/plugins/image';
import 'tinymce/plugins/code';
import 'tinymce/plugins/link';
import 'tinymce/plugins/lists';
import 'tinymce/plugins/media';

window.addEventListener('DOMContentLoaded', () => {
  tinymce.init({
    selector: '#textarea',
    plugins: 'code image link lists media',
    toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | code',
    license_key: 'gpl', // using the GPL version
    
    // Image upload configuration
    images_upload_credentials: true,
    // Custom upload handler with CSRF token
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
              }).catch(error => {
                console.error('Error:', error);
              });
            }
          }
        }
      });
      
    },
    content_style: `
      img { display: block; margin: 0 auto; max-width: 100%; height: auto; }
      body { line-height: 1.6; font-family: poppins; }
    `,
    // add '/' at start of url 
    document_base_url: '/',
    relative_urls: false,
    remove_script_host: false,
    forced_root_block: 'p',
    skin: false,
    content_css: false,

  });
});
