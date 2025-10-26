class CanvasClass {

    constructor(data, graphType) {


        console.log('CanvasClass start:', data)


        // Data
        this.data = data

        this.graphType = graphType


        // Constants
        this.MX = 300;       // Margin in X Direction
        this.MY = 30;       // Margin in X Direction

        this.R = 6;        // DIA OF REFERENCE CIRCLES

        this.CANVAS_DIV = 'svgDiv'

        this.hasBaseAdapter = true
        this.hasTopAdapter = true
        this.hasSideAdapter = true
    }


    run() {

        this.setValues()
        this.drawMastTubes()
        this.drawBaseAdapter()
        this.drawMastCenterline()

        this.svg.appendChild(this.g)
        this.svg.appendChild(this.gtext)

    }


    setValues() {

        // TAB TITLE HEADER UPDATE

        document.getElementById('tabHeader').innerHTML = this.graphType

        // CREATE SVG ELEMENT
        this.svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
        this.svg.id = 'svg'

        // CONTAINER AND SVG ELEMENT
        this.div = document.getElementById(this.CANVAS_DIV)

        this.div.appendChild(this.svg)

        this.svgW = this.div.clientWidth - window.getComputedStyle(this.div).paddingLeft.replace('px', '') - window.getComputedStyle(this.div).paddingRight.replace('px', '')
        this.svgH = this.svgW

        this.svg.setAttribute('width', this.svgW)
        this.svg.setAttribute('height', this.svgH)

        let totalW, totalH

        if (this.graphType === 'Loads') {
            totalW = 2 * this.MX + this.data.extendedHeight + 2 * this.data.zOffset
            totalH = 2 * this.MY + this.data.maxMastTubeDia + 2 * this.data.xOffset
        }

        if (this.graphType === 'Nested') {
            totalW = 2 * this.MX + this.data.nestedHeight + 2 * this.data.zOffset
            totalH = 2 * this.MY + this.data.maxMastTubeDia + 2 * this.data.xOffset
        }

        if (this.graphType === 'Extended') {
            totalW = 2 * this.MX + this.data.extendedHeight + 2 * this.data.zOffset
            totalH = 2 * this.MY + this.data.maxMastTubeDia + 2 * this.data.xOffset
        }



        // x,y Scales
        this.sx = this.svgW / totalW
        this.sy = this.svgH / totalH


        // console.log('qqqqqqqqqqq', this.svgW, totalW, this.sx)

        this.x0 = this.svgW / 3
        this.y0 = this.svgH - this.MY

        console.log('x0 y0', this.x0, this.y0)

        // SVG BACKGROUND RECTANGLE
        let bg = document.createElementNS('http://www.w3.org/2000/svg', 'rect')

        bg.setAttribute('width', this.svgW)
        bg.setAttribute('height', this.svgW)
        bg.setAttribute('fill', '#a3a5a3ff')

        bg.setAttribute('style', 'fill-opacity: .20;')

        this.svg.appendChild(bg)



        // PREPARE FOR DFFERENT CONFGURATONS
        // Loads
        // Extended
        // Nested

        this.g = document.createElementNS('http://www.w3.org/2000/svg', 'g')

        switch (this.graphType) {

            case 'Extended':
            case 'Nested':
            default:
                // this.g.setAttribute('transform', ' translate(' + this.x0 + ',' + this.y0 + ') scale(' + this.scale + ') rotate(180)')
                this.g.setAttribute('transform', ' translate(' + this.x0 + ',' + this.y0 + ') scale(' + this.sx + ') rotate(180)')
                break;
        }


        // HAVE A DFFERENT GROUP FOR TEXT
        this.gtext = document.createElementNS('http://www.w3.org/2000/svg', 'g')
        // this.gtext.setAttribute('transform', ' scale(' + this.sx + ')')
        this.gtext.setAttribute('transform', ' translate(' + this.x0 + ',' + this.y0 + ') scale(' + this.sx + ')')




    }




    drawMastTubes() {

        for (const [key, tube] of Object.entries(this.data.mastTubes)) {

            this.drawRectangle(tube, this.g);

            this.drawFixedTubeFlange(tube, this.g)

            this.drawDimTextLine(tube)


            // if (this.svgType === 'Nested') {
            //     this.drawRectangle(profile.od, profile.length, profile.nested.A.x, profile.nested.A.y, this.g);
            // }

            // if (this.svgType === 'Extended') {
            //     this.drawRectangle(profile.od * this.k, profile.length, profile.extended.A.x * this.k, profile.extended.A.y, this.g);
            // }
        }




        // this.drawAdapters(this.g, 'base')
        // this.drawAdapters(this.g, 'top')
        // this.drawAdapters(this.g, 'side')

        // this.drawTextAndDims()


    }



    drawRectangle(tube, parent) {

        let r = document.createElementNS('http://www.w3.org/2000/svg', 'rect')

        let x = 0, y

        switch (this.graphType) {
            case 'Extended':
                y = tube.bottomCenterPointExtended
                break;

            case 'Nested':
            default:
                y = tube.bottomCenterPointNested
                break;
        }

        // let lowerLeft = {"x":x-tube.od/2,"y":y}
        // let upperRight = {"x":x+tube.od/2,"y":y+tube.length}

        r.setAttribute('x', x - tube.od / 2)
        r.setAttribute('y', y)
        r.setAttribute('width', tube.od)
        r.setAttribute('height', tube.length)

        r.setAttribute('fill', '#EAE2B7')
        r.setAttribute('style', 'fill-opacity: .25;')
        r.setAttribute('stroke', '#28272e')
        r.setAttribute('stroke-width', '4')

        parent.appendChild(r)
    }




    drawFixedTubeFlange(tube, parent) {

        let od = tube.od
        let h = this.data.headLength * 0.5

        let x0 = 0
        let y0

        switch (this.graphType) {
            case 'Extended':
                y0 = tube.bottomCenterPointExtended + tube.length
                break;

            case 'Nested':
            default:
                y0 = tube.bottomCenterPointNested + tube.length
                break;
        }



        let points =
            (x0 - (0.50 * od)) + ',' + y0 + ',' +
            (x0 - (0.74 * od)) + ',' + y0 + ',' +
            (x0 - (0.74 * od)) + ',' + (y0 - .25 * h) + ',' +
            (x0 - (0.58 * od)) + ',' + (y0 - .25 * h) + ',' +
            (x0 - (0.58 * od)) + ',' + (y0 - h) + ',' +
            (x0 - (0.50 * od)) + ',' + (y0 - h) + ',';

        let points2 =
            (x0 + (0.50 * od)) + ',' + y0 + ',' +
            (x0 + (0.74 * od)) + ',' + y0 + ',' +
            (x0 + (0.74 * od)) + ',' + (y0 - .25 * h) + ',' +
            (x0 + (0.58 * od)) + ',' + (y0 - .25 * h) + ',' +
            (x0 + (0.58 * od)) + ',' + (y0 - h) + ',' +
            (x0 + (0.50 * od)) + ',' + (y0 - h) + ',';


        let r = document.createElementNS('http://www.w3.org/2000/svg', 'polygon')

        r.setAttribute('points', points)
        r.setAttribute('fill', '#3deb11ff')
        r.setAttribute('style', 'fill-opacity: .4;')
        r.setAttribute('stroke', '#28272e')
        r.setAttribute('stroke-width', '1')

        r.setAttribute('style', 'fill-opacity: .95;')


        let r2 = document.createElementNS('http://www.w3.org/2000/svg', 'polygon')

        r2.setAttribute('points', points2)
        r2.setAttribute('fill', '#3deb11ff')
        r2.setAttribute('style', 'fill-opacity: .4;')
        r2.setAttribute('stroke', '#28272e')
        r2.setAttribute('stroke-width', '1')

        r2.setAttribute('style', 'fill-opacity: .95;')

        parent.appendChild(r)
        parent.appendChild(r2)
    }




    drawDimTextLine(tube) {


        let offset = parseInt(this.data.maxMastTubeDia)
        let textLeaderLength = parseInt(this.data.maxMastTubeDia)

        let x1 = parseInt(offset)
        let x2 = (x1 + textLeaderLength)

        let y

        switch (this.graphType) {
            case 'Extended':
                y = tube.bottomCenterPointExtended
                break;

            case 'Nested':
            default:
                y = tube.bottomCenterPointNested
                break;
        }


        console.log('y', this.x0, y, this.svgH, x1, x2)



        let l = document.createElementNS('http://www.w3.org/2000/svg', 'line')

        l.setAttribute('x1', x1)
        l.setAttribute('y1', y - 1070)
        l.setAttribute('x2', x2)
        l.setAttribute('y2', y - 1070)
        l.setAttribute('stroke', '#4F6D7A')
        l.setAttribute('stroke-width', '2')

        this.gtext.appendChild(l)

        let t = document.createElementNS('http://www.w3.org/2000/svg', 'text')

        t.setAttribute('x', x2 + 220)
        t.setAttribute('y', this.svgH - y - 1070)
        t.setAttribute('font-size', "4em")
        t.innerHTML = tube.bottomCenterPointNested

        this.gtext.appendChild(t)
    }






    drawBaseAdapter() {

        let od = this.data.mastTubes[0].od
        let h = this.data.baseAdapterThk

        // let x0 = this.x0
        // let y0 = this.y0

        let x0 = 0
        let y0 = 0

        console.log(x0, y0)

        let points =
            (x0 - (0.58 * od + 2.5 * h)) + ',' + y0 + ',' +
            (x0 - (0.58 * od + 2.5 * h)) + ',' + (y0 + h) + ',' +
            (x0 - (0.58 * od)) + ',' + (y0 + h) + ',' +
            (x0 - (0.58 * od)) + ',' + (y0 + 5 * h) + ',' +
            (x0 - (0.50 * od)) + ',' + (y0 + 5 * h) + ',' +
            (x0 - (0.50 * od)) + ',' + (y0 + h) + ',' +
            (x0 + (0.50 * od)) + ',' + (y0 + h) + ',' +
            (x0 + (0.50 * od)) + ',' + (y0 + 5 * h) + ',' +
            (x0 + (0.58 * od)) + ',' + (y0 + 5 * h) + ',' +
            (x0 + (0.58 * od)) + ',' + (y0 + h) + ',' +
            (x0 + (0.58 * od + 2.5 * h)) + ',' + (y0 + h) + ',' +
            (x0 + (0.58 * od + 2.5 * h)) + ',' + y0;

        let r = document.createElementNS('http://www.w3.org/2000/svg', 'polygon')

        r.setAttribute('points', points)
        r.setAttribute('fill', '#d87d06ff')
        r.setAttribute('style', 'fill-opacity: .4;')
        r.setAttribute('stroke', '#28272e')
        r.setAttribute('stroke-width', '4')
        r.setAttribute('style', 'fill-opacity: .95;')

        this.g.appendChild(r)
    }


    drawMastCenterline() {

        let l = document.createElementNS('http://www.w3.org/2000/svg', 'line')

        l.setAttribute('x1', 0)
        l.setAttribute('y1', this.MY / 2)
        l.setAttribute('x2', 0)
        l.setAttribute('y2', this.svgH - this.MY / 2)
        l.setAttribute('stroke', 'rgb(100, 0, 0)')
        l.setAttribute('stroke-width', '1')

        this.g.appendChild(l)
    }



    SILsetCanvasValues() {

        // WIDTH AND HEIGHT
        this.c.width = 0.95 * document.getElementById(this.CANVAS_DIV).offsetWidth;
        this.c.height = 0.3 * this.c.width;

        this.w = this.c.width;
        this.h = this.c.height;

        // this.g.fillStyle = 'lightblue';
        // this.g.fillRect(0, 0, this.w, this.h);

        let totalW = 2 * this.MX + this.data.extendedHeight + 2 * this.data.zOffset
        let totalH = 2 * this.MY + this.data.maxMastTubeDia + 2 * this.data.xOffset

        // x,y Scales
        this.sx = this.w / totalW
        this.sy = this.h / totalH

        this.tubes = this.data.mastTubes

        this.startTubeNo = this.data.startTubeNo
        this.endTubeNo = this.data.endTubeNo

        this.data.mastTubes.toArray.forEach(tube => {
            this.drawTubes(tube)
        });




        this.auxiliaryCurves()
    }






    auxiliaryCurves() {

        this.g.fillStyle = "black";
        this.g.font = "16px Arial";

        // Windload on Payload Arrow
        this.drawPayloadArrow(this.w - this.MX * this.sx, this.h / 2 + this.data.xOffset * this.sy, this.w - this.MX * this.sx, this.h / 2 + this.data.xOffset * this.sy + 100, 4, "green")
        this.g.fillText("Wind Load", this.w - this.MX * this.sx - 90, this.h - 15);

        // Payload Arrow
        this.drawPayloadArrow(this.w - this.MX * this.sx, this.h / 2 + this.data.xOffset * this.sy, this.w - this.MX * this.sx - 100, this.h / 2 + this.data.xOffset * this.sy, 6, "orange")
        this.g.fillText("Payload Weight", this.w - this.MX * this.sx - 150, this.h / 2 + (this.data.xOffset + 75) * this.sy);


        // Mast Weight Arrow
        this.drawPayloadArrow(this.w / 2, this.h / 2, this.w / 2 - 100, this.h / 2, 6, "orange");
        this.g.fillText("Mast Weight", this.w / 2 + 10, this.h / 2 + 5);

        // TUBES CENTERLINE
        this.g.beginPath();
        this.g.lineWidth = 0.2;
        this.g.moveTo(this.MX * this.sx, this.h / 2);
        this.g.lineTo((this.w - this.MX * this.sx), this.h / 2);
        this.g.stroke();

        // TUBES COORDINATE AXIS CIRCLE
        this.g.beginPath();
        this.g.fillStyle = "Green";
        this.g.arc(this.MX * this.sx, this.h / 2, this.R, 0, 2 * Math.PI);
        this.g.arc(this.w - this.MX * this.sx, this.h / 2 + this.data.xOffset * this.sy, this.R, 0, 2 * Math.PI);
        this.g.fill();

        this.g.closePath();
    }





    drawTubes(tube) {

        let x0 = (this.MX + this.R + tube.heights.ebh - this.zeroizeHeight) * this.sx
        let y0 = this.h / 2 - tube.od / 2 * this.sy
        let rw = (tube.length) * this.sx
        let rh = tube.od * this.sy

        this.g.beginPath();
        this.g.fillStyle = "LightGray";
        this.g.strokeStyle = "Black";

        this.g.rect(x0, y0, rw, rh);
        this.g.stroke();
        this.g.fill();
        this.g.closePath();

        this.g.fillStyle = "Green";
        this.g.fillText('F' + tube.no, x0 + rw / 2 - 5, y0 - 60);

        this.drawPayloadArrow(x0 + rw / 2, y0 - 50, x0 + rw / 2, y0, 4, "green");

        return true;
    }






    drawPayloadArrow(fromx, fromy, tox, toy, arrowWidth = this.R, color = "blue") {
        //variables to be used when creating the arrow
        var headlen = 10;
        var angle = Math.atan2(toy - fromy, tox - fromx);



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
        this.g.lineTo(tox - headlen * Math.cos(angle - Math.PI / 7),
            toy - headlen * Math.sin(angle - Math.PI / 7));

        //path from the side point of the arrow, to the other side point
        this.g.lineTo(tox - headlen * Math.cos(angle + Math.PI / 7),
            toy - headlen * Math.sin(angle + Math.PI / 7));

        //path from the side point back to the tip of the arrow, and then
        //again to the opposite side point
        this.g.lineTo(tox, toy);
        this.g.lineTo(tox - headlen * Math.cos(angle - Math.PI / 7),
            toy - headlen * Math.sin(angle - Math.PI / 7));

        //draws the paths created above
        this.g.stroke();
        this.g.restore();
    }
}







function SILdrawCanvas(data) {


    console.log("All Data in DrawCanvas", data)





    if (document.getElementById('svg')) {
        document.getElementById('svg').remove()
    }

    let p = new CanvasClass(e.detail.data, e.detail.graphType);

    p.run()










    // let canvasParent = document.getElementById("canvasDiv");

    // if (document.getElementById("figCanvas")) {
    //     document.getElementById("figCanvas").remove();
    // }

    // let canvas = document.createElement("canvas");
    // canvas.id = "figCanvas";

    // canvasParent.appendChild(canvas);

    // let myMast = new CanvasClass(data, canvas);
    // myMast.setCanvasValues();

    // console.log(new Date())



}










