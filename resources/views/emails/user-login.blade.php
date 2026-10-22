<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Aboard</title>
    @vite('resources/css/app.css')
</head>

<body class="m-0 bg-slate-100 p-6 font-sans text-slate-800">

<div class="mx-auto max-w-xl overflow-hidden rounded-2xl bg-white shadow-lg">

    <div class="bg-slate-900 px-8 py-10 text-center">
        <h1 class="text-3xl font-bold tracking-wide text-white">
            WELCOME ABOARD
        </h1>

        <p class="mt-3 text-teal-200">
            We're glad you're here.
        </p>
    </div>

    <div class="px-8 py-10 text-center">

        <h2 class="text-2xl font-bold text-slate-900">
            Hello
        </h2>

        <p class="mt-5 leading-7 text-slate-600">
            Thank you for joining our community.
            We're excited to have you with us.
        </p>

        <p class="mt-4 leading-7 text-slate-600">
            Your journey starts now. Explore your account
            and discover everything waiting for you.
        </p>

        <a
            href="{{ url('/') }}"
            class="mt-8 inline-block rounded-lg bg-teal-600 px-7 py-4 font-bold text-white no-underline"
        >
            EXPLORE YOUR ACCOUNT
        </a>

        <p class="mt-8 leading-7 text-slate-600">
            Best regards,<br>
            <span class="font-semibold text-slate-900">
                    The Team
                </span>
        </p>

    </div>

    <div class="border-t border-slate-200 bg-slate-50 px-6 py-5 text-center">
        <p class="text-xs leading-5 text-slate-500">
            This is an automated welcome email.<br>
            Thank you for being part of our community.
        </p>
    </div>

</div>

</body>
</html>
```
