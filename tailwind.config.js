import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                display: ['"Teko"', '"Bebas Neue"', ...defaultTheme.fontFamily.sans],
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                atlas: {
                    DEFAULT: '#0a1f14',
                    50: '#e6f5ed',
                    100: '#b3e0c8',
                    200: '#80cba3',
                    300: '#4db67e',
                    400: '#26a863',
                    500: '#10b981',
                    600: '#0e9a6c',
                    700: '#0b7a54',
                    800: '#095a3d',
                    900: '#063a26',
                    950: '#041a11',
                },
                emerald: {
                    DEFAULT: '#10b981',
                    50: '#ecfdf5',
                    100: '#d1fae5',
                    200: '#a7f3d0',
                    300: '#6ee7b7',
                    400: '#34d399',
                    500: '#10b981',
                    600: '#059669',
                    700: '#047857',
                    800: '#065f46',
                    900: '#064e3b',
                },
                lime: {
                    DEFAULT: '#a3e635',
                    accent: '#a3e635',
                },
                surface: {
                    DEFAULT: '#0d2919',
                    light: '#133323',
                    lighter: '#1a4030',
                },
                muted: '#8fa89c',
            },
        },
    },

    plugins: [forms],
};
