<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript">
        const theme = localStorage.getItem('theme')
        if (!theme || theme === 'dark' && window.matchMedia('(prefers-color-scheme: dark)').matches){
            document.documentElement.classList.add('dark')
            document.documentElement.classList.add('bg-gray-700')
        }else{
            document.documentElement.classList.remove('dark')
            document.documentElement.classList.add('bg-[#f0f2f4]')
        }
    </script>
    @vitereactrefresh
    @vite(['resources/js/app.jsx','resources/css/app.css'])
    <x-inertia::head />
</head>
<body>
<x-inertia::app />
</body>
</html>
