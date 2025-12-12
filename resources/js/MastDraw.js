export default class MastDraw {

    constructor(data, svgId) {

        console.log('MastDrawClass start:', data, svgId)

        //console.log('Critical Load:', data.startTubeNo, data.endTubeNo, data.mastTubes)

        // Data
        this.data = data
        this.svgId = svgId

        // Constants
        this.MX = 3;       // % Margin in X Direction
        this.MY = 3;       // % Margin in X Direction

        this.R = 6;        // DIA OF REFERENCE CIRCLES

        switch (this.svgId) {

            default:
            case 'Nested':
                this.coefficient = 0.495
                this.divId = 'divSvgNested'
                break;

            case 'Extended':
                this.coefficient = 0.695
                this.divId = 'divSvgExtended'
                break;

            case 'Loads':
                this.coefficient = 0.695
                this.divId = 'divSvgLoads'
                break;


            case 'Capacity':
                this.coefficient = 0.495
                this.divId = 'divChartCapacity'
                break;

        }

        this.totalH;
        this.containerDiv = document.getElementById('svgDivs');
    }


    run() {

        this.setValues()

        // BASE ADAPTER
        this.drawBaseAdapter()

        // TUBES
        this.data.mastTubes.forEach(tube => {
            this.drawRectangle(tube);
        });

        // GUYINGS
        if (this.svgId === 'Extended'||  this.svgId === 'Loads') {
            this.data.mastTubes.forEach(tube => {
                this.drawGuying(tube);
            });
        } 

        // DIM TEXT LINES
        this.data.mastTubes.forEach(tube => {
            this.drawDimTextLine(tube);
        });

        // FLANGES
        this.data.mastTubes.forEach(tube => {
            // this.drawFixedTubeFlange(tube);
        });

        // PAYLOAD FLANGE
        this.drawPayloadAdapter(this.data.payloadTube, this.g);

        this.drawMastCenterline()
        this.drawDimTextLineTopBottom()
        this.svg.appendChild(this.g)


        // LOADS
        if (this.svgId === 'Loads') {
            this.drawLoadArrows()
        } 

        localStorage.setItem('data', JSON.stringify(this.data))

        // this.svgToPng();
        this.svgToPng('NestedSvg');
        this.svgToPng('ExtendedSvg');
    }


    setValues() {

        const elId = this.svgId + 'Svg';

        if (document.getElementById(elId)) {
            document.getElementById(elId).remove();
        }

        // CREATE SVG ELEMENT
        this.svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
        this.svg.id = elId;

        // CONTAINER AND SVG ELEMENT
        this.div = document.getElementById(this.divId)

        this.div.appendChild(this.svg)

        this.svgW = this.containerDiv.clientWidth - window.getComputedStyle(this.containerDiv).paddingLeft.replace('px', '') - window.getComputedStyle(this.containerDiv).paddingRight.replace('px', '')
        this.svgH = this.svgW

        this.svg.setAttribute('width', this.svgW)
        this.svg.setAttribute('height', this.svgH)

        if (this.svgId === 'Loads') {
            this.totalW = (this.data.extendedHeight + 2 * this.data.zOffset) / (1 - 2 * this.MX / 100)
            this.totalH = (this.data.extendedHeight) / (1 - 2 * this.MX / 100)
        }

        if (this.svgId === 'Nested') {
            this.totalH = (this.data.nestedHeight) / (1 - 2 * this.MX / 100)
        }

        if (this.svgId === 'Extended') {
            this.totalH = (this.data.extendedHeight) / (1 - 2 * this.MX / 100)
        }

        // x,y Scales
        this.sx = this.svgW / this.totalH
        this.sy = this.svgH / this.totalH

        this.x0 = this.totalH * this.coefficient
        this.y0 = this.totalH * this.MY / 100

        this.g = document.createElementNS('http://www.w3.org/2000/svg', 'g')
    }





    drawRectangle(tube) {

        let r = document.createElementNS('http://www.w3.org/2000/svg', 'rect')

        let y

        switch (this.svgId) {

            case 'Loads':
            case 'Extended':
                y = tube.bottomCenterPointExtended
                break;

            case 'Nested':
            default:
                y = tube.bottomCenterPointNested
                break;
        }

        r.setAttribute('x', this.sx * (this.x0 - tube.od / 2))
        r.setAttribute('y', this.sy * (this.totalH - (y + this.y0 + parseInt(tube.length))))
        r.setAttribute('width', this.sx * tube.od)
        r.setAttribute('height', this.sy * parseInt(tube.length))

        r.setAttribute('fill', '#b8b6b1ff')
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


    drawLoadArrows(){


        // Length of tube is ASSUMED to be equal to maximum load value.
        let factor = this.data.tubeLength / (this.data.windLoadOnPayload)

        let l = document.createElementNS('http://www.w3.org/2000/svg', 'line')

        l.setAttribute('x1', this.getSvgX(0))
        l.setAttribute('y1', this.getSvgY(this.data.extendedHeight+this.data.zOffset))
        l.setAttribute('x2', this.getSvgX(-this.data.windLoadOnPayload * factor))
        l.setAttribute('y2', this.getSvgY(this.data.extendedHeight+this.data.zOffset))

        l.setAttribute('stroke', '#cc1f45ff')
        l.setAttribute('stroke-width', '1.5')

        this.g.appendChild(l)



        // let arrowLength = 0.1 * this.data.windLoadOnPayload



        // this.g.beginPath();
        // this.g.moveTo(this.getSvgX(0), this.getSvgY(this.data.extendedHeight+this.data.zOffset));
        // this.g.lineTo(this.getSvgX(-arrowLength), this.getSvgY(this.data.extendedHeight+this.data.zOffset - arrowLength));
        // this.g.lineTo(this.getSvgX(-arrowLength), this.getSvgY(this.data.extendedHeight+this.data.zOffset + arrowLength));

        // //this.g.lineWidth = arrowWidth;
        // this.g.stroke();






        this.data.mastTubes.forEach(tube => {
            
            let l = document.createElementNS('http://www.w3.org/2000/svg', 'line')

            l.setAttribute('x1', this.getSvgX(0))
            l.setAttribute('y1', this.getSvgY(tube.windLoadActingZ))
            l.setAttribute('x2', this.getSvgX(-tube.windForce * factor))
            l.setAttribute('y2', this.getSvgY(tube.windLoadActingZ))

            l.setAttribute('stroke', '#cc1f45ff')
            l.setAttribute('stroke-width', '1.5')

            //console.log('drawing load arrows',tube['od'] ,tube['bottomCenterPointExtended'])

            this.g.appendChild(l)
        });



    } 

    drawDimTextLine(tube) {

        let offset = parseInt(this.data.maxMastTubeDia)
        let textLeaderLength = parseInt(this.data.maxMastTubeDia)

        let y

        let textValue

        tube.length = parseInt(tube.length)

        switch (this.svgId) {

            case 'Loads':
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
        let textValue = 'Initial Value'

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

        switch (this.svgId) {
            case 'Extended':
            case 'Loads':
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
        t2.setAttribute('y', this.sy * (this.totalH - (y + this.y0)) + 5)
        t2.setAttribute('font-size', "1em")
        t2.innerHTML = y

        this.g.appendChild(t2)
    }



    drawBaseAdapter() {

        let od = this.data.mastTubes[0].od
        let h = parseInt(this.data.baseAdapterThk)

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
        // console.log("oncesi", points)

        points = this.transformPoints(points, true)

        // console.log("sonras", points)

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

        switch (this.svgId) {
            case 'Extended':
                y = smallestTube.bottomCenterPointExtended
                break;

            case 'Nested':
            default:
                y = smallestTube.bottomCenterPointNested
                break;
        }

        let topLeft = {
            x: this.x0 - smallestTube.od * 0.75,
            y: this.totalH - (y + parseInt(smallestTube.length) + this.y0 + this.data.topAdapterThk)
        }

        let r = document.createElementNS('http://www.w3.org/2000/svg', 'rect')

        r.setAttribute('x', this.sx * topLeft.x)
        r.setAttribute('y', this.sy * topLeft.y)
        r.setAttribute('width', this.sx * smallestTube.od * 1.5)
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




    drawGuying(tube) { 

        let r = document.createElementNS('http://www.w3.org/2000/svg', 'line')

        const x1 = this.x0 - tube.od / 2
        const y1 = this.totalH - (tube.bottomCenterPointExtended + this.y0 + parseInt(tube.length))
        const y2 = this.totalH - (this.y0)  

        const x2 = this.totalH * 0.1

        r.setAttribute('x1', this.sx * x1)
        r.setAttribute('y1', this.sy * y1)
        r.setAttribute('x2', this.sx * x2)
        r.setAttribute('y2', this.sy * y2)

        r.setAttribute('stroke', '#929194ff')
        r.setAttribute('stroke-width', '0.8')

        this.g.appendChild(r)
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





















    svgToPng(elId) {

        let svgElement = document.getElementById(elId)
        let imgId = elId + 'Image'

        if (svgElement === null) {
            return true;
        }

        // console.log('SVG to PNG:', svgElement, imgId, typeof svgElement)

        return new Promise((resolve, reject) => {

            // 1. Serialize and Fix Namespace
            let svgData = new XMLSerializer().serializeToString(svgElement);
            if (!svgData.match(/xmlns/i)) {
                svgData = svgData.replace('<svg ', '<svg xmlns="http://www.w3.org/2000/svg" ');
            }

            // 2. Create Loadable Image Source
            const svgBlob = new Blob([svgData], { type: 'image/svg+xml;charset=utf-8' });
            const url = URL.createObjectURL(svgBlob);
            const image = new Image();

            // --- Core Asynchronous Logic ---
            image.onload = () => {
                try {
                    // Determine dimensions for the Canvas (for best quality, match source size)
                    const canvasWidth = svgElement.getAttribute('width') || svgElement.getBoundingClientRect().width || 800;
                    const canvasHeight = svgElement.getAttribute('height') || svgElement.getBoundingClientRect().height || 600;

                    // 3. Draw to Canvas and Get PNG Data
                    const canvas = document.createElement('canvas');
                    canvas.width = canvasWidth;
                    canvas.height = canvasHeight;

                    const context = canvas.getContext('2d');
                    context.drawImage(image, 0, 0, canvasWidth, canvasHeight);

                    // Get the final PNG data URL
                    const dataUrl = canvas.toDataURL('image/png');



                    // console.log("Sonuc ", x, y, width, height)

                    document.getElementById(imgId).src = dataUrl


                    // Clean up the temporary URL
                    URL.revokeObjectURL(url);

                    resolve(); // Operation successful
                } catch (error) {
                    URL.revokeObjectURL(url);
                    reject(error);
                }
            };

            image.onerror = (error) => {
                URL.revokeObjectURL(url);
                reject(new Error('Failed to load SVG image source.'));
            };

            // Trigger the image loading process
            image.src = url;
        });
    }







    getSvgX(x){

        let result = this.sx * ( this.x0 + x)

        //console.log('X',result)
        return result
    } 

    getSvgY(y){

        let result = this.sy * (this.totalH - (y + this.y0))
        //console.log('y = > Y',y,result,this.totalH,this.y0)

        return result
    } 








}