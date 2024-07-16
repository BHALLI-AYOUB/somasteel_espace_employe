import jsPDF from 'jspdf';
import 'jspdf-autotable';

// Function to generate and download PDF
export function imprimerPDF(date, trajet, motif, hebergement, repas, justificatif, pieceJointe) {
    // Initialize jsPDF
    const doc = new jsPDF();

    // Example of content
    let data = [
        ['Date', 'Trajet', 'Motif', 'Hébergement', 'Repas', 'Justificatif', 'Pièce Jointe'],
        [date, trajet, motif, hebergement, repas, justificatif, pieceJointe],
    ];

    // Configure the header of the PDF
    doc.text('Liste des Notes de Frais', 14, 10);

    // Convert the table into PDF format using jspdf-autotable
    doc.autoTable({ startY: 20, head: data });

    // Save the PDF file
    doc.save('notes_de_frais.pdf');
}
