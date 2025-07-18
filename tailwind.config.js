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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    DEFAULT: '#1e9c5a', // Màu xanh lá chính
                    50: '#E6F7EE', // Rất nhạt
                    100: '#C8EBD8', // Nhạt hơn
                    200: '#A9DFC2', // Nhạt
                    300: '#8AD3AC', // Nhạt vừa
                    400: '#6BC696', // Trung bình nhạt
                    500: '#4CBA80', // Trung bình
                    600: '#1E9C5A', // Màu chính (DEFAULT)
                    700: '#1A804B', // Đậm vừa
                    800: '#16643C', // Đậm
                    900: '#12482D', // Rất đậm
                },
            },
        },
    },

    plugins: [forms],
};
