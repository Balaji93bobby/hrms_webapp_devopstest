<!DOCTYPE html>
<html >
    <head>
        <title>Vue Js testing</title>

        @vite(['resources/js/app.js'])


        {{-- @vite('resources/js/hrms/pages/LocalCompTest.js') --}}

    </head>
    <body>
        <h2>VUE JS Testings</h2>
        <div class="container">
            <div id="app">
                <Counter />
                {{-- <Localcomp></Localcomp> --}}
            </div>
            <div id="counter">

            </div>
            <div id="localcomp">
                {{-- <LocalCompTest> </LocalCompTest> --}}

            </div>

            {{-- @vite('resources/js/hrms/pages/Counter.js')
            @vite('resources/js/hrms/pages/LocalCompTest.js') --}}
        </div>
    </body>
    </html>
