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
                { name: 'barbellIcon', text: ['High Payload Capacity', 'Low Twist/Deflection', 'with new AL stiffened tube profiles'] },
                // { name: 'windIcon', text: ['Aluminium Stiffened Profiles', 'for low twist and deflection'] },
                { name: 'compressorIcon', text: ['Pneumatically driven by', 'Air Compressor System'] },
                { name: 'personIcon', text: ['New patented low friction', 'slide mechanism'] },
                { name: 'autoLockingIcon', text: ['Automatic Locking Mechanism', 'triggered by actuator and mechanical locks'] },
                { name: 'noPressureNeededIcon', text: ['No pressurisation needed', 'in operation when locked'] },
                { name: 'heightIcon', text: ['Heights Up To', '25m'] },
            ]
        }

        this.image_warning = 'Image shown in cover page is for illustration purposes only shows heavy duty mast.'

        this.mastCode = (this.data.extendedHeight / 1000).toFixed(0) + this.data.mastType + '-' + (this.data.nestedHeight / 1000).toFixed(1) + '-' + this.data.mastTubes.length



        this.accessories = [
            {
                name: 'Side/Vehicle Adaptor',
                text: ['For Lateral stability and Vehicle Connections', 'Guying Usage Depends on Payload and Mast Height'],
                image: 'accessory1',
                applicability:['MTWR','MTPR'] 
            },
            {
                name: 'Floor/Side/Vehicle Adaptor',
                text: ['For Lateral stability and Vehicle Connections', 'Guying Usage Depends on Payload and Mast Height'],
                image: 'accessory2',
                applicability:['MTWR','MTPR'] 

            },
            {
                name: 'Compressor',
                text: ['Pressurised Air System Needed'],
                image: 'accessory4',
                applicability:['MTPR'] 

            },
            {
                name: 'Transport Lock',
                text: ['For Heavy Vibration Environments'],
                image: 'accessory3',
                applicability:['MTWR','MTPR'] 

            },
        ]



        this.config = {
            pageBgColor: "204, 204, 204",
            pageHeaderBgColor: [25, 50, 60],
            pageFontSize: 12,
            imgS: 12,
            gap: 20
        }
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
        this.dimensionPages('NestedSvgImage', 'Nested Height Diagram')
        this.dimensionPages('ExtendedSvgImage', 'Extended Height Diagram')
        this.optionalAccessoriesPage()
        this.disclaimerPage()

        this.pdf.save(this.mastCode + '.pdf');
    }


    coverPage() {

        this.pdf.addImage(document.getElementById(this.data.mastType), 'PNG', 0, 0, 210, 297);
        this.addHeaderFooter()

        // COVER TITLE AND SUBTITLE
        this.pdf.setFontSize(72);
        this.pdf.setFont('helvetica', 'bold');
        this.pdf.text(this.data.mastType, this.mx, this.pageHeight * 0.27);

        this.pdf.setFontSize(24);
        this.pdf.setFont('helvetica', 'normal');
        this.pdf.text(this.mastCode, this.mx, this.pageHeight * 0.27 + 10);

        this.pdf.setFontSize(8);
        this.pdf.text(this.image_warning, 207, 294, { angle: 90 });

        // QR CODE
        this.addQrCode()

        // SMALL ICONS AND EXPLANATIONS

        let y = 110

        this.pdf.setFontSize(14);

        for (const [key, element] of Object.entries(this.props)) {

            this.pdf.setFillColor(255, 255, 255);

            this.pdf.rect(this.mx, y, this.config.imgS, this.config.imgS, 'F');
            this.pdf.addImage(document.getElementById(element.name), 'PNG', this.mx + this.config.imgS * 0.15, y + this.config.imgS * 0.15, this.config.imgS * 0.7, this.config.imgS * 0.7);
            this.pdf.text(element.text, this.mx + this.config.imgS * 1.2, y, { baseline: 'top' });
            y = y + this.config.gap
        }

        // MASTTECH BIG LOGO
        this.pdf.addImage(document.getElementById('masttech'), 'PNG', this.mx, this.pageHeight - 50 - this.my, 52, 50);

    }



    propertiesPage() {

        this.pdf.addPage('a4', 'portrait')
        this.addHeaderFooter('General Mast Properties')

        const props = [
            ['Maximum Payload Capacity', this.data.maxPayloadCapacity, 'kg'],
            ['Extended Height', this.data.extendedHeight, 'mm'],
            ['Nested Height', this.data.nestedHeight, 'mm'],
            ['Number of Sections', this.data.mastTubes.length, ''],
            ['Maximum Operational Wind Speed', this.data.windspeed, 'km/h'],
            ['Maximum Survival Wind Speed', 160, 'km/h'],
            ['Maximum Sail Area', this.data.sailarea, 'm2'],
            ['Mast Tube Material', 'Aluminium', ''],
            ['Mast Weight [Estimated]', this.data.mastWeight.toFixed(0), 'kg'],
        ]

        autoTable(this.pdf, {
            columnStyles: { 1: { halign: 'right', fontWeight: "bold" } }, // Cells in first column centered and green
            head: [['Property', 'Value', 'Unit']],
            body: props,
            startY: 70
        });
    }







    optionalAccessoriesPage() {

        this.pdf.addPage('a4', 'portrait')
        this.addHeaderFooter('Optional Hardware')

        // ACCESSORIES LIST
        let starty = 60;

        let px, py;

        let img_dim = (this.pageWidth - 2 * this.mx - this.config.gap) / 2;

        this.pdf.setFontSize(14);

        let sayac = 0

        this.accessories.forEach((accessory, key) => {

            if (accessory.applicability.includes(this.data.mastType)){

                py = starty;

                if (key % 2 == 0) {
                    px = this.mx;
                } else {
                    px = this.pageWidth / 2 + this.config.gap / 2;
                    starty += 120
                }

                this.pdf.text(String(accessory.name), px, py);
                this.pdf.addImage(document.getElementById(accessory.image), 'JPG', px, py + 4, img_dim, img_dim);

                sayac++

            } 
        });
    }




















    dimensionPages(imageId, metin) {

        this.pdf.addPage('a4', 'portrait')
        this.addHeaderFooter(metin)

        let y = 80

        this.pdf.setTextColor(0, 0, 0);

        this.data.mastTubes.forEach(tube => {
            this.pdf.setFontSize(12);
            this.pdf.text(String(tube.od.toFixed(2)) + ' mm', 3 * this.mx, y, { align: 'right' });
            y += 4
        });

        this.pdf.text(['Section', 'Tube', 'Diameters'], 3 * this.mx, y + 10, { align: 'right' });
        this.pdf.setFontSize(8);
        this.pdf.text(['(Bottom to Top)'], 3 * this.mx, y + 24, { align: 'right' });

        this.pdf.addImage(document.getElementById(imageId), 'PNG', this.mx, 4 * this.my, 180, 180);

        if (imageId === "ExtendedSvgImage") {

            this.pdf.setFontSize(12);
            this.pdf.setTextColor(24, 48, 89);

            const guyingText = `(*) As a general rule of thumb, guying radius should be equal to extended mast height for optimal stability. Guying radius, number of guying and at which tubes guying to be fixed should be evaluated per payload, stability requirements and available space. Please contact Masttech for detailed guying recommendations.`
        
            this.pdf.text(this.pdf.splitTextToSize(guyingText, this.pageWidth - 2 * this.mx), this.mx, 240);
        } 
    }


    addHeaderFooter(title = false) {

        this.pageWidth = this.pdf.internal.pageSize.getWidth()
        this.pageHeight = this.pdf.internal.pageSize.getHeight()

        if (title) {

            this.pdf.setFillColor(...this.config.pageHeaderBgColor);

            this.pdf.rect(this.pageWidth / 2 - 50, 0, 100, 36, 'F');

            this.pdf.setFontSize(16);
            this.pdf.setFont('courier', 'normal');

            this.pdf.setTextColor(255, 255, 255);

            this.pdf.text(this.mastCode, this.pageWidth / 2, 15, { align: 'center' });
            this.pdf.text(title, this.pageWidth / 2, 25, { align: 'center' });
        }

        // Footer
        this.pdf.setFontSize(9);
        this.pdf.setTextColor(0, 0, 0);
        this.pdf.setFont('helvetica', 'normal');

        this.pdf.text('kapkara.one', this.pageWidth - this.mx, this.pageHeight - this.my * 0.6, { align: 'right' });
        this.pdf.text('PDM Product Data Management', this.mx, this.pageHeight - this.my * 0.6, { align: 'left' });
    }



    addQrCode() {
        if (this.qrCodeImage) {

            this.pdf.addImage(this.qrCodeImage, 'PNG', this.mx, this.my + 2, this.qrs, this.qrs);
            this.pdf.link(this.mx, this.my + 2, this.qrs, this.qrs, { url: this.data.qr });

        } else {
            console.error('QR code not initialized. Call init() first.');
        }
    }



    disclaimerPage() {

        this.pdf.addPage('a4', 'portrait')
        this.addHeaderFooter('Disclaimer')

        this.pdf.setFontSize(10);
        this.pdf.setTextColor(0, 0, 0);
        this.pdf.setFont('helvetica', 'normal');

        const disclaimerText = `
        The information provided in this brochure is for general informational purposes only. While we strive to keep the information up to date and correct, we make no representations or warranties of any kind, express or implied, about the completeness, accuracy, reliability, suitability or availability with respect to the brochure or the information, products, services, or related graphics contained in the brochure for any purpose. Any reliance you place on such information is therefore strictly at your own risk. In no event will we be liable for any loss or damage including without limitation, indirect or consequential loss or damage, or any loss or damage whatsoever arising from loss of data or profits arising out of, or in connection with, the use of this brochure. Through this brochure you are able to link to other websites which are not under the control of our company. We have no control over the nature, content and availability of those sites. The inclusion of any links does not necessarily imply a recommendation or endorse the views expressed within them. Every effort is made to keep the brochure up and running smoothly. However, our company takes no responsibility for, and will not be liable for, the brochure being temporarily unavailable due to technical issues beyond our control.
        `;

        this.pdf.text(this.pdf.splitTextToSize(disclaimerText, this.pageWidth - 2 * this.mx), this.mx, 60);

        let imgWidth = 84;
        let imgHeight = 80;

        // MASTTECH BIG LOGO
        this.pdf.addImage(document.getElementById('masttech'), 'PNG', (this.pageWidth - imgWidth) / 2, 120, imgWidth, imgHeight);

        const now = new Date();

        this.pdf.text(String(now), this.pageWidth / 2, 220, { align: 'center' });
    }

}








