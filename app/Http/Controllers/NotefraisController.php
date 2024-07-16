<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Frais;
use Illuminate\Support\Facades\Storage;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF;

class NotefraisController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $notes_de_frais = Frais::where('user_id', $user->id)->paginate(10);

        return view('notefrais.index', [
            'notes_de_frais' => $notes_de_frais,
        ]);
    }

    public function validateFrais($id)
    {
        $note = Frais::findOrFail($id);
        $note->status = 'validated';
        $note->save();

        return redirect()->route('notedefrais.index')->with('status', 'Note de frais validée avec succès.');
    }

    public function approveFrais($id)
    {
        $note = Frais::findOrFail($id);
        $note->status = 'approved';
        $note->save();

        return redirect()->route('notedefrais.index')->with('status', 'Note de frais approuvée avec succès.');
    }


    public function ajouter_note(Request $request)
    {
        $request->validate([
            'Date' => 'required',
            'Trajet' => 'required',
            'Motif' => 'required',
            'Hebergement' => 'nullable',
            'repas' => 'nullable',
            'Justificatif' => 'nullable',
            'pice' => 'nullable|file',
        ]);

        $frais = new Frais();
        $frais->user_id = Auth::id(); // Récupère l'ID de l'utilisateur authentifié
        $frais->Date = $request->Date;
        $frais->Trajet = $request->Trajet;
        $frais->Motif = $request->Motif;
        $frais->Hebergement = $request->Hebergement;
        $frais->repas = $request->repas;
        $frais->Justificatif = $request->Justificatif;

        if ($request->file('pice')) {
            $piceName = date('ymdhis') . '.' . $request->file('pice')->getClientOriginalExtension();
            $request->file('pice')->storeAs('frais/image', $piceName, 'public');
            $frais->pice = 'frais/image/' . $piceName;
        }


        $frais->save();

        return redirect()->route('notedefrais.index')->with('status', 'La note a bien été ajoutée avec succès.');
    }

    public function imprimerPDF(Request $request)
    {
        // Récupérer les données du formulaire
        $date = $request->input('date');
        $trajet = $request->input('trajet');
        $motif = $request->input('motif');
        $hebergement = $request->input('hebergement');
        $repas = $request->input('repas');
        $justificatif = $request->input('justificatif');
        $piece = $request->input('piece'); // Nom de l'attribut correct : 'piece' au lieu de 'pice'

        // Générer le contenu HTML du tableau
        $html = '
            <html>
                <head>
                    <style>
                        table {
                            width: 100%;
                            border-collapse: collapse;
                        }
                        th, td {
                            border: 1px solid black;
                            padding: 8px;
                            text-align: left;
                        }
                    </style>
                </head>
                <body>
                    <h2>Note de Frais</h2>
                    <table>
                        <tr>
                            <th>Date</th>
                            <td>' . htmlspecialchars($date) . '</td>
                        </tr>
                        <tr>
                            <th>Trajet</th>
                            <td>' . htmlspecialchars($trajet) . '</td>
                        </tr>
                        <tr>
                            <th>Motif</th>
                            <td>' . htmlspecialchars($motif) . '</td>
                        </tr>
                        <tr>
                            <th>Hébergement</th>
                            <td>' . htmlspecialchars($hebergement) . '</td>
                        </tr>
                        <tr>
                            <th>Repas</th>
                            <td>' . htmlspecialchars($repas) . '</td>
                        </tr>
                        <tr>
                            <th>Justificatif</th>
                            <td>' . htmlspecialchars($justificatif) . '</td>
                        </tr>
                    </table>';

        // Ajouter l'image pièce jointe s'il y en a une
        if ($piece) {
            // Ajouter l'image dans le contenu HTML
            $html .= '<p><strong>Pièce Jointe:</strong> <img src="' . asset('storage/' . $piece) . '" style="max-width: 100px;"></p>';
        }

        // Finaliser le contenu HTML
        $html .= '</body></html>';

        // Configuration de Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);

        // Instancier Dompdf avec les options
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);

        // Rendre le PDF
        $dompdf->render();

        // Télécharger le PDF
        return $dompdf->stream('note_de_frais.pdf');
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'Date' => 'required|date',
            'Trajet' => 'required|string',
            'Motif' => 'required|string',
            'Hebergement' => 'nullable|string',
            'repas' => 'nullable|string',
            'Justificatif' => 'nullable|string',
            'pice' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Ajouter l'ID de l'utilisateur actuel à $validatedData
        $validatedData['user_id'] = Auth::user()->id;

        // Traitement de l'upload de fichier s'il y en a un
        if ($request->file('pice')) {
            $piceName = date('ymdhis') . '.' . $request->file('pice')->getClientOriginalExtension();
            $path = storage_path('app/public/frais');
            $request->file('pice')->move($path, $piceName);
            $validatedData['pice'] = 'frais/' . $piceName;
        }

        // Création d'une nouvelle instance de Frais avec les données validées et sauvegarde
        Frais::create($validatedData);

        // Redirection avec un message de succès
        return redirect()->route('notedefrais.index')->with('success', 'Note de frais ajoutée avec succès.');
    }
    public function generatePDF(Request $request)
    {
        // Vérifiez si le contenu est reçu correctement
        $content = $request->input('content');

        // Générez votre PDF ici
        $pdf = PDF::loadHTML($content);

        // Définissez le nom du fichier PDF téléchargé
        $filename = 'note_de_frais.pdf';

        // Enregistrez ou retournez le PDF selon votre configuration
        // Exemple d'enregistrement
        $pdf->save(storage_path('app/public/' . $filename));

        // Renvoyez une réponse avec le chemin du fichier PDF
        return response()->json(['url' => asset('storage/' . $filename)]);
    }

    public function destroy($id)
{
    $note = Frais::findOrFail($id);
    $note->delete();

    return redirect()->route('notedefrais.index')->with('success', 'Note de frais supprimée avec succès.');
}

}
