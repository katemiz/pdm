export default class GenerateBrochure {

    constructor(data) {

        this.data = data
        this.pdf = new jsPDF();

        // console.log(this.pdf.getFontList())
        // console.log('this is the data', this.data)

        this.mx = 16
        this.my = 12

        this.qrs = 18

        this.pageWidth;
        this.pageHeight;

        this.logoImage

        this.qrCodeImage = null  // Store QR code 
        
        if (this.data.mastType == 'MTWR') {
            this.props = [
                { name: 'barbellIcon', text: ['Increased Payload Capacity', 'with new tubes and steel wires'] },
                { name: 'windIcon', text: ['Aluminium Stiffened Profiles', 'for low twist and deflection'] },
                { name: 'engineIcon', text: ['AC/DC Motor Driven or Manual', 'Pulley System'] },
                { name: 'personIcon', text: ['New patented low friction', 'slide mechanism'] },
                { name: 'heightIcon', text: ['Heights Up To', '25m'] },
            ]
        } else {
            this.props = [
                { name: 'barbellIcon', text: ['High Payload Capacity', 'Low Twist/Deflection','with new AL stiffened tube profiles'] },
                // { name: 'windIcon', text: ['Aluminium Stiffened Profiles', 'for low twist and deflection'] },
                { name: 'compressorIcon', text: ['Pneumatically driven by', 'Air Compressor System'] },
                { name: 'personIcon', text: ['New patented low friction', 'slide mechanism'] },
                { name: 'autoLockingIcon', text: ['Automatic Locking Mechanism', 'triggered by actuator and mechanical locks'] },
                { name: 'noPressureNeededIcon', text: ['No pressurisation needed', 'in operation when locked'] },
                { name: 'heightIcon', text: ['Heights Up To', '25m'] },
            ]
        }

        this.mastCode = (this.data.extendedHeight / 1000).toFixed(0) + this.data.mastType + '-' + (this.data.nestedHeight / 1000).toFixed(1) + '-' + this.data.mastTubes.length
    }


    // Pre-generate QR code before running
    async init() {
        this.qrCodeImage = await QRCode.toDataURL(this.data.qr, {
            width: 160,
            margin: 1
        });
    }


    async SILrenderSvgToCanvas(svg) {

        const canvas = document.getElementById('svg');

        const ctx = canvas.getContext('2d');
        const v = await Canvg.from(ctx, svg);
        await v.render();
        return canvas;
    }




    run() {

        this.coverPage()
        this.propertiesPage()
        this.dimensionPages('NestedSvgImage','Nested Height Diagram')
        this.dimensionPages('ExtendedSvgImage','Extended Height Diagram')

        this.optionalAccessoriesPage()

        this.pdf.save(this.mastCode + '.pdf');
    }


    coverPage() {

        this.pageWidth = this.pdf.internal.pageSize.getWidth()
        this.pageHeight = this.pdf.internal.pageSize.getHeight()

        // this.pdf.setFillColor(204, 204, 204); // RGB: light orange

        // this.pdf.setFillColor(169, 63, 85);
        // this.pdf.rect(0, 0, this.pageWidth, this.pageHeight, 'F');

        // const imgWidth = 86

        // this.pdf.setFillColor(104, 104, 24); // RGB: light orange
        // this.pdf.rect(this.pageWidth - this.mx - imgWidth, this.my, imgWidth, this.pageHeight - 2 * this.my, 'F');

        // console.log(imgWidth, this.pageHeight - 2 * this.my)



        this.pdf.addImage(document.getElementById(this.data.mastType), 'PNG', 0, 0, 210, 297);



        // this.pdf.setFillColor(169, 163, 85, 0.5);
        // this.pdf.rect(0, this.pageHeight*0.16, this.pageWidth, 46, 'F');


        this.addHeaderFooter()

        // COVER TITLE AND SUBTITLE
        this.pdf.setFontSize(72);
        this.pdf.setFont('helvetica', 'bold');
        this.pdf.text(this.data.mastType, this.mx, this.pageHeight * 0.27);

        this.pdf.setFontSize(24);
        this.pdf.setFont('helvetica', 'normal');
        this.pdf.text(this.mastCode, this.mx, this.pageHeight * 0.27 + 10);

        // QR CODE
        this.addQrCode()


        // SMALL ICONS AND EXPLANATIONS
        const imgS = 12

        let y = 110
        const gap = 20

        this.pdf.setFontSize(14);

        for (const [key, element] of Object.entries(this.props)) {

            this.pdf.setFillColor(255, 255, 255);

            this.pdf.rect(this.mx, y, imgS, imgS, 'F');
            this.pdf.addImage(document.getElementById(element.name), 'PNG', this.mx+imgS*0.15, y+imgS*0.15, imgS * 0.7, imgS * 0.7);
            this.pdf.text(element.text, this.mx + imgS * 1.2, y, { baseline: 'top' });
            y = y + gap
        }

        // this.pdf.setFillColor(255, 0, 0);
        // this.pdf.rect(this.mx, this.pageHeight - 50 - this.my, 50, 50, 'F');

        // MASTTECH BIG LOGO
        this.pdf.addImage(document.getElementById('masttech'), 'PNG', this.mx, this.pageHeight - 50 - this.my, 52, 50);

    }



    propertiesPage() {

        this.pdf.addPage('a4', 'portrait')

        this.pdf.setFillColor(25, 50, 60); 
        this.pdf.rect(0, 0, this.pdf.internal.pageSize.getWidth(), this.pdf.internal.pageSize.getHeight(), 'F');

        this.addHeaderFooter()

        this.pdf.setFontSize(72);

        this.pdf.setFillColor(243, 247, 240); 
        this.pdf.rect(0, 35, 160, 40, 'F');

        this.pdf.setTextColor(25, 50, 60);
        this.pdf.setFont('helvetica', 'bold');
        this.pdf.text(this.data.mastType, 3 * this.mx, 60);

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

        this.pdf.setFont('helvetica', 'normal');


    }







    optionalAccessoriesPage() {

        this.pageWidth = this.pdf.internal.pageSize.getWidth()
        this.pageHeight = this.pdf.internal.pageSize.getHeight()

        this.pdf.addPage('a4', 'portrait')

        this.pdf.setFillColor(204, 204, 204);
        this.pdf.rect(0, 0, this.pageWidth, this.pageHeight, 'F');

        this.addHeaderFooter()

        this.pdf.setFillColor(25, 50, 60); 

        this.pdf.rect(this.pageWidth / 2 - 50, 0, 100, 36, 'F');

        this.pdf.setFontSize(16);
        this.pdf.setFont('courier', 'normal');

                this.pdf.setTextColor(255, 255, 255);

        this.pdf.text(this.mastCode, this.pageWidth / 2, 20, { align: 'center' });
        this.pdf.text('Optional Hardware', this.pageWidth / 2, 30, { align: 'center' });


        let y = 70


        // this.pdf.setTextColor(195, 221, 233);
        this.pdf.setFontSize(32);
        // this.pdf.setFont('helvetica', 'normal');
        // this.pdf.text('OPTIONAL HARDWARE', this.mx, y);




        this.props = [
            { name: 'Side/Vehicle Adaptor', text: ['For Lateral stability and Vehicle Connections', 'Guying Usage Depends on Payload and Mast Height'],image: 'accessory1' },
            { name: 'Floor/Side/Vehicle Adaptor', text: ['For Lateral stability and Vehicle Connections', 'Guying Usage Depends on Payload and Mast Height'],image: 'accessory2' },
            { name: 'Compressor', text: ['Presureised Air System Needed'], image: 'accessory4' },
            { name: 'Transport Lock', text: ['For Heavy Vibration Environments'], image: 'accessory3' },
        ]

        y += 20

        let y2 = 50


        this.pdf.setTextColor(5, 5, 5);


        this.pdf.setFontSize(18);


        this.pdf.text(String(this.props[0]['name']), this.mx, y2);
        this.pdf.addImage(document.getElementById(this.props[0]['image']), 'PNG', this.mx, y2+10, 79, 79);

        this.pdf.text(String(this.props[1]['name']), 105, y2);
        this.pdf.addImage(document.getElementById(this.props[1]['image']), 'PNG', 105, y2+10, 79, 79);

        y2 += 110

        this.pdf.text(String(this.props[2]['name']), this.mx, y2);
        this.pdf.addImage(document.getElementById(this.props[2]['image']), 'PNG', this.mx, y2+10, 79, 79);


        this.pdf.text(String(this.props[3]['name']), 105, y2);
        this.pdf.addImage(document.getElementById(this.props[3]['image']), 'PNG', 105, y2+10, 79, 79);

        // this.props.forEach ( (prop,key) => {

        //     this.pdf.setTextColor(0, 0, 0);
        //     this.pdf.setFontSize(24);
        //     this.pdf.setFont('helvetica', 'normal');
        //     //this.pdf.text(String(prop['name']), this.mx, y2);

        //     this.pdf.setFontSize(18);
        //     this.pdf.text(String(prop['name']), this.mx, y2);

        //     if (key == 1 || key == 3) {
        //         imagex = 105
        //     }
            

        //     this.pdf.addImage(document.getElementById(prop['image']), 'PNG', imagex, y2+15, 90, 90);

        //                 if (key == 2 ) {

        //     y2 += 105
        //                 } 

        // })


    }

























    dimensionPages(imageId,metin) {

        this.pageWidth = this.pdf.internal.pageSize.getWidth()
        this.pageHeight = this.pdf.internal.pageSize.getHeight()

        this.pdf.addPage('a4', 'portrait')

        this.pdf.setFillColor(204, 204, 204);
        this.pdf.rect(0, 0, this.pageWidth, this.pageHeight, 'F');

        this.addHeaderFooter()

        this.pdf.setFillColor(25, 50, 60); 

        this.pdf.rect(this.pageWidth / 2 - 50, 0, 100, 36, 'F');

        this.pdf.setFontSize(16);
        this.pdf.setFont('courier', 'normal');
        this.pdf.setTextColor(255, 255, 255);

        this.pdf.text(this.mastCode, this.pageWidth / 2, 20, { align: 'center' });
        this.pdf.text(metin, this.pageWidth / 2, 30, { align: 'center' });

        let y = 80

        this.pdf.setTextColor(0, 0, 0);

        this.data.mastTubes.forEach(tube => {
            this.pdf.setFontSize(12);
            this.pdf.text(String(tube.od.toFixed(2))+' mm', 3*this.mx, y, { align: 'right' });
            y += 4
        });


        this.pdf.text( ['Section','Tube','Diameters'], 3*this.mx, y+10, { align: 'right' });
        this.pdf.setFontSize(8);
        this.pdf.text( ['(Bottom to Top)'], 3*this.mx, y+24, { align: 'right' });

        // this.pdf.line(105,  0, 105, 200);

        this.pdf.addImage(document.getElementById(imageId), 'PNG', this.mx, 4 * this.my, 180, 180);
    }


    addHeaderFooter() {

        const pageWidth = this.pdf.internal.pageSize.width;
        const pageHeight = this.pdf.internal.pageSize.height;


        /*
        masttech.com         
        this.pdf.setFont('helvetica', 'normal');
        this.pdf.text('masttech.com', this.mx, this.my);
        */

        // Footer
        this.pdf.setFontSize(9);
        this.pdf.setTextColor(0, 0, 0);
        this.pdf.setFont('helvetica', 'normal');

        this.pdf.text('kapkara.one', pageWidth - this.mx, pageHeight - this.my * 0.6, { align: 'right' });
        this.pdf.text('PDM Product Data Management', this.mx, pageHeight - this.my * 0.6, { align: 'left' });
    }



    addQrCode() {
        if (this.qrCodeImage) {

            this.pdf.addImage(this.qrCodeImage, 'PNG', this.mx, this.my + 2, this.qrs, this.qrs);
            this.pdf.link(this.mx, this.my + 2, this.qrs, this.qrs, { url: this.data.qr });

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









function SILaddSvgToPdf(svgElement, x, y, width, height) {

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

