/** @type {import('tailwindcss').Config} */
export default {
    content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",
    ],
    theme: {
      extend: {
        animation: {
            'spin-cubic': 'spin-cubic 2s cubic-bezier(0.5, 0, 0.5, 1) infinite',
            'scale-fade': 'scale-fade 2s ease-in-out infinite',
          },
        zIndex: {
            '9999': '9999',
          },
      },
    },
    plugins: [],
  }
