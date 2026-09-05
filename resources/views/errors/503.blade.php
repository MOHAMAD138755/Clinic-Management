<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Maintenance Mode</title>
    @vite('resources/css/app.css')
</head>
<body class="flex justify-center items-center w-full h-screen flex-col bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 text-white">
    <h2 class="animate-bounce italic text-3xl text-center">{{ \App\Models\Setting::get('maintenance_title') }}</h2>

    <div class="my-3">
        <img src="storage/{{ \App\Models\Setting::get('maintenance_logo') }}" alt="img" class="w-64 h-64 rounded-full">
    </div>

    <div class="my-2">
        <button onclick="window.location.reload()" class="animate-pulse h-[35px] font-bold hover:bg-blue-800 transition-all duration-150 bg-blue-700 cursor-pointer rounded-md py-1 w-[300px]">Try Again</button>
    </div>

<div>
    <p class="lg:text-xl text-[17px] text-center leading-10">{{ \App\Models\Setting::get('maintenance_description') }}</p>
</div>

</body>
</html>
