module.exports = {
	content: [
		'./resources/**/*.blade.php',
		'./resources/**/*.ts',
		'./resources/**/*.vue',
        'node_modules/flowbite-vue/**/*.{js,jsx,ts,tsx}',
        'node_modules/flowbite/**/*.{js,jsx,ts,tsx}'
	],
	theme: {
		extend: {
            fontFamily: {
                'libre': ['Libre Baskerville', 'serif'],
                'manrope':['Manrope', 'sans-serif'],

            },
        },
        colors: {
            transparent: 'transparent',
            current: 'currentColor',
            'white': '#ffffff',
            'black':'#000000',
            'primary': {
                100: '#445c78',
                200: '#768EAC',
                300:'#4478BA',
                400:'#F4FAFB'

            },
            'black':{
                100: '#000000'
            },
            'gray': {
                50: "#fafafa",
                100: "#e4e5f1",
                200: "#d2d3db",
                300: "#9394a5",
                400: "#484b6a",
                500: "#6b7280",
                600: "#4b5563",
                700: "#374151",
                800: "#1f2937",
                900: "#111827",
            },
            'red':{
                50: '#fef2f2',
                100: '#fee2e2',
                200: '#fecaca',
                300: '#fca5a5',
                400: '#f87171',
                500: '#ef4444',
                600: '#dc2626',
                700: '#b91c1c',
                800: '#991b1b',
                900: '#7f1d1d',
            },
            'green':{

                50: '#f0fdf4',
                100: '#dcfce7',
                200: '#bbf7d0',
                300: '#86efac',
                400: '#4ade80',
                500: '#22c55e',
                600: '#16a34a',
                700: '#15803d',
                800: '#166534',
                900: '#14532d',
            },

            'yellow':{

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
            },
        },
	},
	plugins: [
        require('flowbite/plugin')
    ],
}
