<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      {{--@vite('resources/css/app.css')--}}
      <!-- <link href="resources/css/app.css" rel="stylesheet"> -->
       <script src="https://cdn.tailwindcss.com"></script>
       
       <script src="/js/app.js" defer></script>
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
<style>
  .p-128 {
            width: 32rem;
        }
</style>
  </head>
  <body class="bg-blue-200">
    <div id="app" class="flex justify-center pt-15">
  <weather-app></weather-app>
  </div>
</body>
</html>