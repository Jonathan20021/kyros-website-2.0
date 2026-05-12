/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './**/*.php',
    './views/**/*.php',
    './app/**/*.php',
    './assets/js/**/*.js',
  ],
  darkMode: 'class',
  theme: {
    container: {
      center: true,
      padding: { DEFAULT: '1.25rem', sm: '1.5rem', lg: '2.5rem', xl: '3rem' },
      screens: { '2xl': '1440px' },
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
        'tighter':   '-0.035em',
        'displayer': '-0.055em',
      },
      colors: {
        // Void: deep pure dark
        void: {
          DEFAULT: '#050508',
          50:  '#0A0A12',
          100: '#0D0D14',
          200: '#12121A',
          300: '#1A1A23',
          400: '#23232E',
          500: '#33333F',
        },
        // Electric Indigo — primary signature
        indigo: {
          50:  '#EFEFFF',
          100: '#DBDBFF',
          200: '#B5B5FF',
          300: '#8E8EFF',
          400: '#6E6EFF',
          500: '#5B5EFF',  // SIGNATURE
          600: '#4B47E6',
          700: '#3D35BF',
          glow: 'rgba(91, 94, 255, 0.5)',
        },
        // Cyan — secondary electric
        cyan: {
          400: '#3DD5FF',
          500: '#22D3EE',
          600: '#0EA5C7',
          glow: 'rgba(34, 211, 238, 0.45)',
        },
        // Violet — accent for special moments
        violet: {
          400: '#C4B5FD',
          500: '#A78BFA',
          glow: 'rgba(167, 139, 250, 0.45)',
        },
        // Pure white text
        chalk: {
          DEFAULT: '#FFFFFF',
          dim: 'rgba(255,255,255,0.65)',
          muted: 'rgba(255,255,255,0.45)',
          quiet: 'rgba(255,255,255,0.30)',
        },
        // Legacy aliases
        ink:      { DEFAULT: '#050508', 50: '#0A0A12', 100: '#0D0D14', 200: '#12121A', 300: '#1A1A23', 400: '#23232E', 500: '#33333F' },
        cream:    { DEFAULT: '#FFFFFF', 50: '#FFFFFF', 100: '#FFFFFF', 200: '#FAFAFC', 300: '#E6E6EC', dim: 'rgba(255,255,255,0.45)' },
        ember:    { 50: '#EFEFFF', 100: '#DBDBFF', 200: '#B5B5FF', 300: '#8E8EFF', 400: '#6E6EFF', 500: '#5B5EFF', 600: '#4B47E6', 700: '#3D35BF', glow: 'rgba(91,94,255,0.5)' },
        primary:  { DEFAULT: '#5B5EFF', hover: '#4B47E6', light: '#8E8EFF', dark: '#3D35BF', glow: 'rgba(91,94,255,0.5)' },
        secondary:{ DEFAULT: '#22D3EE', hover: '#0EA5C7', glow: 'rgba(34,211,238,0.45)' },
        accent:   { DEFAULT: '#A78BFA', glow: 'rgba(167,139,250,0.45)' },
        amber:    { glow: '#22D3EE' },
        sky:      { glow: '#22D3EE' },
        lime:     { glow: '#A78BFA' },
        dark:     { DEFAULT: '#050508', lighter: '#0D0D14', card: '#12121A', border: '#23232E' },
      },
      backgroundImage: {
        'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
        'gradient-conic':  'conic-gradient(from var(--angle, 0deg), var(--tw-gradient-stops))',
      },
      boxShadow: {
        'glow-indigo': '0 0 48px rgba(91,94,255,0.4), 0 0 96px rgba(91,94,255,0.18)',
        'glow-cyan':   '0 0 48px rgba(34,211,238,0.4)',
        'glow-violet': '0 0 48px rgba(167,139,250,0.4)',
        'glow-ember':  '0 0 48px rgba(91,94,255,0.4)',
        'inset-line':  'inset 0 1px 0 rgba(255,255,255,0.06)',
        'depth-card':  '0 30px 60px -20px rgba(0,0,0,0.7), inset 0 1px 0 rgba(255,255,255,0.06)',
      },
      animation: {
        'fade-in':         'fadeIn 0.8s ease-out forwards',
        'fade-in-up':      'fadeInUp 0.8s ease-out forwards',
        'pulse-slow':      'pulse 4s cubic-bezier(0.4,0,0.6,1) infinite',
        'float':           'float 12s ease-in-out infinite',
        'spin-slow':       'spin 24s linear infinite',
        'marquee':         'marquee 60s linear infinite',
        'marquee-rev':     'marquee-rev 60s linear infinite',
        'aurora':          'aurora 22s ease infinite',
        'shimmer':         'shimmer 3s linear infinite',
        'border-spin':     'border-spin 6s linear infinite',
        'ticker':          'ticker 35s linear infinite',
        'gradient-rotate': 'gradient-rotate 8s linear infinite',
        'orbit':           'orbit 30s linear infinite',
        'beam':            'beam 4s ease-in-out infinite',
      },
      keyframes: {
        fadeIn: { '0%': { opacity: 0 }, '100%': { opacity: 1 } },
        fadeInUp: { '0%': { opacity: 0, transform: 'translateY(20px)' }, '100%': { opacity: 1, transform: 'translateY(0)' } },
        float:  { '0%,100%': { transform: 'translateY(0) translateX(0)' }, '50%': { transform: 'translateY(-24px) translateX(12px)' } },
        marquee:    { '0%': { transform: 'translateX(0)' }, '100%': { transform: 'translateX(-50%)' } },
        'marquee-rev': { '0%': { transform: 'translateX(-50%)' }, '100%': { transform: 'translateX(0)' } },
        aurora: { '0%,100%': { backgroundPosition: '0% 50%' }, '50%': { backgroundPosition: '100% 50%' } },
        shimmer: { '0%': { backgroundPosition: '-200% 0' }, '100%': { backgroundPosition: '200% 0' } },
        'border-spin': { '0%': { '--angle': '0deg' }, '100%': { '--angle': '360deg' } },
        'gradient-rotate': { '0%': { '--angle': '0deg' }, '100%': { '--angle': '360deg' } },
        ticker: { '0%': { transform: 'translateX(0)' }, '100%': { transform: 'translateX(-50%)' } },
        orbit: {
          '0%':   { transform: 'rotate(0deg) translateX(40px) rotate(0deg)' },
          '100%': { transform: 'rotate(360deg) translateX(40px) rotate(-360deg)' },
        },
        beam: {
          '0%,100%': { opacity: 0.3, transform: 'translateY(0)' },
          '50%':     { opacity: 0.8, transform: 'translateY(-8px)' },
        },
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
  ],
};
