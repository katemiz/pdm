<div class="column is-half has-background-warning" id="canvas_div">
    
    <script>

        let canvasDiv = document.getElementById("canvas_div");
        let padding = window.getComputedStyle(canvasDiv, null).getPropertyValue('padding-left')

        padding = parseInt(padding.replace('px',''))

        let canvas = document.createElement('canvas')
        canvas.classList.add('has-background-grey')
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

            let max_dim;

            if (height >= width) {
                max_dim = height
            } else {
                max_dim =width
            }

            console.log("w H",width,height)
            
            let area_vertical = height*t1
            let area_horizontal = (width-t1)*t2
            
            let total_area = area_vertical+area_horizontal
            
            let cx = (area_vertical*t1*0.5+area_horizontal*(width-t1)*0.5)/total_area
            let cy = (area_vertical*(height-t2)*0.5+area_horizontal*t2*0.5)/total_area
            
            let vx1 = cwidth/2-cx
            let vy1 = cheight/2+cy-height
            
            let vx2 = vx1+t1
            let vy2 = vy1+height-t2

            let startPoint = {
                x:(cwidth-width)/2,
                y:(cheight-height)/2
            }

            console.log("width ",cwidth)
            console.log(startPoint)
            
            // Find Scale and Start Point
            let scale = (0.8*cwidth)/max_dim

            console.log("scale and max_dim",scale,max_dim)

            ctx.translate((cwidth-scale*width)/2, (cheight-scale*height)/2);


            ctx.scale(scale, scale);
            ctx.beginPath();

            console.log("x y",(cwidth-scale*width)/2, (cheight-scale*height)/2)


            // Set a start-point
            ctx.moveTo(0, 0);

            ctx.lineTo(t1, 0);
            ctx.lineTo(t1, height-t2);
            ctx.lineTo(width, height-t2);
            ctx.lineTo(width, height);
            ctx.lineTo(0, height);
            ctx.lineTo(0, 0);

            // Stroke it (Do the Drawing)
            ctx.strokeStyle = "red";
            ctx.fillStyle = "green"
            ctx.lineWidth = 2;
            ctx.fill();
            ctx.stroke();

            console.log('Drawing Shape',Date.now())


        }

        function ClearCanvas() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            console.log('Canvas Cleared',Date.now())

            console.log('Canvas Cleared2',canvas.width,canvas.height)

        }

        

        window.addEventListener('repaint',function(e) {

            // "width" => $this->lshape_width,
            //     "height" => $this->lshape_height,
            //     "thk1" => $this->lshape_thk1,
            //     "thk2" => $this->lshape_thk2,
            //     "radius" => $this->lshape_radius

            console.log(e.detail.width)
            console.log(e.detail)

            console.log('Repainting',Date.now())
            ClearCanvas()
            DrawShape(e.detail)
        })



    
    </script>




</div>