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

        this.mx = 100; // px
        this.my = 100; // px


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

        this.extendedHeight = this.solutionSet[this.currentSolution].extendedHeight
        this.nestedHeight = this.solutionSet[this.currentSolution].nestedHeight
        this.scaleN = (this.svgHeight - 2 * this.my) / (this.nestedHeight );


        console.log("nested height", this.nestedHeight, this.extendedHeight, this.svgHeight, this.scaleN)

        let bg = document.createElementNS('http://www.w3.org/2000/svg', 'rect')

        bg.setAttribute('width', this.svgWidth)
        bg.setAttribute('height', this.svgWidth)
        bg.setAttribute('fill', 'grey')

        bg.setAttribute('style', 'fill-opacity: .25;')

        this.svg.appendChild(bg)


        this.gE = document.createElementNS('http://www.w3.org/2000/svg', 'g')
        this.gN = document.createElementNS('http://www.w3.org/2000/svg', 'g')
        this.gT = document.createElementNS('http://www.w3.org/2000/svg', 'g')



        // this.g.setAttribute('transform', 'translate(100, 150) scale(2) translate(-100, -150)')
        // this.g.setAttribute('transform', 'translate(700, 700) scale(0.1) translate(-700, -700)')
        // this.gE.setAttribute('transform', 'translate(200, 200) scale(0.5) ')

        this.X0 = this.svgWidth /3
        this.Y0 = this.svgHeight - this.my
        this.gN.setAttribute('transform', ' translate('+this.X0+','+this.Y0+') scale('+this.scaleN+') rotate(180)')

        this.gT.setAttribute('transform', ' translate('+this.X0+',0) ')


                                // this.g.setAttribute('transform', 'scale(0.16) ')


// rotate(180,'+this.svgWidth/2+',1150)

