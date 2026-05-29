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
                sans: ['Outfit', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                teal: {
                    50: '#f0f9f9',
                    100: '#d9f2f2',
                    200: '#b8e3e4',
                    300: '#89ccce',
                    400: '#53adb1',
                    500: '#3a9196',
                    600: '#2d767b',
                    700: '#285f64',
                    800: '#244e53',
                    900: '#224246',
                },
                'brand': {
                    'dark': '#0f172a',
                    'teal': '#0d9488',
                    'accent': '#2dd4bf',
                }
            },
            boxShadow: {
                'premium': '0 20px 50px -12px rgba(0, 0, 0, 0.05)',
                'glass': '0 8px 32px 0 rgba(15, 23, 42, 0.08)',
            },
            borderRadius: {
                '4xl': '2rem',
                '5xl': '3rem',
            }
        },
    },

    plugins: [forms],
};
