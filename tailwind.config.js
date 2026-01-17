/** @type {import('tailwindcss').Config} */
export default {

  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./node_modules/flowbite/**/*.js",
    
  ],
  theme: {
    extend: {
      colors: {
         brand: '#1d4ed8',       
        'brand-soft': '#93c5fd',
      }
    },
  },
  plugins: [
    require('@tailwindcss/typography'),
  ],
}

