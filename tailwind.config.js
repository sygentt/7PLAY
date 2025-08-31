/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
  ],
  
  darkMode: 'class',

  theme: {
    extend: {
      fontFamily: {
        sans: ['Poppins', 'sans-serif'],
      },
      colors: {
        'cinema': {
          50: '#eff6ff',
          100: '#dbeafe',
          200: '#bfdbfe',
          300: '#93c5fd',
          400: '#60a5fa',
          500: '#3b82f6',
          600: '#2563eb',
          700: '#1d4ed8',
          800: '#1e40af',
          900: '#1e3a8a',
          950: '#172554',
        },
        'gold': {
          50: '#fefce8',
          100: '#fef9c3',
          200: '#fef08a',
          300: '#fde047',
          400: '#facc15',
          500: '#eab308',
          600: '#ca8a04',
          700: '#a16207',
          800: '#854d0e',
          900: '#713f12',
          950: '#422006',
        }
      },
      backgroundImage: {
        'cinema-gradient-light': 'linear-gradient(135deg, #ffffff 0%, #dbeafe 50%, #bfdbfe 100%)',
        'cinema-gradient-dark': 'linear-gradient(135deg, #000000 0%, #1e3a8a 50%, #1d4ed8 100%)',
        'card-gradient-light': 'linear-gradient(135deg, #ffffff 0%, #f8fafc 100%)',
        'card-gradient-dark': 'linear-gradient(135deg, #1f2937 0%, #111827 100%)',
        'button-gradient': 'linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%)',
        'button-gradient-hover': 'linear-gradient(135deg, #2563eb 0%, #1e40af 100%)',
      },
      animation: {
        'fade-in': 'fadeIn 0.5s ease-in-out',
        'slide-up': 'slideUp 0.6s ease-out',
        'pulse-slow': 'pulse 3s ease-in-out infinite',
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        slideUp: {
          '0%': { transform: 'translateY(20px)', opacity: '0' },
          '100%': { transform: 'translateY(0)', opacity: '1' },
        }
      }
    },
  },

  plugins: [
    require('@tailwindcss/forms'),
  ],
};