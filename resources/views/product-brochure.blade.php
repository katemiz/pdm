




<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Author: Kılıç Ali Temiz katemiz@gmail.com">
        <meta name="theme-color" content="#317EFB"/>

        <title>Product Brochure</title>

        {{-- INCLUDES --}}
        <link rel="stylesheet" href="{{ asset('/css/app.css') }}">

        <link rel="stylesheet" href="{{ asset('/css/bulma.min.css')}}">
        <link rel="icon" type="image/x-icon" href="{{ asset('/images/favicon.ico') }}">

            <script src="{{ asset(path: '/js/canvasClass.js') }}"></script>


 

    <script>
        function readData(){

            const data = JSON.parse( localStorage.getItem('data') );
            console.log(data);


            //localStorage.removeItem('data');


            document.getElementById('extendedHeightDisplay').innerText = data.extendedHeight.toFixed(0);
            document.getElementById('nestedHeightDisplay').innerText = data.nestedHeight.toFixed(0);
            document.getElementById('windLoadOnPayloadDisplay').innerText = data.windLoadOnPayload.toFixed(0);
            document.getElementById('mastWeightDisplay').innerText = data.mastWeight.toFixed(0);
            document.getElementById('maxPayloadCapacityDisplay').innerText = data.maxPayloadCapacity.toFixed(0);
            // document.getElementById('maximumSurvivalWindSpeedDisplay').innerText = data.maximumSurvivalWindSpeed.toFixed(0);
            document.getElementById('lockTypeDisplay').innerText = data.lockType;
            document.getElementById('sectionTubesMaterialDisplay').innerText = data.sectionTubesMaterial;
            document.getElementById('sailAreaDisplay').innerText = data.sailarea.toFixed(2);


            // Number of Sections
            document.getElementById('numberOfSectionsDisplay').innerText = Object.keys(data.mastTubes).length;
            document.getElementById('windspeedDisplay').innerText = data.windspeed.toFixed(0);

        }

        </script>
        
    </head>
    <body class='has-background-lighter' onload="readData()">


        <section class="hero is-primary">
            <div class="hero-body">
                <div class="container">
                    <h1 class="title">
                        Product Brochure
                    </h1>
                    <h2 class="subtitle">
                        Mast Configurator Output
                    </h2>
                </div>
            </div>

        </section>







    <div class="section container p-8">

        <figure class="image my-0 mx-6">
            <img src="images/mtwr.png" alt="MTWR">
        </figure>

        <div class="fixed-grid has-3-cols">

            <div class="grid gap-4">

                <div class="cell has-background-white-ter py-3 my-2 level-item">
                <div class="has-text-centered">
                    <div>
                        <p class="heading">Maximum Payload Capacity</p>
                        <p class="title" id="maxPayloadCapacityDisplay"></p>
                        <p class="heading">kg</p>
                    </div>
                </div>
                </div>

                <div class="cell has-background-white-ter py-3 my-2 level-item">
                <div class="has-text-centered">
                    <div>
                        <p class="heading">Number Of Sections</p>
                        <p class="title" id="numberOfSectionsDisplay"></p>
                        <p class="heading">mm</p>
                    </div>
                </div>
                </div>

                <div class="cell has-background-white-ter py-3 my-2 level-item">
                <div class="has-text-centered">
                    <div>
                        <p class="heading">Extended Height</p>
                        <p class="title" id="extendedHeightDisplay"></p>
                        <p class="heading">mm</p>
                    </div>
                </div>
                </div>


                <div class="cell has-background-white-ter py-3 my-2 level-item">
                <div class="has-text-centered">
                    <div>
                        <p class="heading">Nested Height</p>
                        <p class="title" id="nestedHeightDisplay"></p>
                        <p class="heading">mm</p>
                    </div>
                </div>
                </div>


                <div class="cell has-background-white-ter py-3 my-2 level-item">
                <div class="has-text-centered">
                    <div>
                        <p class="heading">Maximum Operational Wind Speed</p>
                        <p class="title" id="windspeedDisplay"></p>
                        <p class="heading">km/h</p>
                    </div>
                </div>
                </div>




                <div class="cell level-item has-text-centered">
                    <div>
                        <p class="heading">Maximum Survival Wind Speed</p>
                        <p class="title" id="maximumSurvivalWindSpeedDisplay"></p>
                        <p class="heading">mm</p>
                    </div>
                </div>

                <div class="cell level-item has-text-centered">
                    <div>
                        <p class="heading">Payload Sail Area</p>
                        <p class="title" id="sailAreaDisplay"></p>
                        <p class="heading">m<sup>2</sup></p>
                    </div>
                </div>

                <div class="cell level-item has-text-centered">
                    <div>
                        <p class="heading">Wind Load on Payload</p>
                        <p class="title" id="windLoadOnPayloadDisplay"></p>
                        <p class="heading">N</p>
                    </div>
                </div>

                <div class="cell level-item has-text-centered">
                    <div>
                        <p class="heading">Lock Type</p>
                        <p class="title" id="lockTypeDisplay"></p>
                        <p class="heading">kg</p>
                    </div>
                </div>

                <div class="cell level-item has-text-centered">
                    <div>
                        <p class="heading">Section Tubes Material</p>
                        <p class="title" id="sectionTubesMaterialDisplay"></p>
                        <p class="heading">kg</p>
                    </div>
                </div>

                <div class="cell level-item has-text-centered">
                    <div>
                        <p class="heading">Mast Tubes Weight</p>
                        <p class="title" id="mastWeightDisplay"></p>
                        <p class="heading">kg</p>
                    </div>
                </div>

            </div>

        </div>


    </div>





























    </body>



</html>