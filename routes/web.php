<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Middleware\IsRHmd;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DemandesController;
use App\Http\Controllers\DemandesCongeController;
use App\Http\Controllers\AnnuaireController;
use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\DeclarationAbsController;
use App\Http\Middleware\isRespmd;
use App\Http\Middleware\CheckAnyRole;
use App\Http\Controllers\NotefraisController;
use App\Http\Controllers\NoteDeFraisController;



Route::get('/', function () {
    return view('auth.login');
});

// Auth::routes();
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

//I don't need registration
// Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
// Route::Put('/register', [RegisterController::class, 'update']);

//somasteel Blog

// Route::get('/SomaProduit', [BlogeController::class, 'produitIndex'])->name('bloge.produit');





Route::middleware('auth')->group(function () {
    Route::put('/home/updateEmail', [HomeController::class, 'updateEmail'])->name('home.update');
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::put('/home/update-picture', [HomeController::class, 'updatePicture'])->name('profile.updatePicture');
    Route::get('/home/profiles_imgs/{filename}', [HomeController::class ,'getProfileImage'])->name('profile.image');
    Route::delete('/home/delete-picture', [HomeController::class,'deleteProfilePicture'])->name('home.delete.picture');
    // dd('test');

    Route::get('/demandes', [DemandesController::class, 'index'])->name('demandes.index');
    Route::post('/demandes', [DemandesCongeController::class, 'store'])->name('demandesconge.store');
    Route::put('/demandes/{demande_id}/decide', [DemandesCongeController::class, 'update'])->name('demandeconge.update');
    Route::get('/demandes/download/{dc_id}', [DemandesCongeController::class, 'downloadConge'])->name('demandeConge.downloadConge');

    //Absence
    Route::get('/Permissions_Absence', [AbsenceController::class, 'index'])->name('absence.index');


    // Route::middleware([IsRhmd::class || isRespmd::class])->group(function () {
    //     Route::get('/declarationabsence',[DeclarationAbsController::class,'index'])->name('absence.declaration');

    // });
    // Route::middleware([CheckAnyRole::class])->group(function () {
    //     Route::get('/declarationabsence', [DeclarationAbsController::class, 'index'])->name('absence.declaration');

    // });
    // Route::middleware([CheckAnyRole::class])->group(function () {
    //     Route::get('/notedefrais', [NotefraisController::class, 'index'])->name('notedefrais.index');
    //     Route::post('/notedefrais', [NotefraisController::class, 'ajouter_note'])->name('notedefrais.ajouter');
    // // });
    // use App\Http\Controllers\NotefraisController;
    // Route::middleware([CheckAnyRole::class])->group(function () {
    Route::get('/notedefrais', [NotefraisController::class, 'index'])->name('notedefrais.index');
    Route::post('/notedefrais', [NotefraisController::class, 'ajouter_note'])->name('notedefrais.ajouter');
    Route::post('/notedefrais', [NotefraisController::class, 'store'])->name('notedefrais.store');

    // Route::post('/notedefrais', [NotefraisController::class, 'store'])->name('notedefrais.store');
    Route::post('/notedefrais/ajouter', [NotefraisController::class, 'store'])->name('notedefrais.ajouter');

    // Route pour afficher le formulaire d'édition d'une note de frais spécifique
    // Route::get('/notedefrais/{id}/edit', [NoteDeFraisController::class, 'edit'])->name('notedefrais.edit');
    // Route::get('/notedefrais/{id}/edit', [NotefraisController::class, 'edit'])->name('notedefrais.edit');

    // Route pour mettre à jour une note de frais spécifique
    // Route::put('/notedefrais/{id}', [NotefraisController::class, 'update'])->name('notedefrais.update');

    // Route pour supprimer une note de frais spécifique
    // Route::delete('/notedefrais/{id}', [NoteDeFraisController::class, 'destroy'])->name('notedefrais.destroy');
    Route::delete('/notedefrais/{id}', [NotefraisController::class, 'destroy'])->name('notedefrais.destroy');

// });

    // Route pour afficher la liste des notes de frais
// web.php
Route::get('/notedefrais/pdf', [NotefraisController::class, 'downloadPdf'])->name('notedefrais.pdf');



    // Route pour afficher le formulaire de création d'une nouvelle note de frais
    // Route::get('/notedefrais/create', [NoteDeFraisController::class, 'create'])->name('notedefrais.create');

    // Route pour enregistrer une nouvelle note de frais
    Route::post('/notedefrais', [NotefraisController::class, 'store'])->name('notedefrais.store');

    // Route::post('/notedefrais', [NotefraisController::class, 'store'])->name('notedefrais.store');
    Route::post('/notedefrais/ajouter', [NotefraisController::class, 'store'])->name('notedefrais.ajouter');

    // Route pour afficher le formulaire d'édition d'une note de frais spécifique
    // Route::get('/notedefrais/{id}/edit', [NoteDeFraisController::class, 'edit'])->name('notedefrais.edit');
    // Route::get('/notedefrais/{id}/edit', [NotefraisController::class, 'edit'])->name('notedefrais.edit');

    // Route pour mettre à jour une note de frais spécifique
    // Route::put('/notedefrais/{id}', [NotefraisController::class, 'update'])->name('notedefrais.update');

    // Route pour supprimer une note de frais spécifique
    // Route::delete('/notedefrais/{id}', [NoteDeFraisController::class, 'destroy'])->name('notedefrais.destroy');
    Route::delete('/notedefrais/{id}', [NotefraisController::class, 'destroy'])->name('notedefrais.destroy');

// web.php
// Route::put('/notedefrais/update/{id}', [NotefraisController::class, 'update'])->name('notedefrais.update');


Route::middleware(['auth'])->group(function () {
    Route::get('/notedefrais', [NotefraisController::class, 'index'])->name('notedefrais.index');
    Route::post('/notedefrais', [NotefraisController::class, 'store'])->name('notedefrais.store');

    Route::middleware(['isResp'])->group(function () {
        Route::post('/notedefrais/{id}/validate', [NotefraisController::class, 'validateFrais'])->name('notedefrais.validate');
    });

    Route::middleware(['isRh'])->group(function () {
        Route::post('/notedefrais/{id}/approve', [NotefraisController::class, 'approveFrais'])->name('notedefrais.approve');
    });
});


// Route::put('/notedefrais/{id}', [NoteDeFraisController::class, 'update'])->name('notedefrais.update');

    //Annuaire routes
    Route::middleware(IsRHmd::class)->group(function () {
        Route::get('/Annuaire', [AnnuaireController::class, 'index'])->name('annuaire.index');//done
        Route::get('/Annuaire/{depart}', [AnnuaireController::class, 'showDepartment'])->name('annuaire.depart');//done
        Route::get('/Annuaire/{depart}/{employee_nom}/{employee_id}', [AnnuaireController::class,'showEmployee'])->name('annuaire.employee');//done
        Route::post('/Annuaire/create-department', [AnnuaireController::class,'storeDepart'])->name('annuaire.depart.store');
        // Route::get('/Annuaire/{depart}/{employee_nom}_{employee_id}/edit', [AnnuaireController::class, 'editEmp'])->name('annuaire.editEmployee');
        Route::put('/Annuaire/update/{employee_id}', [AnnuaireController::class, 'updateEmp'])->name('annuaire.employee.update');
        Route::put('/Annuaire/updatePass/{employee_id}', [AnnuaireController::class, 'changePassword'])->name('annuaire.employee.changePassword');
        Route::delete('/Annuaire/delete/{employee_id}', [AnnuaireController::class, 'destroyEmp'])->name('annuaire.employee.destroy');
        Route::post('/Annuaire/{depart}/register', [AnnuaireController::class, 'storeEmployee'])->name('annuaire.employee.register');


        //password
        //Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
        //Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
        //Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
        //Route::post('/password/reset', [ResetPasswordController::class, 'reset']);
    });
});
