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
    images_upload_url: '/upload-image',
    images_upload_credentials: true,
    
    // Custom upload handler with CSRF token
    images_upload_handler: function (blobInfo, progress) {
      return new Promise((resolve, reject) => {
        const formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());
        
        const xhr = new XMLHttpRequest();
        xhr.withCredentials = true;
        xhr.open('POST', '/upload-image');
        
        // Add CSRF token header
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
        
        xhr.upload.onprogress = function (e) {
          progress(e.loaded / e.total * 100);
        };
        
        xhr.onload = function() {
          if (xhr.status < 200 || xhr.status >= 300) {
            reject('HTTP Error: ' + xhr.status);
            return;
          }
          
          const json = JSON.parse(xhr.responseText);
          
          if (!json || typeof json.location != 'string') {
            reject('Invalid JSON: ' + xhr.responseText);
            return;
          }
          
          resolve(json.location);
        };
        
        xhr.onerror = function() {
          reject('Image upload failed due to a XHR Transport error. Status: ' + xhr.status);
        };
        
        xhr.send(formData);
      });
    },
    
    content_style: `
      img { display: block; margin: 0 auto; max-width: 100%; height: auto; }
      body { line-height: 1.6; font-family: sans-serif; }
    `,
    // add '/' at start of url 
    document_base_url: '/',
    relative_urls: false,
    remove_script_host: false,
    
    skin: false,
    content_css: false,

  });
});
