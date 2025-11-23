class svgClass {

    constructor(solutionSet, solutionTubeData, currentSolution, svgType, adapters) {

        this.solutionSet = solutionSet;
        this.solutionTubeData = solutionTubeData;
        this.currentSolution = currentSolution;

        this.adapters = adapters

        this.my = 100; // px

        this.x0
        this.y0

        this.scale = 1
        this.svgType = svgType
        this.k = 1 // coefficient for diameter correction

        this.svgH
        this.svgW

        this.mastHeight

        this.hasBaseAdapter = true
        this.hasTopAdapter = true
        this.hasSideAdapter = true
    }


    run() {
        this.setValues()
        this.drawMastTubes()
        this.drawMastCenterline()

    }


    setValues() {

        // CREATE SVG ELEMENT

        this.svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');

        // this.svg = document.createElement('svg')
        this.svg.id = 'svg'

        // CONTAINER AND SVG ELEMENT
        this.div = document.getElementById('svgDiv')
        // this.svg = document.getElementById('svg')

        this.div.appendChild(this.svg)

        this.svgW = this.div.clientWidth - window.getComputedStyle(this.div).paddingLeft.replace('px', '') - window.getComputedStyle(this.div).paddingRight.replace('px', '')
        this.svgH = this.svgW

        this.svg.setAttribute('width', this.svgW)
        this.svg.setAttribute('height', this.svgH)

        if (this.svgType === 'Nested') {
            this.mastHeight = this.solutionSet[this.currentSolution].nestedHeight
        }

        if (this.svgType === 'Extended') {
            this.mastHeight = this.solutionSet[this.currentSolution].extendedHeight
        }

        this.scale = (this.svgH - 2 * this.my) / (this.mastHeight);

        this.x0 = this.svgW / 3
        this.y0 = this.svgH - this.my

        // SVG BACKGROUND RECTANGLE
        let bg = document.createElementNS('http://www.w3.org/2000/svg', 'rect')

        bg.setAttribute('width', this.svgW)
        bg.setAttribute('height', this.svgW)
        bg.setAttribute('fill', '#dedede')

        bg.setAttribute('style', 'fill-opacity: .25;')

        this.svg.appendChild(bg)
    }


    drawMastTubes() {

        // MAST GROUP AND TUBES RECTANGLES
        this.g = document.createElementNS('http://www.w3.org/2000/svg', 'g')

        this.g.setAttribute('transform', ' translate(' + this.x0 + ',' + this.y0 + ') scale(' + this.scale + ') rotate(180)')

        switch (true) {

            case (this.mastHeight < 3000):
                this.k = 1
                break;

            case (this.mastHeight < 8000 && this.mastHeight >= 3000):
                this.k = 2
                break;

            case (this.mastHeight < 12000 && this.mastHeight >= 8000):
                this.k = 3
                break;

            case (this.mastHeight < 16000 && this.mastHeight >= 12000):
                this.k = 4
                break;

            case (this.mastHeight >= 16000):
                this.k = 5
                break;
        }

        for (const [key, profile] of Object.entries(this.solutionTubeData)) {

            if (this.svgType === 'Nested') {
                this.drawRectangle(profile.od, profile.length, profile.nested.A.x, profile.nested.A.y, this.g);
            }

            if (this.svgType === 'Extended') {
                this.drawRectangle(profile.od * this.k, profile.length, profile.extended.A.x * this.k, profile.extended.A.y, this.g);
            }
        }

        this.svg.appendChild(this.g)

        this.drawAdapters(this.g, 'base')
        this.drawAdapters(this.g, 'top')
        // this.drawAdapters(this.g, 'side')

        this.drawTextAndDims()

        this.drawBaseAdapter(this.g)

    }


    drawMastCenterline() {

        let l = document.createElementNS('http://www.w3.org/2000/svg', 'line')

        l.setAttribute('x1', this.x0)
        l.setAttribute('y1', this.my / 2)
        l.setAttribute('x2', this.x0)
        l.setAttribute('y2', this.svgH - this.my / 2)
        l.setAttribute('stroke', 'rgb(100, 0, 0)')
        l.setAttribute('stroke-width', '0.1')

        this.svg.appendChild(l)
    }


    drawTextAndDims() {

        let g = document.createElementNS('http://www.w3.org/2000/svg', 'g')

        // g.setAttribute('transform', ' translate(' + this.x0 + ',' + this.y0 + ') scale(' + this.scale + ') rotate(180)')
        this.svg.appendChild(g)

        for (const [key, profile] of Object.entries(this.solutionTubeData)) {

            if (this.svgType === 'Nested') {

                this.drawDimTextLine(this.x0, profile.nested.D.y, profile.nested.D.y, g);
                this.drawDimTextLine(this.x0, profile.nested.A.y, profile.nested.A.y, g);
            }

            if (this.svgType === 'Extended') {
                this.drawDimTextLine(this.x0, profile.extended.D.y, profile.extended.D.y, g);
                this.drawDimTextLine(this.x0, profile.extended.A.y, profile.extended.A.y, g);
            }
        }

        // Top Adapter Dim-Text


        // Base Adapter Dim-Text
        this.drawDimTextLine(this.x0, this.adapters.base.points.Nested.A.y, this.adapters.base.points.Nested.A.y, g);



    }


    drawDimTextLine(x, y, text, parent) {

        y = this.svgH - (y * this.scale + this.my)

        let l = document.createElementNS('http://www.w3.org/2000/svg', 'line')

        l.setAttribute('x1', x + 100)
        l.setAttribute('y1', y)
        l.setAttribute('x2', x + 200)
        l.setAttribute('y2', y)
        l.setAttribute('stroke', '#4F6D7A')
        l.setAttribute('stroke-width', '2')

        parent.appendChild(l)

        let t = document.createElementNS('http://www.w3.org/2000/svg', 'text')

        t.setAttribute('x', x + 220)
        t.setAttribute('y', y)
        t.innerHTML = text

        parent.appendChild(t)
    }

    drawRectangle(w, h, x, y, parent) {

        let r = document.createElementNS('http://www.w3.org/2000/svg', 'rect')

        r.setAttribute('x', x)
        r.setAttribute('y', y)
        r.setAttribute('width', w)
        r.setAttribute('height', h)

        r.setAttribute('fill', '#EAE2B7')
        r.setAttribute('style', 'fill-opacity: .25;')
        r.setAttribute('stroke', '#28272e')
        r.setAttribute('stroke-width', '8')

        parent.appendChild(r)
    }











    drawAdapters(parent, adapterType) {

        // adapterType : base,top,side

        if (!this.hasBaseAdapter) {
            return true;
        }

        let points = this.adapters[adapterType].points

        points = points[this.svgType]

        let r = document.createElementNS('http://www.w3.org/2000/svg', 'rect')

        r.setAttribute('x', points.D.x)
        r.setAttribute('y', points.D.y)
        r.setAttribute('width', points.C.x - points.D.x)
        r.setAttribute('height', points.D.y - points.A.y)

        r.setAttribute('fill', '#3deb11ff')
        r.setAttribute('style', 'fill-opacity: .4;')
        r.setAttribute('stroke', '#28272e')
        r.setAttribute('stroke-width', '4')

        r.setAttribute('style', 'fill-opacity: .95;')

        parent.appendChild(r)
    }







    drawBaseAdapter(parent, adapterType) {

        let od = 200
        let h = 10

        let x0 = 300
        let y0 = 300

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




        // let points = this.adapters[adapterType].points

        // points = points[this.svgType]

        let r = document.createElementNS('http://www.w3.org/2000/svg', 'polygon')

        r.setAttribute('points', points)


        r.setAttribute('fill', '#3deb11ff')
        r.setAttribute('style', 'fill-opacity: .4;')
        r.setAttribute('stroke', '#28272e')
        r.setAttribute('stroke-width', '4')

        r.setAttribute('style', 'fill-opacity: .95;')

        parent.appendChild(r)
    }


    drawFixedTubeFlange(parent, adapterType) {

        let od = 200
        let h = 10

        let x0 = 300
        let y0 = 300

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




        // let points = this.adapters[adapterType].points

        // points = points[this.svgType]

        let r = document.createElementNS('http://www.w3.org/2000/svg', 'polygon')

        r.setAttribute('points', points)


        r.setAttribute('fill', '#3deb11ff')
        r.setAttribute('style', 'fill-opacity: .4;')
        r.setAttribute('stroke', '#28272e')
        r.setAttribute('stroke-width', '4')

        r.setAttribute('style', 'fill-opacity: .95;')

        parent.appendChild(r)
    }







    // <polygon
    //     points="
    //     60,100
    //     100,180
    //     140,140
    //     180,180
    //     220,100
    //   "
    // />



}

















