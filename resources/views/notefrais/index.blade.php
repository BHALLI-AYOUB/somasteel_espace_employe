@extends('layouts.app')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<!-- Toastr CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<div class="container mt-4">
    <div class="d-flex justify-content-between my-3">
        <h2 class="mb-2">
            <b class="border-bottom border-black border-2 no-break"><em>{{__('Notes De Frais')}}</em></b>
        </h2>
        <div class="col text-end">
            <button class="btn btn-warning no-break" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="fa fa-plus me-2"></i> {{__('Nouveau Note')}}
            </button>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <table id="tableId" class="table">
        <thead>
            <tr>
                <th scope="col" rowspan="2" style="text-align: center; padding:10px !important;">Date</th>
                <th scope="col" rowspan="2" style="text-align: center;">Trajet</th>
                <th scope="col" colspan="2" rowspan="1">Motif</th>
                <th scope="col" rowspan="2" style="text-align: center;">Hébergement</th>
                <th scope="col" rowspan="2" style="text-align: center;">Repas</th>
                <th scope="col" rowspan="2" style="text-align: center;">Justificatif</th>
                <th scope="col" rowspan="2" style="text-align: center;">Pièce Jointe</th>
                <th scope="col" rowspan="2" style="text-align: center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($notes_de_frais as $index => $note)
            <tr>
                <td style="text-align: center;">{{ $note->Date }}</td>
                <td style="text-align: center;">{{ $note->Trajet }}</td>
                <td style="text-align: center;" colspan="2">{{ $note->Motif }}</td>
                <td style="text-align: center;">{{ $note->Hebergement }}</td>
                <td style="text-align: center;">{{ $note->repas }}</td>
                <td style="text-align: center;">{{ $note->Justificatif }}</td>
                <td style="text-align: center; width: 250px;">
                    @if($note->pice)
                    <a href="{{ asset('storage/' . $note->pice) }}" class="image-popup">
                        <img src="{{ asset('storage/' . $note->pice) }}" alt="Image de la pièce jointe" style="width: 65%; height: 50%;">
                    </a>
                    @else
                    N/A
                    @endif
                </td>
                <td style="text-align: center; width: 200px;">
                    <div style="display: flex; justify-content: space-around;">
                        {{-- @foreach($notes_de_frais as $note) --}}
                          <button class="btn btn-primary imprimer-btn"
                                  data-date="{{ $note->Date }}"
                                    data-trajet="{{ $note->Trajet }}"
                                  data-motif="{{ $note->Motif }}"
                                data-hebergement="{{ $note->Hebergement }}"
                                data-repas="{{ $note->repas }}"
                               data-justificatif="{{ $note->Justificatif }}"
                               data-piece="{{ $note->piece }}">
                         Imprimer
                        </button>
{{-- @endforeach --}}

<form action="{{ route('notedefrais.destroy', $note->id) }}" method="POST" class="delete-form">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger supprimer-btn">Supprimer</button>
</form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $notes_de_frais->links('vendor.pagination.custom') }}
    </div>
</div>

<!-- Modal Nouveau Note -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title w-100 text-center" id="exampleModalLabel">{{__('Créer une Note de Frais')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formNoteFrais" action="{{ route('notedefrais.ajouter') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="Date" class="form-label">{{__('Date')}}</label>
                        <input type="date" class="form-control" id="Date" name="Date" required>
                    </div>
                    <div class="mb-3">
                        <label for="Trajet" class="form-label">{{__('Trajet')}}</label>
                        <input type="text" class="form-control" id="Trajet" name="Trajet" required>
                    </div>
                    <div class="mb-3">
                        <label for="Motif" class="form-label">{{__('Motif')}}</label>
                        <input type="text" class="form-control" id="Motif" name="Motif" required>
                    </div>
                    <div class="mb-3">
                        <label for="Hebergement" class="form-label">{{__('Hébergement')}}</label>
                        <input type="text" class="form-control" id="Hebergement" name="Hebergement">
                    </div>
                    <div class="mb-3">
                        <label for="repas" class="form-label">{{__('Repas')}}</label>
                        <input type="text" class="form-control" id="repas" name="repas">
                    </div>
                    <div class="mb-3">
                        <label for="Justificatif" class="form-label">{{__('Justificatif')}}</label>
                        <input type="text" class="form-control" id="Justificatif" name="Justificatif">
                    </div>
                    <div class="mb-3">
                        <label for="pice" class="form-label">{{__('Pièce Jointe')}}</label>
                        <input type="file" class="form-control" id="pice" name="pice">
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary enregistrer-btn">Enregistrer</button>
                    </div>
                </form>

                  
                
            </div>
        </div>
    </div>