// scale('+this.scaleN+')


        this.svg.appendChild(this.gE)
        this.svg.appendChild(this.gN)
        this.svg.appendChild(this.gT)





    }



    draw() {

        // this.drawRectangle(1300, 1300, 300, 300)
        // this.drawRectangle(300, 300, 300, 300, this.gE)


        let txe = this.extendedHeight * 0.25
        let tye = this.extendedHeight * 0.9

        let txn = this.extendedHeight * 0.75
        let tyn = tye


        this.drawNestedLegend()

        console.log("extended height w h txe tye txn tyn",this.extendedHeight,this.svgWidth, this.svgHeight, txe, tye, txn, tyn)


        for (const [key, profile] of Object.entries(this.solutionTubeData)) {

            // console.log(`${key}: ${profile}`);
            // console.log("key", key, profile)

            console.log("profile extended", profile.extended)
            console.log("profile nested", profile.nested)

            // this.drawPath(profile.extended.A.x, profile.extended.A.y, profile.extended.B.x, profile.extended.B.y, profile.extended.C.x, profile.extended.C.y, profile.extended.D.x, profile.extended.D.y, txe, tye,'extended');
            // this.drawPath(profile.nested.A.x, profile.nested.A.y, profile.nested.B.x, profile.nested.B.y, profile.nested.C.x, profile.nested.C.y, profile.nested.D.x, profile.nested.D.y, this.gN);


            this.drawRectangle(profile.od, profile.length, profile.nested.A.x, profile.nested.A.y, this.gN);
            this.drawText(0, profile.nested.A.y , profile.nested.A.y);

            this.drawText(0, profile.nested.D.y , profile.nested.D.y);



            // this.drawRectangle(this.solutionTubeData[0].extended.od , this.solutionTubeData[0].extended.length,0,0 ,this.gE)
        }

        this.drawLine(0,0 , 0, this.nestedHeight)

    }




    drawNestedLegend(){


        let header = document.createElementNS('http://www.w3.org/2000/svg', 'text')

        header.setAttribute('x', this.svgWidth * 0.7)
        header.setAttribute('y', 100)
        header.setAttribute('font-size', 32)
        header.setAttribute('fill', 'black')
        header.innerHTML = 'Nested Position'

        this.svg.appendChild(header)

        let k = 1

        for (const [key, profile] of Object.entries(this.solutionTubeData)) {
            let t = document.createElementNS('http://www.w3.org/2000/svg', 'text')

            t.setAttribute('x', this.svgWidth * 0.7)
            t.setAttribute('y', 150 + key * 30)
            t.setAttribute('font-size', 24)
            t.setAttribute('fill', 'black')
            t.innerHTML = 'Section ' + k + ' - ' + profile.od.toFixed(2) + ' mm '

            this.svg.appendChild(t)
            k++
        }

    }    


    drawText(x, y, text) {

        y = this.svgHeight - (y*this.scaleN + this.my)


        let l = document.createElementNS('http://www.w3.org/2000/svg', 'line')

        l.setAttribute('x1', x+100)
        l.setAttribute('y1', y)
        l.setAttribute('x2', x+200)
        l.setAttribute('y2', y)
        l.setAttribute('stroke', '#4F6D7A')
        l.setAttribute('stroke-width', '1')

        this.gT.appendChild(l)




        let t = document.createElementNS('http://www.w3.org/2000/svg', 'text')

        t.setAttribute('x', x + 220)
        t.setAttribute('y', y)
        t.innerHTML = text

        this.gT.appendChild(t)
    }




    drawRectangle(w, h, x, y, parent) {

        let r = document.createElementNS('http://www.w3.org/2000/svg', 'rect')

        r.setAttribute('x', x)
        r.setAttribute('y', y)
        r.setAttribute('width', w)
        r.setAttribute('height', h)

        r.setAttribute('fill', '#EAE2B7')
        r.setAttribute('style', 'fill-opacity: .2;')
        r.setAttribute('stroke', '#4F6D7A')
        r.setAttribute('stroke-width', '2')

        parent.appendChild(r)
    }




    drawLine(x1, y1, x2, y2) {

        // x1 = this.scaleParameter(x1)
        // y1 = this.scaleParameter(y1)
        // x2 = this.scaleParameter(x2)
        // y2 = this.scaleParameter(y2)

        console.log("Drawing line",x1, y1, x2, y2)

        let l = document.createElementNS('http://www.w3.org/2000/svg', 'line')

        l.setAttribute('x1', x1)
        l.setAttribute('y1', y1)
        l.setAttribute('x2', x2)
        l.setAttribute('y2', y2)
        l.setAttribute('stroke', 'rgb(100, 0, 0)')
        l.setAttribute('stroke-width', '10')


        this.gN.appendChild(l)
    }


    drawPath(x1, y1, x2, y2, x3, y3, x4, y4,parent) {

        // x1,y1 = this.translatePoint(x1,y1).x, this.translatePoint(x1,y1).y
        // x2,y2 = this.translatePoint(x2,y2).x, this.translatePoint(x2,y2).y
        // x3,y3 = this.translatePoint(x3,y3).x, this.translatePoint(x3,y3).y
        // x4,y4 = this.translatePoint(x4,y4).x, this.translatePoint(x4,y4).y




        console.log(" AA x1 y1 x2 y2 x3 y3 x4 y4",x1, y1, x2, y2, x3, y3, x4, y4)




        let p = document.createElementNS('http://www.w3.org/2000/svg', 'path')

        p.setAttribute('d', 'M ' + x1 + ',' + y1 + ' L ' + x2 + ',' + y2 + ' L ' + x3 + ',' + y3 + ' L ' + x4 + ',' + y4 + ' Z')
        p.setAttribute('fill', '#7699D4')
        p.setAttribute('stroke', 'rgb(0, 0, 0)')
        p.setAttribute('stroke-width', '2')


        parent.appendChild(p)

    }




    translatePoint(x, y) {

        console.log("Translating point",x,y)


        let result = {
            x: x + this.extendedHeight * 0.75 + x,
            y: this.extendedHeight - (y + this.extendedHeight * 0.9)
        }


        console.log("Translated point",result.x,result.y)
        return result;
    }

}

















