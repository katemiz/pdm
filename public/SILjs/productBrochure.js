export default class PdfBrochure {

    constructor(data) {

        this.data = data
        this.pdf = new jsPDF();

        // console.log(this.pdf.getFontList())

        // console.log('this is the data', this.data)

        this.mx = 16
        this.my = 12

        this.qrs = 25

        this.pageWidth;
        this.pageHeight;

        this.logoImage

        this.qrCodeImage = null  // Store QR code here

        this.props = [
            { name: 'a1', text: ['Increased Payload Capacity', 'with new tubes and steel wires'] },
            { name: 'a3', text: ['Aluminium Stiffened Profiles', 'for low twist and deflection'] },
            { name: 'a4', text: ['AC/DC Motor Driven', 'Pulley System'] },
            { name: 'a2', text: ['New patented low friction', 'slide mechanism'] },
            { name: 'a5', text: ['Bigger extended heights', 'up to 25m'] },
        ]

        this.mastCode = (this.data.extendedHeight / 1000).toFixed(0) + 'MTWR-' + (this.data.nestedHeight / 1000).toFixed(1) + '-' + this.data.mastTubes.length
    }


    // Pre-generate QR code before running
    async init() {
        this.qrCodeImage = await QRCode.toDataURL(this.data.qr, {
            width: 160,
            margin: 1
        });

        if (this.dotIcon) {
            const svgElement = document.getElementById(this.dotIcon);
            if (svgElement) {
                // Get PNG data directly
                this.logoImage = await this.svgToPngData(svgElement, 2);
            }
        }
    }


    async renderSvgToCanvas(svg) {

        // const canvas = document.createElement('canvas');
        const canvas = document.getElementById('svg');

        // canvas.width = 300;
        // canvas.height = 300;

        const ctx = canvas.getContext('2d');
        const v = await Canvg.from(ctx, svg);
        await v.render();
        return canvas;
    }




    run() {

        this.coverPage()
        this.propertiesPage()

        this.dimensionPages('nested')
        this.dimensionPages('extended')

        this.pdf.save(this.mastCode + '.pdf');
    }


    coverPage() {

        this.pageWidth = this.pdf.internal.pageSize.getWidth()
        this.pageHeight = this.pdf.internal.pageSize.getHeight()

        this.pdf.setFillColor(204, 204, 204); // RGB: light orange
        this.pdf.rect(0, 0, this.pageWidth, this.pageHeight, 'F');

        const imgWidth = 86

        this.pdf.setFillColor(104, 104, 24); // RGB: light orange
        this.pdf.rect(this.pageWidth - this.mx - imgWidth, this.my, imgWidth, this.pageHeight - 2 * this.my, 'F');

        // console.log(imgWidth, this.pageHeight - 2 * this.my)

        this.pdf.addImage(document.getElementById('resim'), 'PNG', this.pageWidth - this.mx - imgWidth, this.my, 86, 273);

        this.addHeaderFooter()

        this.pdf.setFontSize(96);

        this.pdf.setFont('helvetica', 'bold');
        this.pdf.text('MTWR', this.mx, this.pageHeight * 0.27);

        this.pdf.setFontSize(24);

        this.pdf.setFont('courier', 'normal');
        this.pdf.text(this.mastCode, this.mx, this.pageHeight * 0.27 + 10);

        this.addQrCode()

        const imgS = 12

        let y = 120
        const gap = 20


        this.pdf.setFontSize(14);

        for (const [key, element] of Object.entries(this.props)) {

            this.pdf.setFillColor(255, 255, 255);

            this.pdf.rect(this.mx, y, imgS, imgS, 'F');
            this.pdf.addImage(document.getElementById(element.name), 'PNG', this.mx, y, imgS * 0.8, imgS * 0.8);
            this.pdf.text(element.text, this.mx + imgS * 1.2, y, { baseline: 'top' });
            y = y + gap
        }

        this.pdf.setFillColor(255, 0, 0);
        // this.pdf.rect(this.mx, this.pageHeight - 50 - this.my, 50, 50, 'F');

        this.pdf.addImage(document.getElementById('masttech'), 'PNG', 0, this.pageHeight - 50 - this.my, 52, 50);

    }



    propertiesPage() {

        this.pdf.addPage('a4', 'portrait')

        this.pdf.setFillColor('05668d'); // RGB: light orange
        this.pdf.rect(0, 0, this.pdf.internal.pageSize.getWidth(), this.pdf.internal.pageSize.getHeight(), 'F');

        this.addHeaderFooter()

        this.pdf.setTextColor(255, 255, 255);

        this.pdf.setFontSize(72);

        this.pdf.setFillColor(0, 255, 0); // RGB: light orange
        this.pdf.rect(0, 35, 160, 40, 'F');

        this.pdf.setFont('helvetica', 'bold');
        this.pdf.text('MTWR', 3 * this.mx, 60);

        this.pdf.setFontSize(16);

        this.pdf.setTextColor(0, 0, 0);
        this.pdf.setFont('courier', 'normal');
        this.pdf.text(this.mastCode, 3 * this.mx, 70);


        const props = [
            ['Maximum Payload Capacity', this.data.maxPayloadCapacity, 'kg'],
            ['Extended Height', this.data.extendedHeight, 'mm'],
            ['Nested Height', this.data.nestedHeight, 'mm'],
            ['Number of Sections', this.data.mastTubes.length, ''],
            ['Maximum Operational Wind Speed', this.data.windspeed, 'km/h'],
            ['Maximum Survival Wind Speed', 160, 'km/h'],
            ['Maximum Sail Area', this.data.sailarea, 'm2'],
            ['Mast Tube Material', 'Aluminium', ''],
            ['Mast Weight', this.data.mastWeight.toFixed(0), 'kg'],

        ]

        /* 
                    autoTable(this.pdf, {
                        head: [['Property', 'Value', 'Unit']],
                        body: [
                            ['Maximum Payload Capacity', this.data.maxPayloadCapacity, 'kg'],
                            ['Extended Height', this.data.extendedHeight, 'kg'],
                            ['Nested Height', this.data.nestedHeight, 'kg'],
                            ['Number of Sections', '$25', 'kg'],
                            ['Maximum Operational Wind Speed', '$25', 'kg'],
                            ['Maximum Survival Wind Speed', '$25', 'kg'],
                            ['Maximum Sail Area', '$25', 'kg'],
                            ['Mast Tube Material', '$25', 'kg'],
                            ['Mast Weight', '$25', 'kg'],
        
                        ],
                        startY: 140
                    }); */

        let y = 90

        let textwidth

        props.forEach(element => {


            // CIRCLE DOT
            this.pdf.setFillColor(100, 204, 204); // RGB: light orange
            this.pdf.circle(3 * this.mx, y + 2, 4, 'F');


            // PROPERTY NAME
            this.pdf.setTextColor(127, 255, 255);
            this.pdf.setFontSize(12);
            this.pdf.setFont('courier', 'normal');
            this.pdf.text(String(element[0]), 3.5 * this.mx, y);

            // PROPERTY VALUE
            this.pdf.setTextColor(255, 255, 255);
            this.pdf.setFontSize(24);
            this.pdf.setFont('helvetica', 'bold');
            this.pdf.text(String(element[1]), 3.5 * this.mx, y + 8);

            // this.pdf.addImage(document.getElementById('dot'), 'PNG', 2 * this.mx, y, 16, 16);

            // PROPERTY UNIT
            textwidth = this.pdf.getTextWidth(String(element[1]))
            this.pdf.setTextColor(195, 221, 233);
            this.pdf.setFontSize(24);
            this.pdf.setFont('courier', 'normal');
            this.pdf.text(String(element[2]), 3.5 * this.mx + 1.1 * textwidth, y + 8);

            y += 20

        });

    }





    dimensionPages(position) {

        let elementId, scope

        if (position == 'nested') {
            elementId = 'nested'
            scope = 'Nested Position Dimensions'
        }

        if (position == 'extended') {
            elementId = 'nested'
            scope = 'Extended Position Dimensions'
        }

        this.pdf.addPage('a4', 'portrait')

        this.pdf.setFillColor(204, 204, 204); // RGB: light orange
        this.pdf.rect(0, 0, this.pdf.internal.pageSize.getWidth(), this.pdf.internal.pageSize.getHeight(), 'F');

        this.addHeaderFooter()

        this.pdf.setFontSize(16);
        this.pdf.setFont('courier', 'normal');
        this.pdf.text(this.mastCode, this.mx, 20);

        this.pdf.text(scope, this.mx, 30);

        this.pdf.addImage(document.getElementById(elementId), 'PNG', this.mx, 4 * this.my, 180, 180);
    }


    addHeaderFooter() {

        const pageWidth = this.pdf.internal.pageSize.width;
        const pageHeight = this.pdf.internal.pageSize.height;

        // Header
        this.pdf.setTextColor(0, 0, 0);

        // this.pdf.setTextColor(255, 255, 255);
        this.pdf.setFontSize(16);
        this.pdf.setFont('helvetica', 'normal');
        this.pdf.text('masttech.com', this.mx, this.my);

        // Footer
        this.pdf.setFontSize(9);

        this.pdf.text('kapkara.one', pageWidth - this.mx, pageHeight - this.my * 0.6, { align: 'right' });
        this.pdf.text('PDM Product Data Management', this.mx, pageHeight - this.my * 0.6, { align: 'left' });
    }



    addQrCode() {
        if (this.qrCodeImage) {
            this.pdf.addImage(this.qrCodeImage, 'PNG', this.mx, this.my + 2, this.qrs, this.qrs);
        } else {
            console.error('QR code not initialized. Call init() first.');
        }
    }


    SILaddSvgToPdf(svgElement, x, y, width, height) {


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



                    console.log("Sonuc ", x, y, width, height)

                    document.getElementById('graphImage').src = dataUrl



                    // --- 4. Bind to jsPDF ---
                    this.pdf.addImage(dataUrl, 'PNG', x, y, width, height);



                    this.pdf.addImage(document.getElementById('graphImage'), 'PNG', x, y, width, height);




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







}









function addSvgToPdf(svgElement, x, y, width, height) {

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

                console.log(dataUrl, x, y, width, height)

                document.getElementById('graphImage').src = dataUrl

                // --- 4. Bind to jsPDF ---
                this.pdf.addImage(dataUrl, 'PNG', x, y, width, height);

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

