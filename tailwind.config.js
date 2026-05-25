/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './**/*.php',
    './views/**/*.php',
    './app/**/*.php',
    './assets/js/**/*.js',
  ],
  theme: {
    container: {
      center: true,
      padding: { DEFAULT: '1.25rem', sm: '1.5rem', lg: '2rem', xl: '2.5rem' },
      screens: { '2xl': '1280px' },
    },
    extend: {
      fontFamily: {
        sans:    ['Geist', 'Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
        display: ['"Geist"', '"Inter Tight"', 'Inter', 'sans-serif'],
        heading: ['"Geist"', '"Inter Tight"', 'Inter', 'sans-serif'],
        serif:   ['"Instrument Serif"', '"Times New Roman"', 'serif'],
        mono:    ['"Geist Mono"', '"JetBrains Mono"', 'ui-monospace', 'monospace'],
      },
      letterSpacing: {
        'tightest':  '-0.045em',
        'tighter':   '-0.030em',
        'displayer': '-0.055em',
      },
      colors: {
        /* ── LIGHT THEME — semantic names ── */

        // "Void" is now the page background (warm off-white)
        void: {
          DEFAULT: '#FBFBFA',
          50:  '#FFFFFF',
          100: '#FAFAF9',
          200: '#F5F5F4',
          300: '#E7E5E4',
          400: '#A8A29E',
          500: '#78716C',
        },
        // "Chalk" is now the primary text (near-black) — flipped for light theme
        chalk: {
          DEFAULT: '#09090B',
          dim:     'rgba(15, 15, 20, 0.72)',
          muted:   'rgba(15, 15, 20, 0.55)',
          quiet:   'rgba(15, 15, 20, 0.40)',
        },
        // Indigo — primary brand accent
        indigo: {
          50:  '#EEF2FF',
          100: '#E0E7FF',
          200: '#C7D2FE',
          300: '#A5B4FC',
          400: '#818CF8',
          500: '#6366F1',
          600: '#4F46E5',
          700: '#4338CA',
          800: '#3730A3',
          900: '#312E81',
          glow: 'rgba(99, 102, 241, 0.18)',
        },
        // Cyan accent
        cyan: {
          400: '#22D3EE',
          500: '#06B6D4',
          600: '#0891B2',
          700: '#0E7490',
          glow: 'rgba(6, 182, 212, 0.18)',
        },
        // Violet accent
        violet: {
          400: '#A78BFA',
          500: '#7C3AED',
          600: '#6D28D9',
          glow: 'rgba(124, 58, 237, 0.18)',
        },
        // Aliases (kept for back-compat with services pages, etc.)
        ink:      { DEFAULT: '#09090B', 50: '#FAFAF9', 100: '#F5F5F4', 200: '#E7E5E4', 300: '#D6D3D1', 400: '#A8A29E', 500: '#78716C' },
        cream:    { DEFAULT: '#FBFBFA', 50: '#FFFFFF', 100: '#FAFAF9', 200: '#F5F5F4', 300: '#E7E5E4', dim: 'rgba(15,15,20,0.55)' },
        ember:    { 50: '#EEF2FF', 100: '#E0E7FF', 200: '#C7D2FE', 300: '#A5B4FC', 400: '#818CF8', 500: '#6366F1', 600: '#4F46E5', 700: '#4338CA' },
        primary:  { DEFAULT: '#4F46E5', hover: '#4338CA', light: '#6366F1', dark: '#3730A3' },
        secondary:{ DEFAULT: '#06B6D4', hover: '#0891B2' },
        accent:   { DEFAULT: '#7C3AED' },
        dark:     { DEFAULT: '#09090B', lighter: '#18181B', card: '#FFFFFF', border: 'rgba(15,15,20,0.12)' },
      },
      boxShadow: {
        'soft-sm':   '0 1px 2px rgba(15, 23, 42, 0.04), 0 1px 1px rgba(15, 23, 42, 0.03)',
        'soft-md':   '0 4px 6px -1px rgba(15, 23, 42, 0.05), 0 2px 4px -2px rgba(15, 23, 42, 0.04)',
        'soft-lg':   '0 10px 15px -3px rgba(15, 23, 42, 0.06), 0 4px 6px -4px rgba(15, 23, 42, 0.05)',
        'soft-xl':   '0 20px 25px -5px rgba(15, 23, 42, 0.08), 0 8px 10px -6px rgba(15, 23, 42, 0.05)',
        'soft-2xl':  '0 25px 50px -12px rgba(15, 23, 42, 0.18)',
        'glow-indigo': '0 0 0 1px rgba(99,102,241,0.12), 0 8px 24px -8px rgba(99,102,241,0.30)',
      },
      animation: {
        'fade-in':         'fadeIn 0.6s ease-out forwards',
        'fade-in-up':      'fadeInUp 0.6s ease-out forwards',
        'pulse-slow':      'pulse 4s cubic-bezier(0.4,0,0.6,1) infinite',
        'marquee':         'marquee 60s linear infinite',
        'marquee-rev':     'marquee-rev 60s linear infinite',
        'ticker':          'ticker 35s linear infinite',
        'shimmer':         'shimmer 3s linear infinite',
      },
      keyframes: {
        fadeIn:   { '0%': { opacity: 0 }, '100%': { opacity: 1 } },
        fadeInUp: { '0%': { opacity: 0, transform: 'translateY(20px)' }, '100%': { opacity: 1, transform: 'translateY(0)' } },
        marquee:     { '0%': { transform: 'translateX(0)' }, '100%': { transform: 'translateX(-50%)' } },
        'marquee-rev': { '0%': { transform: 'translateX(-50%)' }, '100%': { transform: 'translateX(0)' } },
        ticker:   { '0%': { transform: 'translateX(0)' }, '100%': { transform: 'translateX(-50%)' } },
        shimmer:  { '0%': { backgroundPosition: '-200% 0' }, '100%': { backgroundPosition: '200% 0' } },
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
  ],
};
