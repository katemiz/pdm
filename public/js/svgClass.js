class svgClass {

    constructor(solutionSet, solutionTubeData,currentSolution) {

        // Data

        this.solutionSet = solutionSet;
        this.solutionTubeData = solutionTubeData;
        this.currentSolution = currentSolution;

        console.log("SVG Class", this.solutionSet, this.solutionTubeData, this.currentSolution)

        // Constants
        this.X0 = 300;       // Margin in X Direction
        this.Y0 = 300;       // Margin in Y Direction

        // Canvas scale
        this.scale = 1;       // Scale

        this.setValues()
        this.draw()
    }


    setValues() {

        this.container = document.getElementById('myDiv')
        this.svg = document.getElementById('svg')

        this.svgWidth = this.container.clientWidth - window.getComputedStyle(this.container).paddingLeft.replace('px', '') - window.getComputedStyle(this.container).paddingRight.replace('px', '')
        this.svgHeight = this.svgWidth

        this.svg.setAttribute('width', this.svgWidth)
        this.svg.setAttribute('height', this.svgWidth)

        this.svg.setAttribute('viewBox', '0 0 '+this.svgWidth+' '+this.svgWidth);

        this.x0 = this.svgWidth / 2
        this.y0 = this.svgHeight / 2

        this.scale = this.svgHeight / (this.solutionSet[this.currentSolution].extendedHeight * 2.44);  

        let bg = document.createElementNS('http://www.w3.org/2000/svg', 'rect')

        bg.setAttribute('width', this.svgWidth)
        bg.setAttribute('height', this.svgWidth)
        bg.setAttribute('fill', 'grey')

        bg.setAttribute('style', 'fill-opacity: .25;')

        this.svg.appendChild(bg)
    }



    draw() {

        let h = 50

        this.x0 = this.svgWidth * 0.75
        this.y0 = this.svgHeight * 0.98

        let x1, y1, x2, y2, x3, y3, x4, y4,dx

        x1 = this.x0
        y1 = this.y0


        let txe = 500
        let tye = 100

        let txn = 800
        let tyn = 100

        for (const [key, profile] of Object.entries(this.solutionTubeData)) {
            // console.log(`${key}: ${profile}`);

            // console.log("key", key, profile)

            this.drawPath(profile.extended.A.x, profile.extended.A.y, profile.extended.B.x, profile.extended.B.y, profile.extended.C.x, profile.extended.C.y, profile.extended.D.x, profile.extended.D.y, txe, tye)


            this.drawPath(profile.nested.A.x, profile.nested.A.y, profile.nested.B.x, profile.nested.B.y, profile.nested.C.x, profile.nested.C.y, profile.nested.D.x, profile.nested.D.y, txn, tyn)


        }











        this.drawLine(this.x0, 0, this.y0 , this.svgHeight)
    }


    drawText(x, y, text) {

        let t = document.createElementNS('http://www.w3.org/2000/svg', 'text')

        t.setAttribute('x', x + 100)
        t.setAttribute('y', y)
        t.innerHTML = text

        this.svg.appendChild(t)
    }




    drawRectangle(w, h, x, y) {

        w = this.scaleParameter(w)
        h = this.scaleParameter(h)
        x = this.scaleParameter(x)
        y = this.scaleParameter(y)

        let r = document.createElementNS('http://www.w3.org/2000/svg', 'rect')

        r.setAttribute('x', x)
        r.setAttribute('y', y)
        r.setAttribute('width', w)
        r.setAttribute('height', h)

        r.setAttribute('fill', 'yellow')
        r.setAttribute('stroke', 'oklch(0.9 0.3 164)')
        r.setAttribute('stroke-width', '2')

        this.svg.appendChild(r)
    }




    drawLine(x1, y1, x2, y2) {

        x1 = this.scaleParameter(x1)
        y1 = this.scaleParameter(y1)
        x2 = this.scaleParameter(x2)
        y2 = this.scaleParameter(y2)

        console.log("Drawing line",x1, y1, x2, y2)

        let l = document.createElementNS('http://www.w3.org/2000/svg', 'line')

        l.setAttribute('x1', x1)
        l.setAttribute('y1', y1)
        l.setAttribute('x2', x2)
        l.setAttribute('y2', y2)
        l.setAttribute('stroke', 'oklch(0.9 0.3 164)')
        l.setAttribute('stroke-width', '2')

        l.setAttribute('transform', 'translate(50,0)');

        this.svg.appendChild(l)
    }


    drawPath(x1, y1, x2, y2, x3, y3, x4, y4,tx, ty) {


        x1 = this.scaleParameter(x1)
        y1 = this.scaleParameter(y1)
        x2 = this.scaleParameter(x2)
        y2 = this.scaleParameter(y2)
        x3 = this.scaleParameter(x3)
        y3 = this.scaleParameter(y3)
        x4 = this.scaleParameter(x4)
        y4 = this.scaleParameter(y4)

        x1 += tx
        y1 += ty
        x2 += tx
        y2 += ty
        x3 += tx
        y3 += ty
        x4 += tx
        y4 += ty



        let p = document.createElementNS('http://www.w3.org/2000/svg', 'path')

        p.setAttribute('d', 'M ' + x1 + ',' + y1 + ' L ' + x2 + ',' + y2 + ' L ' + x3 + ',' + y3 + ' L ' + x4 + ',' + y4 + ' Z')
        p.setAttribute('fill', 'red')
        // p.setAttribute('stroke', 'oklch(0.9 0.3 164)')
        p.setAttribute('stroke-width', '2')

        this.svg.appendChild(p)
    }


    scaleParameter(val) {
        return val * this.scale
    }

}

















