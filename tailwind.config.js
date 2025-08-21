import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
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
                    DEFAULT: '#fcd61b', // Jaune principal GTS
                    dark: '#e6c200',     // Jaune foncé
                    light: '#fde047',    // Jaune clair
                },
                secondary: {
                    DEFAULT: '#1e40af',  // Bleu secondaire
                    dark: '#1e3a8a',     // Bleu foncé
                    light: '#3b82f6',    // Bleu clair
                },
                accent: {
                    DEFAULT: '#059669',  // Vert
                    dark: '#047857',     // Vert foncé
                    light: '#10b981',    // Vert clair
                },
                gts: {
                    primary: '#fcd61b',
                    'primary-dark': '#e6c200',
                    'primary-light': '#fde047',
                    secondary: '#1e40af',
                    'secondary-dark': '#1e3a8a',
                    'secondary-light': '#3b82f6',
                    accent: '#059669',
                    'accent-dark': '#047857',
                    'accent-light': '#10b981',
                },
                dark: '#1B1B18',
            },
        },
    },

    plugins: [forms, typography],
};
