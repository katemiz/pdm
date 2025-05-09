class DrawMastTubesClass {

    constructor(data) {

        // Data
        // this.tubes = data.tubes;
        // this.sys = data.sys;
        // this.overlaps = data.overlaps;

        // Constants
        this.MX = 300;       // Margin in X Direction
        this.MY = 300;       // Margin in X Direction

        this.R = 6;        // DIA OF REFERENCE CIRCLES

        this.CANVAS_ID = 'figCanvas'
        this.CANVAS_DIV = 'figDiv'

        let c = document.getElementById(this.CANVAS_ID);


        this.g = c.getContext("2d");

        // WIDTH AND HEIGHT
        c.width     = 0.95*document.getElementById(this.CANVAS_DIV).offsetWidth;
        c.height    = 0.3*c.width;

        this.w = c.width;
        this.h = c.height;

        console.log("w",this.w)
        console.log("h",this.h)

        let totalW = 2*this.MX+2*this.R+data.extendedHeight+data.zOffset
        let totalH = data.maxDia+2*this.MY

        console.log("totalW",totalW)
        console.log("totalH",totalH)

        this.sx = this.w/totalW
        this.sy = this.h/totalH

        console.log("sx",this.sx)
        console.log("sy",this.sy)

        this.tubes = data.tubes

        // x,y Scales
        // this.xScale = c.width/(this.sys.extendedHeight+this.sys.zOffset+2*this.MARGIN_X+this.PAYLOAD_DIA*5);
        // this.yScale = c.height/(this.tubes[0].od+2*this.MARGIN_Y);







        for (let index = this.tubes.length; index > 0; index--) {
            const element = this.tubes[index-1];
            // console.log(element)


            this.drawTubes(this.tubes[index-1])

            // return true;


        }


        this.auxiliaryCurves()




    }


    clearCanvas() {
        this.g.clearRect ( 0 , 0 , this.w , this.h );
        this.auxiliaryCurves();
    }






    // run() {

    //     this.drawTubes();
    // }




    auxiliaryCurves() {

        // TUBES CENTERLINE
        this.g.beginPath();
        this.g.lineWidth = 0.2;
        this.g.moveTo(this.MX*this.sx,this.h/2);
        this.g.lineTo((this.w-this.MX*this.sx),this.h/2);
        this.g.stroke();


        // TUBES COORDINATE AXIS CIRCLE
        this.g.beginPath();
        this.g.fillStyle = "Red";
        this.g.arc(this.MX*this.sx, this.h/2, this.R, 0, 2 * Math.PI);
        this.g.arc(this.w-this.MX*this.sx, this.h/2, this.R, 0, 2 * Math.PI);
        this.g.fill();
        this.g.stroke();
    }





    drawTubes(tube) {


        console.log("F tube",tube)

        let x0 = (this.MX+this.R+tube.heights.ebh)*this.sx
        let y0 = this.h/2-tube.od/2*this.sy
        let rw = (tube.length)*this.sx
        let rh = tube.od*this.sy

        console.log("X0",x0)
        console.log("Y0",y0)
        console.log("rw",rw)
        console.log("rh",rh)

        console.log("sx",this.sx)
        console.log("sy",this.sy)




        this.g.beginPath();
        this.g.fillStyle = "LightGray";
        this.g.strokeStyle = "Black";
        // this.g.translate((this.MARGIN_X+tube.zA)*this.xScale,this.yScale*(this.MARGIN_Y+(this.tubes[0].od-tube.od)/2));
        // this.g.scale(this.xScale,this.yScale)
        this.g.rect(x0,y0,rw,rh);
        this.g.stroke();
        this.g.fill();
        this.g.closePath();

        // this.g.setTransform(1, 0, 0, 1, 0, 0);

        // this.g.fillStyle = "Red";

        // this.g.fillText(tube.zA,(this.MARGIN_X+tube.zA)*this.xScale,this.h-10);
        // this.g.fillText(tube.zF,(this.MARGIN_X+tube.zF)*this.xScale,this.h-10);



        return true;


        // TUBES Z-OFFSET
        this.g.beginPath();
        this.g.lineWidth = 6;

        this.g.moveTo(this.xScale*(this.MARGIN_X+this.sys.extendedHeight),this.h/2);
        this.g.lineTo(this.xScale*(this.MARGIN_X+this.sys.totalHeight),this.h/2);
        this.g.stroke();

        this.g.setTransform(1, 0, 0, 1, 0, 0);

        // TUBES CENTERLINE
        this.g.beginPath();
        this.g.lineWidth = 0.2;
        this.g.moveTo(this.MARGIN_X*this.xScale,this.h/2);
        this.g.lineTo((this.w-this.MARGIN_X*this.xScale),this.h/2);
        this.g.stroke();

        // TUBES COORDINATE AXIS CIRCLE
        this.g.beginPath();
        this.g.fillStyle = "Red";
        this.g.arc(this.MARGIN_X*this.xScale, (this.MARGIN_Y+this.tubes[0].od/2)*this.yScale, 5, 0, 2 * Math.PI);
        this.g.fill();
        this.g.stroke();

        // DRAW PAYLOAD LOAD ARROW
        this.drawPayloadArrow(this.g, (this.MARGIN_X+this.sys.totalHeight)*this.xScale, 40, (this.MARGIN_X+this.sys.totalHeight)*this.xScale, this.h/2-15, 10, 'blue');
    }






    drawPayloadArrow(ctx, fromx, fromy, tox, toy, arrowWidth, color){
        //variables to be used when creating the arrow
        var headlen = 10;
        var angle = Math.atan2(toy-fromy,tox-fromx);

        ctx.fillText(this.sys.horLoad+'N',fromx-10,fromy-10);
        ctx.fillText(this.sys.totalHeight,(this.MARGIN_X+this.sys.totalHeight)*this.xScale,this.h-10);

        ctx.save();
        ctx.strokeStyle = color;

        //starting path of the arrow from the start square to the end square
        //and drawing the stroke
        ctx.beginPath();
        ctx.moveTo(fromx, fromy);
        ctx.lineTo(tox, toy);
        ctx.lineWidth = arrowWidth;
        ctx.stroke();

        //starting a new path from the head of the arrow to one of the sides of the point
        ctx.beginPath();
        ctx.moveTo(tox, toy);
        ctx.lineTo(tox-headlen*Math.cos(angle-Math.PI/7),
                   toy-headlen*Math.sin(angle-Math.PI/7));

        //path from the side point of the arrow, to the other side point
        ctx.lineTo(tox-headlen*Math.cos(angle+Math.PI/7),
                   toy-headlen*Math.sin(angle+Math.PI/7));

        //path from the side point back to the tip of the arrow, and then
        //again to the opposite side point
        ctx.lineTo(tox, toy);
        ctx.lineTo(tox-headlen*Math.cos(angle-Math.PI/7),
                   toy-headlen*Math.sin(angle-Math.PI/7));

        //draws the paths created above
        ctx.stroke();
        ctx.restore();
    }
}