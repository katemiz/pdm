<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script src="{{ asset(path: '/js/canvasClass.js') }}"></script>

    <script>








        function drawLine(parent, x1, y1, x2, y2) {



            let l = document.createElementNS('http://www.w3.org/2000/svg', 'line')

            l.setAttribute('x1', x1)
            l.setAttribute('y1', y1)
            l.setAttribute('x2', x2)
            l.setAttribute('y2', y2)
            l.setAttribute('stroke', 'oklch(0.9 0.3 164)')
            l.setAttribute('stroke-width', '2')

            l.setAttribute('transform', 'translate(50,0)');

            parent.appendChild(l)


        }



        function run() {


            let newImage = new CanvasClass();

        }







    </script>
</head>

<body onload="run()">



    <div id="myDiv" style="bg-color:yellow">

        <svg id="svg">
            <circle r="30" cx="50" cy="50" />
        </svg>

    </div>

</body>

</html>