</div>

<style>
    /* Styles pour l'overlay d'image agrandie */
    .image-en-grand-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8); /* Fond semi-transparent noir */
        display: flex;
        justify-content: center; /* Centrer horizontalement */
        align-items: center; /* Centrer verticalement */
        z-index: 1055;
    }

    /* Conteneur de l'image agrandie */
    .image-en-grand-container {
        position: relative;
        max-width: 90%; /* Largeur maximale du conteneur d'image */
        max-height: 90%; /* Hauteur maximale du conteneur d'image */
    }

    /* Style de l'image agrandie */
    .image-en-grand {
        max-width: 100%; /* Image ne dépasse pas la largeur du conteneur */
        max-height: 100%; /* Image ne dépasse pas la hauteur du conteneur */
        object-fit: contain; /* Ajustement de l'image tout en conservant le ratio */
        border: 2px solid #fff; /* Bordure blanche de 2 pixels */
        z-index: 1056;
    }
</style>

<script>
    // Gérer le clic sur les boutons "Imprimer"
    document.querySelectorAll('.imprimer-btn').forEach(function(button) {
    button.addEventListener('click', function() {
        var date = this.getAttribute('data-date');
        var trajet = this.getAttribute('data-trajet');
        var motif = this.getAttribute('data-motif');
        var hebergement = this.getAttribute('data-hebergement');
        var repas = this.getAttribute('data-repas');
        var justificatif = this.getAttribute('data-justificatif');
        var piece = this.getAttribute('data-piece');
        var logoUrl = "{{ asset('images/logosomasteel.png') }}";

        var printWindow = window.open('', '_blank');
        printWindow.document.write('<html><head><title>Note de frais</title>');
        printWindow.document.write('<style>body { font-family: Arial, sans-serif; } .header { display: flex; justify-content: space-around; align-items: center; margin-bottom: 20px; } .header h1 { margin: 0; } .header img { max-width: 200px; } table { width: 100%; border-collapse: collapse; } th, td { border: 1px solid black; padding: 8px; } th { background-color: #f2f2f2; }</style></head><body>');
        printWindow.document.write('<div class="header"><h1>Note de frais</h1><img src="' + logoUrl + '" alt="Logo"></div>'); // Title and image
        printWindow.document.write('<table>');
        printWindow.document.write('<tr><th>Date</th><td>' + date + '</td></tr>');
        printWindow.document.write('<tr><th>Trajet</th><td>' + trajet + '</td></tr>');
        printWindow.document.write('<tr><th>Motif</th><td>' + motif + '</td></tr>');
        printWindow.document.write('<tr><th>Hébergement</th><td>' + hebergement + '</td></tr>');
        printWindow.document.write('<tr><th>Repas</th><td>' + repas + '</td></tr>');
        printWindow.document.write('<tr><th>Justificatif</th><td>' + justificatif + '</td></tr>');
        if (piece) {
            printWindow.document.write('<tr><th>Pièce Jointe</th><td><img src="/storage/' + piece + '" style="max-width: 100px;"></td></tr>');
        }
        printWindow.document.write('</table>');
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    });
});



        // Gérer l'aperçu de l'image agrandie
        $('.image-popup').click(function(event) {
            event.preventDefault();
            var imageUrl = $(this).attr('href');
            $('body').append('<div class="image-en-grand-overlay"><div class="image-en-grand-container"><img src="' + imageUrl + '" class="image-en-grand"></div></div>');
        });

        // Fermer l'image agrandie lors du clic sur l'overlay
        $(document).on('click', '.image-en-grand-overlay', function() {
            $(this).remove();
        });

</script>
<script>
    document.querySelector('.enregistrer-btn').addEventListener('click', function(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: 'Voulez-vous vraiment enregistrer cette note de frais ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, enregistrer!',
            background: 'yellow',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('formNoteFrais').submit();
            }
        });
    });

    document.querySelectorAll('.supprimer-btn').forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: 'Voulez-vous vraiment supprimer cette note de frais ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, supprimer!',
                background: 'yellow',
            }).then((result) => {
                if (result.isConfirmed) {
                    this.closest('form').submit();
                }
            });
        });
    });
</script>

@endsection
