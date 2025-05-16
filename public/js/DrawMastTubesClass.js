class CanvasClass {

    constructor(data,canvas) {

        // Data
        this.data = data

        // Constants
        this.MX = 300;       // Margin in X Direction
        this.MY = 300;       // Margin in X Direction

        this.R = 6;        // DIA OF REFERENCE CIRCLES

        this.CANVAS_DIV = 'canvasDiv'

        this.c = canvas
        this.g = this.c.getContext("2d");

        this.setCanvasValues()
    }


    setCanvasValues() {

        // WIDTH AND HEIGHT
        this.c.width     = 0.95*document.getElementById(this.CANVAS_DIV).offsetWidth;
        this.c.height    = 0.3*this.c.width;

        this.w = this.c.width;
        this.h = this.c.height;

        this.g.fillStyle = 'lightblue';
        this.g.fillRect(0, 0, this.w, this.h);

        let totalW = 2*this.MX+2*this.R+this.data.extendedHeight+this.data.zOffset
        let totalH = this.data.maxDia+2*this.MY

        // x,y Scales
        this.sx = this.w/totalW
        this.sy = this.h/totalH

        this.tubes = this.data.tubes

        for (let index = this.tubes.length; index > 0; index--) {
            const element = this.tubes[index-1];
            this.drawTubes(this.tubes[index-1])
        }

        this.auxiliaryCurves()
    }






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


        // console.log("F tube",tube)

        let x0 = (this.MX+this.R+tube.heights.ebh)*this.sx
        let y0 = this.h/2-tube.od/2*this.sy
        let rw = (tube.length)*this.sx
        let rh = tube.od*this.sy

        // console.log("X0",x0)
        // console.log("Y0",y0)
        // console.log("rw",rw)
        // console.log("rh",rh)

        // console.log("sx",this.sx)
        // console.log("sy",this.sy)




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







function drawCanvas(data) {

    console.log(data)


    let canvasParent = document.getElementById("canvasDiv");

    if(document.getElementById("figCanvas")){
        document.getElementById("figCanvas").remove();
    } 

    let canvas = document.createElement("canvas");
    canvas.id = "figCanvas";

    canvasParent.appendChild(canvas);

    let myMast = new CanvasClass(data,canvas);
    myMast.setCanvasValues();

    console.log(new Date())

}




