// import './bootstrap';


import jsPDF from 'jspdf';
import autoTable from 'jspdf-autotable';
// import 'svg2pdf.js';

import QRCode from 'qrcode';

import Swal from 'sweetalert2';


import MastDraw from './MastDraw.js';
import GenerateBrochure from './GenerateBrochure.js';


window.Swal = Swal;

window.MastDraw = MastDraw;
window.GenerateBrochure = GenerateBrochure;



window.jsPDF = jsPDF;
window.autoTable = autoTable;
window.QRCode = QRCode;
// window.svg2pdf = svg2pdf;