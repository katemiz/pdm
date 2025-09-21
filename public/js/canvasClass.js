class CanvasClass {

    constructor(data) {


        this.tubes = [

            {
                "od": 200,
                "thk": 10,
                "length": 500
            },
            {
                "od": 180,
                "thk": 10,
                "length": 500
            },
            {
                "od": 160,
                "thk": 10,
                "length": 500
            },
            {
                "od": 140,
                "thk": 10,
                "length": 500
            }
        ]




        // Data
        this.data = data

        // Constants
        this.X0 = 300;       // Margin in X Direction
        this.Y0 = 300;       // Margin in X Direction





        // this.c = this.svgEl
        // this.g = this.c.getContext("2d");

        this.setValues()
        this.draw()
    }


    setValues() {


        this.container = document.getElementById('myDiv')
        this.svg = document.getElementById('svg')

        this.svg.setAttribute('width', this.container.offsetWidth)
        this.svg.setAttribute('height', this.container.offsetHeight)

        this.svg.setAttribute('height', 880)

        this.x0 = this.container.offsetWidth / 2
        this.y0 = this.container.offsetHeight - 30



        let bg = document.createElementNS('http://www.w3.org/2000/svg', 'rect')

        bg.setAttribute('width', this.container.offsetWidth)
        bg.setAttribute('height', this.container.offsetHeight)
        bg.setAttribute('fill', 'green')


        this.svg.appendChild(bg)



        console.log(this.container.offsetHeight, this.container.offsetWidth)





    }



    draw() {



        let h = 50
        let i = 0

        let x, y


        this.tubes.forEach(element => {

            console.log(element)

            x = this.x0 - element.od / 2
            y = this.x0 - element.length + i * h

            this.drawRectangle(element.od, element.length, x, y)
            this.drawText(x, y, y)
            this.drawLine(this.x0 + 200, y, this.x + 400, y)
            i++


        });

    }

    drawText(x, y, text) {

        let t = document.createElementNS('http://www.w3.org/2000/svg', 'text')

        t.setAttribute('x', x + 100)
        t.setAttribute('y', y)
        t.innerHTML = text

        this.svg.appendChild(t)
    }




    drawRectangle(w, h, x, y) {

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







}

















