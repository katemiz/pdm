class CanvasClass {

    constructor(data, graphType) {

        console.log('CanvasClass start:', data,graphType)

        // Data
        this.data = data
        this.graphType = graphType

        // Constants
        this.MX = 3;       // % Margin in X Direction
        this.MY = 3;       // % Margin in X Direction

        this.R = 6;        // DIA OF REFERENCE CIRCLES

        this.CANVAS_DIV = 'svgDiv'

        this.totalH;

        this.hasBaseAdapter = true
        this.hasTopAdapter = true
        this.hasSideAdapter = true
    }


    run() {

        this.setValues()
     
        // BASE ADAPTER
        this.drawBaseAdapter()

        // TUBES
        for (const [key, tube] of Object.entries(this.data.mastTubes)) {
            this.drawRectangle(tube);
        }

        // DIM TEXT LINES
        for (const [key, tube] of Object.entries(this.data.mastTubes)) {
            this.drawDimTextLine(tube);
        }

        // FLANGES
        for (const [key, tube] of Object.entries(this.data.mastTubes)) {
            // this.drawFixedTubeFlange(tube);
        }

        // PAYLOAD FLANGE
        this.drawPayloadAdapter(this.data.payloadTube, this.g);

        this.drawMastCenterline()
        this.drawDimTextLineTopBottom()
        this.svg.appendChild(this.g)

        this.exportToPng()


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

        if (this.graphType === 'Loads') {
            this.totalW = (this.data.extendedHeight + 2 * this.data.zOffset) / (1 - 2 * this.MX / 100)
        }

        if (this.graphType === 'Nested') {
            this.totalH = (this.data.nestedHeight ) / (1 - 2 * this.MX / 100)
        }

        if (this.graphType === 'Extended') {
            this.totalH = (this.data.extendedHeight) / (1 - 2 * this.MX / 100)
        }

        // x,y Scales
        this.sx = this.svgW / this.totalH
        this.sy = this.svgH / this.totalH

        this.x0 = this.totalH / 3
        this.y0 = this.totalH * this.MY / 100

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

        this.gNested = document.createElementNS('http://www.w3.org/2000/svg', 'g')
        this.gExtended = document.createElementNS('http://www.w3.org/2000/svg', 'g')
        this.gLoads = document.createElementNS('http://www.w3.org/2000/svg', 'g')



    }







    drawRectangle(tube) {

        let r = document.createElementNS('http://www.w3.org/2000/svg', 'rect')

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

        r.setAttribute('x', this.sx * (this.x0 - tube.od / 2))
        r.setAttribute('y', this.sy * (this.totalH - (y + this.y0 + tube.length)))
        r.setAttribute('width', this.sx * tube.od)
        r.setAttribute('height', this.sy * tube.length)

        r.setAttribute('fill', '#EAE2B7')
        r.setAttribute('style', 'fill-opacity: .25;')
        r.setAttribute('stroke', '#28272e')
        r.setAttribute('stroke-width', '1')

        this.g.appendChild(r)
    }




    drawFixedTubeFlange(tube, parent) {

        let od = tube.od
        let height = this.data.headLength * 0.5

        let centerx = 0
        let centery = 0

        // Counterclockwise
        let points1 = [
            { "x": centerx - 0.50 * od, "y": centery },
            { "x": centerx - 0.75 * od, "y": centery },
            { "x": centerx - 0.75 * od, "y": 0.25 * height },
            { "x": centerx - 0.58 * od, "y": 0.25 * height },
            { "x": centerx - 0.58 * od, "y": height },
            { "x": centerx - 0.50 * od, "y": height },
        ]

        let points2 = [
            { "x": centerx + 0.50 * od, "y": centery },
            { "x": centerx + 0.75 * od, "y": centery },
            { "x": centerx + 0.75 * od, "y": 0.25 * height },
            { "x": centerx + 0.58 * od, "y": 0.25 * height },
            { "x": centerx + 0.58 * od, "y": height },
            { "x": centerx + 0.50 * od, "y": height },
        ]

        console.log("öncesi \n", points2)

        console.log("totalH \n", this.totalH)


        points1 = this.transformPoints(points1, true)
        points2 = this.transformPoints(points2, true)


        console.log("PPPP \n", points2)


        let r = document.createElementNS('http://www.w3.org/2000/svg', 'polygon')

        r.setAttribute('points', points1)
        r.setAttribute('fill', '#3deb11ff')
        r.setAttribute('style', 'fill-opacity: .4;')
        r.setAttribute('stroke', '#28272e')
        r.setAttribute('stroke-width', '1')

        r.setAttribute('style', 'fill-opacity: .95;')


        let r2 = document.createElementNS('http://www.w3.org/2000/svg', 'polygon')

        r2.setAttribute('points', points2)
        r2.setAttribute('fill', '#4976c9ff')
        r2.setAttribute('style', 'fill-opacity: .4;')
        r2.setAttribute('stroke', '#28272e')
        r2.setAttribute('stroke-width', '1')

        r2.setAttribute('style', 'fill-opacity: .95;')

        parent.appendChild(r)
        parent.appendChild(r2)
    }



    transformPoints(dizin, returnString = false) {

        let transformedPoints = []

        dizin.forEach(element => {

            transformedPoints.push(
                {
                    x: this.sx * (this.x0 + element.x),
                    y: this.sy * (this.totalH - (element.y + this.y0))
                }
            )
        });

        if (returnString) {
            return transformedPoints.map(point => `${point.x},${point.y}`).join(',');
        }

        return transformedPoints
    }



    drawDimTextLine(tube) {

        let offset = parseInt(this.data.maxMastTubeDia)
        let textLeaderLength = parseInt(this.data.maxMastTubeDia)

        let y

        let textValue

        switch (this.graphType) {
            case 'Extended':
                y = tube.bottomCenterPointExtended
                textValue = tube.bottomCenterPointExtended
                break;

            case 'Nested':
            default:
                y = tube.bottomCenterPointNested
                textValue = tube.bottomCenterPointNested
                break;
        }

        // BOTTOM FACE coordinates
        let l = document.createElementNS('http://www.w3.org/2000/svg', 'line')

        l.setAttribute('x1', this.sx * (this.x0 + offset))
        l.setAttribute('y1', this.sy * (this.totalH - (y + this.y0)))
        l.setAttribute('x2', this.sx * (this.x0 + offset + textLeaderLength))
        l.setAttribute('y2', this.sy * (this.totalH - (y + this.y0)))
        l.setAttribute('stroke', '#4F6D7A')
        l.setAttribute('stroke-width', '0.5')

        this.g.appendChild(l)

        let t = document.createElementNS('http://www.w3.org/2000/svg', 'text')

        t.setAttribute('x', this.sx * (this.x0 + offset + textLeaderLength) + 5)
        t.setAttribute('y', this.sy * (this.totalH - (y + this.y0)) + 5)
        t.setAttribute('font-size', "1em")
        t.innerHTML = textValue

        this.g.appendChild(t)


        // TOP FACE coordinates
        let l2 = document.createElementNS('http://www.w3.org/2000/svg', 'line')

        l2.setAttribute('x1', this.sx * (this.x0 + offset))
        l2.setAttribute('y1', this.sy * (this.totalH - (y + this.y0 + tube.length)))
        l2.setAttribute('x2', this.sx * (this.x0 + offset + textLeaderLength))
        l2.setAttribute('y2', this.sy * (this.totalH - (y + this.y0 + tube.length)))
        l2.setAttribute('stroke', '#4F6D7A')
        l2.setAttribute('stroke-width', '0.5')

        this.g.appendChild(l2)

        let t2 = document.createElementNS('http://www.w3.org/2000/svg', 'text')

        t2.setAttribute('x', this.sx * (this.x0 + offset + textLeaderLength) + 5)
        t2.setAttribute('y', this.sy * (this.totalH - (y + this.y0 + tube.length)) + 5)
        t2.setAttribute('font-size', "1em")
        t2.innerHTML = textValue + tube.length

        this.g.appendChild(t2)




    }




    drawDimTextLineTopBottom() {

        let offset = parseInt(this.data.maxMastTubeDia)
        let textLeaderLength = parseInt(this.data.maxMastTubeDia)
        let y
        let textValue

        // BOTTOM FACE coordinates
        let l = document.createElementNS('http://www.w3.org/2000/svg', 'line')

        l.setAttribute('x1', this.sx * (this.x0 - offset))
        l.setAttribute('y1', this.sy * (this.totalH - this.y0))
        l.setAttribute('x2', this.sx * (this.x0 - offset - textLeaderLength))
        l.setAttribute('y2', this.sy * (this.totalH - this.y0))
        l.setAttribute('stroke', '#4F6D7A')
        l.setAttribute('stroke-width', '0.5')

        this.g.appendChild(l)

        let t = document.createElementNS('http://www.w3.org/2000/svg', 'text')

        t.setAttribute('x', this.sx * (this.x0 - offset - textLeaderLength) - 50)
        t.setAttribute('y', this.sy * (this.totalH - this.y0 + 15))
        t.setAttribute('font-size', "1em")
        t.innerHTML = "0"

        this.g.appendChild(t)

        switch (this.graphType) {
            case 'Extended':
                y = parseInt(this.data.extendedHeight)
                textValue = parseInt(this.data.extendedHeight)
                break;

            case 'Nested':
            default:
                y = parseInt(this.data.nestedHeight)
                textValue = parseInt(this.data.nestedHeight)
                break;
        }

        // // TOP FACE coordinates
        let l2 = document.createElementNS('http://www.w3.org/2000/svg', 'line')

        l2.setAttribute('x1', this.sx * (this.x0 - offset))
        l2.setAttribute('y1', this.sy * (this.totalH - (y + this.y0)))
        l2.setAttribute('x2', this.sx * (this.x0 - offset - textLeaderLength))
        l2.setAttribute('y2', this.sy * (this.totalH - (y + this.y0)))
        l2.setAttribute('stroke', '#4F6D7A')
        l2.setAttribute('stroke-width', '0.5')

        this.g.appendChild(l2)

        let t2 = document.createElementNS('http://www.w3.org/2000/svg', 'text')

        t2.setAttribute('x', this.sx * (this.x0 - offset - textLeaderLength) - 70)
        t2.setAttribute('y', this.sy * (this.totalH - (y + this.y0 )) + 5)
        t2.setAttribute('font-size', "1em")
        t2.innerHTML = y

        this.g.appendChild(t2)
    }



    drawBaseAdapter() {

        let od = this.data.mastTubes[0].od
        let h = this.data.baseAdapterThk

        let centerx = 0
        let centery = 0

        // Counterclockwise
        let points = [
            { "x": centerx - 0.75 * od, "y": centery },
            { "x": centerx - 0.75 * od, "y": h },
            { "x": centerx - 0.58 * od, "y": h },
            { "x": centerx - 0.58 * od, "y": 5 * h },
            { "x": centerx - 0.50 * od, "y": 5 * h },
            { "x": centerx - 0.50 * od, "y": h },
            { "x": centerx + 0.50 * od, "y": h },
            { "x": centerx + 0.50 * od, "y": 5 * h },
            { "x": centerx + 0.58 * od, "y": 5 * h },
            { "x": centerx + 0.58 * od, "y": h },
            { "x": centerx + 0.75 * od, "y": h },
            { "x": centerx + 0.75 * od, "y": centery }
        ]
        console.log("oncesi", points)

        points = this.transformPoints(points, true)

        console.log("sonras", points)

        let r = document.createElementNS('http://www.w3.org/2000/svg', 'polygon')

        r.setAttribute('points', points)
        r.setAttribute('fill', '#d87d06ff')
        r.setAttribute('style', 'fill-opacity: .4;')
        r.setAttribute('stroke', '#28272e')
        r.setAttribute('stroke-width', '1')
        r.setAttribute('style', 'fill-opacity: .95;')

        this.g.appendChild(r)
    }


    drawPayloadAdapter() {

        let smallestTube = this.data.mastTubes[this.data.mastTubes.length - 1]
        let y

        switch (this.graphType) {
            case 'Extended':
                y = smallestTube.bottomCenterPointExtended
                break;

            case 'Nested':
            default:
                y = smallestTube.bottomCenterPointNested
                break;
        }

        let topLeft = { 
            x: this.x0 - smallestTube.od*1.5,
            y: this.totalH - (y + smallestTube.length + this.y0 + this.data.topAdapterThk)
        }

        let r = document.createElementNS('http://www.w3.org/2000/svg', 'rect')

        r.setAttribute('x', this.sx * topLeft.x)
        r.setAttribute('y', this.sy * topLeft.y)
        r.setAttribute('width', this.sx * smallestTube.od * 3)
        r.setAttribute('height', this.sy * this.data.topAdapterThk)

        r.setAttribute('fill', '#e6347eff')
        r.setAttribute('style', 'fill-opacity: .25;')
        r.setAttribute('stroke', '#28272e')
        r.setAttribute('stroke-width', '1')

        this.g.appendChild(r)

    }


    drawMastCenterline() {

        let l = document.createElementNS('http://www.w3.org/2000/svg', 'line')

        l.setAttribute('x1', this.sx * this.x0)
        l.setAttribute('y1', this.sy * this.totalH * this.MY / 100)
        l.setAttribute('x2', this.sx * this.x0)
        l.setAttribute('y2', this.sy * this.totalH * (1 - this.MY / 100))
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










    exportToPng(){

        console.log('son data', this.data)

        localStorage.setItem('data', JSON.stringify(this.data));

        return true;



        const girdi = document.getElementById('svg')
        // const cikti = document.getElementById('resim')

        let svgData = new XMLSerializer().serializeToString(girdi)

        if (!svgData.match(/xmlns/i)) {
            svgData = svgData.replace('<svg ', '<svg xmlns="http://www.w3.org/2000/svg" ');
        }

        const svgBlob = new Blob([svgData], { type: 'image/svg+xml;charset=utf-8' })
        const url = URL.createObjectURL(svgBlob)

        const image = new Image()

        image.onload = () => {
            console.log('Image loaded!')
            
            const width = girdi.getAttribute('width') || girdi.getBoundingClientRect().width || 800
            const height = girdi.getAttribute('height') || girdi.getBoundingClientRect().height || 600

            const canvas = document.createElement('canvas')
            canvas.width = width
            canvas.height = height

            const context = canvas.getContext('2d')
            context.drawImage(image, 0, 0, width, height)

            const dataUrl = canvas.toDataURL('image/png')
            // cikti.src = dataUrl






            canvas.toBlob((blob) => {
                const downloadUrl = URL.createObjectURL(blob)
                const link = document.createElement('a')
                link.download = 'converted-image.png' // Set filename here
                link.href = downloadUrl
                link.click()
                
                // Clean up
                URL.revokeObjectURL(downloadUrl)
            }, 'image/png')




            URL.revokeObjectURL(url) // Clean up
        }

        image.onerror = (e) => {
            console.error('Image failed to load!', e)
            URL.revokeObjectURL(url)
        }

        image.src = url
    }





}







function SILdrawCanvas(data) {

    console.log("All Data in DrawCanvas", data)

    if (document.getElementById('svg')) {
        document.getElementById('svg').remove()
    }

    let p = new CanvasClass(e.detail.data, e.detail.graphType);

    p.run()

}










