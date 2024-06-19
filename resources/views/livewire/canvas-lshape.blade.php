<div class="column is-half has-background-light" id="canvas_div">

    <script src="{{ asset('/js/canvas.js') }}"></script>

    <script>

        let canvasDiv = document.getElementById("canvas_div");
        let padding = window.getComputedStyle(canvasDiv, null).getPropertyValue('padding-left')

        padding = parseInt(padding.replace('px',''))

        let canvas = document.createElement('canvas')
        // canvas.classList.add('has-background-grey')
        canvas.id = 'myCanvas'

        canvasDiv.append(canvas)

        const ctx = canvas.getContext("2d");
        ctx.fillStyle = "blue";

        canvas.width = canvasDiv.offsetWidth -2*padding
        canvas.height = canvas.width

        let cwidth = canvas.width
        let cheight = canvas.height

        function DrawShape(dims) {

            var t1 = parseFloat(dims.thk1);
            var t2 = parseFloat(dims.thk2);
            var height = parseFloat(dims.height);
            var width = parseFloat(dims.width);
            var r = parseFloat(dims.radius);

            var cx = parseFloat(dims.cx)
            var cy = parseFloat(dims.cy)
            var area = parseFloat(dims.area)

            let max_dim;
            let usage_ratio = 0.6

            let cox,coy

            if (height >= width) {
                max_dim = height
            } else {
                max_dim =width
            }

            // Find Scale
            let scale = (usage_ratio*cwidth)/max_dim

            // Draw Coordinate Axes (x,y)
            cox = 0.5*(cwidth-width*scale)
            coy = 0.5*(cheight-scale*height)+scale*height

            ctx.strokeStyle = "black"
            ctx.lineWidth = 0.2;

            ctx.beginPath();

                ctx.moveTo(0, coy);
                ctx.lineTo(cwidth, coy);

                ctx.moveTo(cox, 0);
                ctx.lineTo(cox, cheight);

            ctx.stroke();

            // Find Article at Center of Gravity, Draw Circle and Write Coordinates
            DrawArticle(ctx,cox+cx*scale,coy-cy*scale, true)

            DrawArrow(ctx,cwidth-20,coy,0,"X")
            DrawArrow(ctx,cox,20,270,"Y")

            ctx.fillStyle = "black";
            ctx.fillText("("+Math.round(cx*1000,3)/1000+","+Math.round(cy*1000,3)/1000+")",cox+scale*cx+5,coy-scale*cy-5);

            // Set Scale and Translation
            ctx.translate((cwidth-scale*width)/2, (cheight-scale*height)/2);
            ctx.scale(scale, scale);

            // Draw L-Shape
            ctx.beginPath();

                ctx.moveTo(0, 0);
                ctx.lineTo(t1, 0);
                ctx.lineTo(t1, height-t2-r);

                if (r > 0) {
                    ctx.arc(t1+r, height-r-t2, r,Math.PI,0.5*Math.PI,true);
                }

                ctx.lineTo(width, height-t2);
                ctx.lineTo(width, height);
                ctx.lineTo(0, height);
                ctx.lineTo(0, 0);

                ctx.strokeStyle = "black"
                ctx.lineWidth = .1;

                // Stroke it (Do the Drawing)
                ctx.fillStyle = "grey"
                ctx.fill();
            ctx.stroke();
        }





        function ClearCanvas() {
            canvas.width = canvas.width;
            canvas.height = canvas.height;
        }



        window.addEventListener('repaint',function(e) {
            ClearCanvas()
            DrawShape(e.detail)
        })




    </script>




</div>
