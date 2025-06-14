import './bootstrap';
import 'flowbite';
import { initTinyMCE } from './tinymce';
import mediumZoom from 'medium-zoom';
import Prism from 'prismjs';
import 'prismjs/plugins/toolbar/prism-toolbar';
import 'prismjs/plugins/toolbar/prism-toolbar.css';
import 'prismjs/plugins/copy-to-clipboard/prism-copy-to-clipboard';

window.addEventListener('DOMContentLoaded', () => {
  initTinyMCE();

  mediumZoom('.published-content img', {
    margin: 50,
    background: '#000',
  }).on('opened', () => {
    document.querySelector('.medium-zoom-overlay').style.zIndex = '50';
    document.querySelector('.medium-zoom-overlay').style.background = 'rgba(0,0,0,0.9)';
    document.querySelector('.medium-zoom-image--opened').style.zIndex = '50';
  });

  const posts = document.querySelectorAll('.published-content');
  posts.forEach(post => Prism.highlightAllUnder(post));
});
