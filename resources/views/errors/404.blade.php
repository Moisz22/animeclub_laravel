<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('/css/app.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/fontawesome-free/css/all.min.css')}}">
    <title>404 | Animeclub</title>
</head>
<body class="dark:bg-black overflow-y-hidden">
    <div class="h-10 lg:d-none sm:d-block"></div>
    <div class="container mx-auto px-2">
        <button id="modo"><i class="fas fa-moon"></i></button>
        <div class="row h-2 lg:d-none sm:d-block"></div>
        <div class="row">
            <p class="text-center text-2xl dark:text-white mb-4">Página no disponible</p>
        </div>
        <div class="row">
            <img class="m-auto" height="500" width="500" src="{{asset('img/cheems.jpg')}}" alt="cheems">
        </div>
    </div>
    <script>
        let modo = document.getElementById("modo")
        
        modo.addEventListener('click', ()=>{
            if(modo.children[0].classList.contains('fa-moon'))
            {
                document.children[0].classList.add('dark')
                modo.children[0].classList.remove('fa-moon')
                modo.children[0].classList.add('fa-sun')
                modo.children[0].style.color ="white"
                /* modo.children[0].classList.add('color-gray-50') */
            }
            else
            {
                document.children[0].classList.remove('dark')
                modo.children[0].classList.remove('fa-sun')
                modo.children[0].classList.add('fa-moon')
                modo.children[0].style.color =""
                /* modo.children[0].classList.remove('color-gray-50') */
            }
    
        })
    </script>
</body>
</html>