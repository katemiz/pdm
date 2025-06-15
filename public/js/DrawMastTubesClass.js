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

        // this.g.fillStyle = 'lightblue';
        // this.g.fillRect(0, 0, this.w, this.h);

        let totalW = 2*this.MX+2*this.R+this.data.extendedHeight+this.data.zOffset
        let totalH = this.data.maxDia+2*this.MY

        // x,y Scales
        this.sx = this.w/totalW
        this.sy = this.h/totalH

        this.tubes = this.data.tubes

        this.startTubeNo = this.data.startTubeNo
        this.endTubeNo = this.data.endTubeNo


        this.zeroizeHeight = this.tubes[this.endTubeNo-1].heights.ebh

        // this.activeTubeNo = this.endTubeNo - this.startTubeNo + 1

        // console.log("endTubeNo",this.endTubeNo)


        // for (let index = this.tubes.length; index > 0; index--) {
        //     // const element = this.tubes[index-1];
        //     this.drawTubes(this.tubes[index-1])
        // }



        for (let index = this.endTubeNo; index >= this.startTubeNo; index--) {

            this.drawTubes(this.tubes[index-1])

            // console.log("Drawing tube",index-1,this.tubes[index-1])

            
        }

        this.auxiliaryCurves()
    }






    auxiliaryCurves() {

        this.g.fillStyle = "black";
        this.g.font = "16px Arial";

        // Windload on Payload Arrow
        this.drawPayloadArrow(this.w-this.MX*this.sx, this.h/2+this.data.xOffset*this.sy, this.w-this.MX*this.sx, this.h/2+this.data.xOffset*this.sy+100,4,"green")
        this.g.fillText("Wind Load",this.w-this.MX*this.sx-90,this.h-15);

        // Payload Arrow
        this.drawPayloadArrow(this.w-this.MX*this.sx, this.h/2+this.data.xOffset*this.sy, this.w-this.MX*this.sx-100, this.h/2+this.data.xOffset*this.sy,6,"orange")
        this.g.fillText("Payload Weight",this.w-this.MX*this.sx-150,this.h/2+(this.data.xOffset+75)*this.sy);


        // Mast Weight Arrow
        this.drawPayloadArrow(this.w/2, this.h/2, this.w/2-100, this.h/2,6,"orange");
        this.g.fillText("Mast Weight",this.w/2+10,this.h/2+5);

        // TUBES CENTERLINE
        this.g.beginPath();
        this.g.lineWidth = 0.2;
        this.g.moveTo(this.MX*this.sx,this.h/2);
        this.g.lineTo((this.w-this.MX*this.sx),this.h/2);
        this.g.stroke();

        // TUBES COORDINATE AXIS CIRCLE
        this.g.beginPath();
        this.g.fillStyle = "Green";
        this.g.arc(this.MX*this.sx, this.h/2, this.R, 0, 2 * Math.PI);
        this.g.arc(this.w-this.MX*this.sx, this.h/2+this.data.xOffset*this.sy, this.R, 0, 2 * Math.PI);
        this.g.fill();

        this.g.closePath();
    }





    drawTubes(tube) {

        let x0 = (this.MX+this.R+tube.heights.ebh-this.zeroizeHeight)*this.sx
        let y0 = this.h/2-tube.od/2*this.sy
        let rw = (tube.length)*this.sx
        let rh = tube.od*this.sy

        this.g.beginPath();
        this.g.fillStyle = "LightGray";
        this.g.strokeStyle = "Black";

        this.g.rect(x0,y0,rw,rh);
        this.g.stroke();
        this.g.fill();
        this.g.closePath();

        this.g.fillStyle = "Green";
        this.g.fillText('F'+tube.no,x0+rw/2-5,y0-60);

        this.drawPayloadArrow(x0+rw/2, y0-50, x0+rw/2, y0,4,"green");

        return true;
    }






    drawPayloadArrow(fromx, fromy, tox, toy, arrowWidth=this.R, color="blue"){
        //variables to be used when creating the arrow
        var headlen = 10;
        var angle = Math.atan2(toy-fromy,tox-fromx);



        // let totalHeight = this.data.extendedHeight+this.data.zOffset

        // this.g.fillText(this.data.windLoad+'N',fromx-10,fromy-10);
        // this.g.fillText(this.sys.totalHeight,(this.MARGIN_X+this.sys.totalHeight)*this.xScale,this.h-10);

        this.g.save();
        this.g.strokeStyle = color;

        //starting path of the arrow from the start square to the end square
        //and drawing the stroke
        this.g.beginPath();
        this.g.moveTo(fromx, fromy);
        this.g.lineTo(tox, toy);
        this.g.lineWidth = arrowWidth;
        this.g.stroke();

        //starting a new path from the head of the arrow to one of the sides of the point
        this.g.beginPath();
        this.g.moveTo(tox, toy);
        this.g.lineTo(tox-headlen*Math.cos(angle-Math.PI/7),
                   toy-headlen*Math.sin(angle-Math.PI/7));

        //path from the side point of the arrow, to the other side point
        this.g.lineTo(tox-headlen*Math.cos(angle+Math.PI/7),
                   toy-headlen*Math.sin(angle+Math.PI/7));

        //path from the side point back to the tip of the arrow, and then
        //again to the opposite side point
        this.g.lineTo(tox, toy);
        this.g.lineTo(tox-headlen*Math.cos(angle-Math.PI/7),
                   toy-headlen*Math.sin(angle-Math.PI/7));

        //draws the paths created above
        this.g.stroke();
        this.g.restore();
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
    // myMast.setCanvasValues();

    // console.log(new Date())



}










