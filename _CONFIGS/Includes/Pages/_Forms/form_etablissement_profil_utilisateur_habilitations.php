<p id="p_etablissement_profil_utilisateur_habilitations_resultats"></p>
<form id="form_etablissement_profil_utilisateur_habilitations" aria-disabled="true">
    <div class="row">
        <div class="col">
            <div class="row">
                <div class="col-sm-12" style="margin-bottom: 10px">
                    <div class="card border-dark">
                        <div class="card-header bg-indigo text-white h6">
                            <table style="width: 100%">
                                <tr>
                                    <td style="width: 95%"><strong><i class="bi bi-person-circle"></i> Patients</strong></td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="affichage_patients_input" value="AFF_PTS;" <?= in_array('AFF_PTS', $habilitations_modules, true) ? 'checked': null;?>>
                                            <label class="form-check-label" for="affichage_patients_input"></label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-hover table-stripped">
                                <tr>
                                    <td style="width: 95%"></td>
                                    <td class="align_center"><i class="bi bi-eye"></i></td>
                                    <td class="align_center"><i class="bi bi-pencil"</td>
                                </tr>
                                <tr>
                                    <td>Patient</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input habilitations_patients" type="checkbox" role="switch" id="affichage_patient_input" value="AFF_PT;" <?= in_array('AFF_PT', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_PTS', $habilitations_modules, true) ? 'disabled': null;?>>
                                            <label class="form-check-label" for="affichage_patient_input"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input habilitations_patients" type="checkbox" role="switch" id="edition_patient_input" value="EDT_PT;" <?= in_array('EDT_PT', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_PTS', $habilitations_modules, true) ? 'disabled': null;?>>
                                            <label class="form-check-label" for="edition_patient_input"></label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Antécédants médicaux</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input habilitations_patients" type="checkbox" role="switch" id="affichage_patient_antecedants_input" value="AFF_PT_ANTMED;" <?= in_array('AFF_PT_ANTMED', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_PTS', $habilitations_modules, true) ? 'disabled': null;?>>
                                            <label class="form-check-label" for="affichage_patient_antecedants_input"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input habilitations_patients" type="checkbox" role="switch" id="edition_patient_antecedants_input" value="EDT_PT_ANTMED;" <?= in_array('EDT_PT_ANTMED', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_PTS', $habilitations_modules, true) ? 'disabled': null;?>>
                                            <label class="form-check-label" for="edition_patient_antecedants_input"></label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12" style="margin-bottom: 10px">
                    <div class="card border-dark">
                        <div class="card-header bg-indigo text-white h6">
                            <table style="width: 100%">
                                <tr>
                                    <td style="width: 95%"><strong><i class="bi bi-circle-square"></i> Fournisseurs</strong></td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="affichage_fournisseurs_input" value="AFF_FRNSS;" <?= in_array('AFF_FRNSS', $habilitations_modules, true) ? 'checked': null;?>>
                                            <label class="form-check-label" for="affichage_fournisseurs_input"></label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-hover table-stripped">
                                <tr>
                                    <td style="width: 95%"></td>
                                    <td class="align_center"><i class="bi bi-eye"></i></td>
                                    <td class="align_center"><i class="bi bi-pencil"</td>
                                </tr>
                                <tr>
                                    <td>Fournisseur</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input habilitations_fournisseurs" type="checkbox" role="switch" id="affichage_fournisseur_input" value="AFF_FRNS;" <?= in_array('AFF_FRNS', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_FRNSS', $habilitations_modules, true) ? 'disabled': null;?>>
                                            <label class="form-check-label" for="affichage_fournisseur_input"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input habilitations_fournisseurs" type="checkbox" role="switch" id="edition_fournisseur_input" value="EDT_FRNS;" <?= in_array('EDT_FRNS', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_FRNSS', $habilitations_modules, true) ? 'disabled': null;?>>
                                            <label class="form-check-label" for="edition_fournisseur_input"></label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12" style="margin-bottom: 10px">
                    <div class="card border-dark">
                        <div class="card-header bg-indigo text-white h6">
                            <table style="width: 100%">
                                <tr>
                                    <td style="width: 95%"><strong><i class="bi bi-graph-up"></i> Dashboard</strong></td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="affichage_dashboards_input" value="AFF_DSHBS;" <?= in_array('AFF_DSHBS', $habilitations_modules, true) ? 'checked': null;?>>
                                            <label class="form-check-label" for="affichage_dashboards_input"></label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-hover table-stripped">
                                <tr>
                                    <td style="width: 95%"></td>
                                    <td class="align_center"><i class="bi bi-eye"></i></td>
                                    <td class="align_center"><i class="bi bi-pencil"</td>
                                </tr>
                                <tr>
                                    <td>Dashboard</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input habilitations_dashboard" type="checkbox" role="switch" id="affichage_dashboard_input" value="AFF_DSHB;" <?= in_array('AFF_DSHB', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_DSHBS', $habilitations_modules, true) ? 'disabled': null;?>>
                                            <label class="form-check-label" for="affichage_dashboard_input"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input habilitations_dashboard" type="checkbox" role="switch" id="edition_dashboard_input" value="EDT_DSHB;" <?= in_array('EDT_DSHB', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_DSHBS', $habilitations_modules, true) ? 'disabled': null;?>>
                                            <label class="form-check-label" for="edition_dashboard_input"></label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="row">
                <div class="col-sm-12" style="margin-bottom: 10px">
                    <div class="card border-dark">
                        <div class="card-header bg-indigo text-white h6">
                            <table style="width: 100%">
                                <tr>
                                    <td style="width: 95%"><strong><i class="bi bi-folder2-open"></i> Dossiers</strong></td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="affichage_dossiers_input" value="AFF_DOSS;" <?= in_array('AFF_DOSS', $habilitations_modules, true) ? 'checked': null;?>>
                                            <label class="form-check-label" for="affichage_dossiers_input"></label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-hover table-stripped">
                                <tr>
                                    <td style="width: 95%"></td>
                                    <td class="align_center"><i class="bi bi-eye"></i></td>
                                    <td class="align_center"><i class="bi bi-pencil"</td>
                                </tr>
                                <tr>
                                    <td>Dossier</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input habilitations_dossiers" type="checkbox" role="switch" id="affichage_dossier_input" value="AFF_DOS;" <?= in_array('AFF_DOS', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_DOSS', $habilitations_modules, true) ? 'disabled': null;?>>
                                            <label class="form-check-label" for="affichage_dossier_input"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input habilitations_dossiers" type="checkbox" role="switch" id="edition_dossier_input" value="EDT_DOS;" <?= in_array('EDT_DOS', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_DOSS', $habilitations_modules, true) ? 'disabled': null;?>>
                                            <label class="form-check-label" for="edition_dossier_input"></label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Constantes</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input habilitations_dossiers" type="checkbox" role="switch" id="affichage_dossier_constantes_input" value="AFF_DOS_CSTS;" <?= in_array('AFF_DOS_CSTS', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_DOSS', $habilitations_modules, true) ? 'disabled': null;?>>
                                            <label class="form-check-label" for="affichage_dossier_constantes_input"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input habilitations_dossiers" type="checkbox" role="switch" id="edition_dossier_constantes_input" value="EDT_DOS_CSTS;" <?= in_array('EDT_DOS_CSTS', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_DOSS', $habilitations_modules, true) ? 'disabled': null;?>>
                                            <label class="form-check-label" for="edition_dossier_constantes_input"></label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Médecin traitant</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input habilitations_dossiers" type="checkbox" role="switch" id="affichage_dossier_medecin_traitant_input" value="AFF_DOS_MEDTRT;" <?= in_array('AFF_DOS_MEDTRT', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_DOSS', $habilitations_modules, true) ? 'disabled': null;?>>
                                            <label class="form-check-label" for="affichage_dossier_medecin_traitant_input"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input habilitations_dossiers" type="checkbox" role="switch" id="edition_dossier_medecin_traitant_input" value="EDT_DOS_MEDTRT;" <?= in_array('EDT_DOS_MEDTRT', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_DOSS', $habilitations_modules, true) ? 'disabled': null;?>>
                                            <label class="form-check-label" for="edition_dossier_medecin_traitant_input"></label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Plaintes</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input habilitations_dossiers" type="checkbox" role="switch" id="affichage_dossier_plaintes_input" value="AFF_DOS_PLTS;" <?= in_array('AFF_DOS_PLTS', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_DOSS', $habilitations_modules, true) ? 'disabled': null;?>>
                                            <label class="form-check-label" for="affichage_dossier_plaintes_input"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input habilitations_dossiers" type="checkbox" role="switch" id="edition_dossier_plaintes_input" value="EDT_DOS_PLTS;" <?= in_array('EDT_DOS_PLTS', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_DOSS', $habilitations_modules, true) ? 'disabled': null;?>>
                                            <label class="form-check-label" for="edition_dossier_plaintes_input"></label>
                                        </div>
                                    </td>
                                </tr>


                                <tr>
                                    <td>Diagnostic</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input habilitations_dossiers" type="checkbox" role="switch" id="affichage_dossier_diagnostic_input" value="AFF_DOS_DGTC;" <?= in_array('AFF_DOS_DGTC', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_DOSS', $habilitations_modules, true) ? 'disabled': null;?>>
                                            <label class="form-check-label" for="affichage_dossier_diagnostic_input"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input habilitations_dossiers" type="checkbox" role="switch" id="edition_dossier_diagnostic_input" value="EDT_DOS_DGTC;" <?= in_array('EDT_DOS_DGTC', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_DOSS', $habilitations_modules, true) ? 'disabled': null;?>>
                                            <label class="form-check-label" for="edition_dossier_diagnostic_input"></label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Pathologie</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input habilitations_dossiers" type="checkbox" role="switch" id="affichage_dossier_pathologie_input" value="AFF_DOS_PATHG;" <?= in_array('AFF_DOS_PATHG', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_DOSS', $habilitations_modules, true) ? 'disabled': null;?>>
                                            <label class="form-check-label" for="affichage_dossier_pathologie_input"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input habilitations_dossiers" type="checkbox" role="switch" id="edition_dossier_pathologie_input" value="EDT_DOS_PATHG;" <?= in_array('EDT_DOS_PATHG', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_DOSS', $habilitations_modules, true) ? 'disabled': null;?>>
                                            <label class="form-check-label" for="edition_dossier_pathologie_input"></label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Ordonnance</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input habilitations_dossiers" type="checkbox" role="switch" id="affichage_dossier_ordonnance_input" value="AFF_DOS_ORDO;" <?= in_array('AFF_DOS_ORDO', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_DOSS', $habilitations_modules, true) ? 'disabled': null;?>>
                                            <label class="form-check-label" for="affichage_dossier_ordonnance_input"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input habilitations_dossiers" type="checkbox" role="switch" id="edition_dossier_ordonnance_input" value="EDT_DOS_ORDO;" <?= in_array('EDT_DOS_ORDO', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_DOSS', $habilitations_modules, true) ? 'disabled': null;?>>
                                            <label class="form-check-label" for="edition_dossier_ordonnance_input"></label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Examens</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input habilitations_dossiers" type="checkbox" role="switch" id="affichage_dossier_examens_input" value="AFF_DOS_EXAMS;" <?= in_array('AFF_DOS_EXAMS', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_DOSS', $habilitations_modules, true) ? 'disabled': null;?>>
                                            <label class="form-check-label" for="affichage_dossier_examens_input"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input habilitations_dossiers" type="checkbox" role="switch" id="edition_dossier_examens_input" value="EDT_DOS_EXAMS;" <?= in_array('EDT_DOS_EXAMS', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_DOSS', $habilitations_modules, true) ? 'disabled': null;?>>
                                            <label class="form-check-label" for="edition_dossier_examens_input"></label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <?php
                foreach ($services as $service) {
                    if (in_array('PHCIE', $service, true)) {
                        ?>
                        <div class="col-sm-12" style="margin-bottom: 10px">
                            <div class="card border-dark">
                                <div class="card-header bg-indigo text-white h6">
                                    <table style="width: 100%">
                                        <tr>
                                            <td style="width: 95%"><strong><i class="bi bi-dpad-fill"></i> Pharmacie</strong></td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" id="affichage_pharmacie_input" value="AFF_PHCIE;" <?= in_array('AFF_PHCIE', $habilitations_modules, true) ? 'checked': null;?>>
                                                    <label class="form-check-label" for="affichage_pharmacie_input"></label>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm table-hover table-stripped">
                                        <tr>
                                            <td style="width: 95%"></td>
                                            <td class="align_center"><i class="bi bi-eye"></i></td>
                                            <td class="align_center"><i class="bi bi-pencil"</td>
                                        </tr>
                                        <tr>
                                            <td>Ventes</td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input habilitations_pharmacie" type="checkbox" role="switch" id="affichage_pharmacie_ventes_input" value="AFF_PHCIE_VNTS;" <?= in_array('AFF_PHCIE_VNTS', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_PHCIE', $habilitations_modules, true) ? 'disabled': null;?>>
                                                    <label class="form-check-label" for="affichage_pharmacie_ventes_input"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input habilitations_pharmacie" type="checkbox" role="switch" id="edition_pharmacie_ventes_input" value="EDT_PHCIE_VNTS;" <?= in_array('EDT_PHCIE_VNTS', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_PHCIE', $habilitations_modules, true) ? 'disabled': null;?>>
                                                    <label class="form-check-label" for="edition_pharmacie_ventes_input"></label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 95%">Produits</td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input habilitations_pharmacie" type="checkbox" role="switch" id="affichage_pharmacie_produits_input" value="AFF_PHCIE_PDTS;" <?= in_array('AFF_PHCIE_PDTS', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_PHCIE', $habilitations_modules, true) ? 'disabled': null;?>>
                                                    <label class="form-check-label" for="affichage_pharmacie_produits_input"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input habilitations_pharmacie" type="checkbox" role="switch" id="edition_pharmacie_produits_input" value="EDT_PHCIE_PDTS;" <?= in_array('EDT_PHCIE_PDTS', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_PHCIE', $habilitations_modules, true) ? 'disabled': null;?>>
                                                    <label class="form-check-label" for="edition_pharmacie_produits_input"></label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 95%">Commandes</td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input habilitations_pharmacie" type="checkbox" role="switch" id="affichage_pharmacie_commandes_input" value="AFF_PHCIE_CMDS;" <?= in_array('AFF_PHCIE_CMDS', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_PHCIE', $habilitations_modules, true) ? 'disabled': null;?>>
                                                    <label class="form-check-label" for="affichage_pharmacie_commandes_input"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input habilitations_pharmacie" type="checkbox" role="switch" id="edition_pharmacie_commandes_input" value="EDT_PHCIE_CMDS;" <?= in_array('EDT_PHCIE_CMDS', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_PHCIE', $habilitations_modules, true) ? 'disabled': null;?>>
                                                    <label class="form-check-label" for="edition_pharmacie_commandes_input"></label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 95%">Stock</td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input habilitations_pharmacie" type="checkbox" role="switch" id="affichage_pharmacie_stock_input" value="AFF_PHCIE_STK;" <?= in_array('AFF_PHCIE_STK', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_PHCIE', $habilitations_modules, true) ? 'disabled': null;?>>
                                                    <label class="form-check-label" for="affichage_pharmacie_stock_input"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" id="edition_pharmacie_stock_input" value="EDT_PHCIE_STK;" <?= in_array('EDT_PHCIE_STK', $habilitations_sous_modules, true) ? 'checked': null;?> disabled>
                                                    <label class="form-check-label" for="edition_pharmacie_stock_input"></label>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
                <div class="col-sm-12" style="margin-bottom: 10px">
                    <div class="card border-dark">
                        <div class="card-header bg-indigo text-white h6">
                            <table style="width: 100%">
                                <tr>
                                    <td style="width: 95%"><strong><i class="bi bi-question-circle"></i> Support</strong></td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="affichage_supports_input" value="AFF_SPPTS;" <?= in_array('AFF_SPPTS', $habilitations_modules, true) ? 'checked': null;?>>
                                            <label class="form-check-label" for="affichage_supports_input"></label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-hover table-stripped">
                                <tr>
                                    <td style="width: 95%"></td>
                                    <td class="align_center"><i class="bi bi-eye"></i></td>
                                    <td class="align_center"><i class="bi bi-pencil"</td>
                                </tr>
                                <tr>
                                    <td>Support</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input habilitations_support" type="checkbox" role="switch" id="affichage_support_input" value="AFF_SPPT;" <?= in_array('AFF_SPPT', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_SPPTS', $habilitations_modules, true) ? 'disabled': null;?>>
                                            <label class="form-check-label" for="affichage_support_input"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input habilitations_support" type="checkbox" role="switch" id="edition_support_input" value="EDT_SPPT;" <?= in_array('EDT_SPPT', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_SPPTS', $habilitations_modules, true) ? 'disabled': null;?>>
                                            <label class="form-check-label" for="edition_support_input"></label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="row">
                <div class="col-sm-12" style="margin-bottom: 10px">
                    <div class="card border-dark">
                        <div class="card-header bg-indigo text-white h6">
                            <table style="width: 100%">
                                <tr>
                                    <td style="width: 95%"><strong><i class="bi bi-journal-check"></i> Factures</strong></td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="affichage_factures_input" value="AFF_FCTS;" <?= in_array('AFF_FCTS', $habilitations_modules, true) ? 'checked': null;?>>
                                            <label class="form-check-label" for="affichage_factures_input"></label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-hover table-stripped">
                                <tr>
                                    <td style="width: 95%"></td>
                                    <td class="align_center"><i class="bi bi-eye"></i></td>
                                    <td class="align_center"><i class="bi bi-pencil"</td>
                                </tr>
                                <tr>
                                    <td>Facture</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input habilitations_factures" type="checkbox" role="switch" id="affichage_facture_input" value="AFF_FCT;" <?= in_array('AFF_FCT', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_FCTS', $habilitations_modules, true) ? 'disabled': null;?>>
                                            <label class="form-check-label" for="affichage_facture_input"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input habilitations_factures" type="checkbox" role="switch" id="edition_facture_input" value="EDT_FCT;" <?= in_array('EDT_FCT', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_FCTS', $habilitations_modules, true) ? 'disabled': null;?>>
                                            <label class="form-check-label" for="edition_facture_input"></label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Bordereaux</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input habilitations_factures" type="checkbox" role="switch" id="affichage_factures_bordereaux_input" value="AFF_FCTS_BRDRS;" <?= in_array('AFF_FCTS_BRDRS', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_FCTS', $habilitations_modules, true) ? 'disabled': null;?>>
                                            <label class="form-check-label" for="affichage_factures_bordereaux_input"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input habilitations_factures" type="checkbox" role="switch" id="edition_factures_bordereaux_input" value="EDT_FCTS_BRDRS;" <?= in_array('EDT_FCTS_BRDRS', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_FCTS', $habilitations_modules, true) ? 'disabled': null;?>>
                                            <label class="form-check-label" for="edition_factures_bordereaux_input"></label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12" style="margin-bottom: 10px">
                    <div class="card border-dark">
                        <div class="card-header bg-indigo text-white h6">
                            <table style="width: 100%">
                                <tr>
                                    <td style="width: 95%"><strong><i class="bi bi-person-rolodex"></i> Professionnels de santé</strong></td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="affichage_professionnels_sante_input" value="AFF_PFSS;" <?= in_array('AFF_PFSS', $habilitations_modules, true) ? 'checked': null;?>>
                                            <label class="form-check-label" for="affichage_professionnels_sante_input"></label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-hover table-stripped">
                                <tr>
                                    <td style="width: 95%"></td>
                                    <td class="align_center"><i class="bi bi-eye"></i></td>
                                    <td class="align_center"><i class="bi bi-pencil"</td>
                                </tr>
                                <tr>
                                    <td>Professionnel de santé</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input habilitations_professionnels_sante" type="checkbox" role="switch" id="affichage_professionnel_sante_input" value="AFF_PFS;" <?= in_array('AFF_PFS', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_PFSS', $habilitations_modules, true) ? 'disabled': null;?>>
                                            <label class="form-check-label" for="affichage_professionnel_sante_input"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input habilitations_professionnels_sante" type="checkbox" role="switch" id="edition_professionnel_sante_input" value="EDT_PFS;" <?= in_array('EDT_PFS', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_PFSS', $habilitations_modules, true) ? 'disabled': null;?>>
                                            <label class="form-check-label" for="edition_professionnel_sante_input"></label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12" style="margin-bottom: 10px">
                    <div class="card border-dark">
                        <div class="card-header bg-indigo text-white h6">
                            <table style="width: 100%">
                                <tr>
                                    <td style="width: 95%"><strong><i class="bi bi-info-circle"></i> A propos</strong></td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="affichage_a_proposs_input" value="AFF_APRPS;" <?= in_array('AFF_APRPS', $habilitations_modules, true) ? 'checked': null;?>>
                                            <label class="form-check-label" for="affichage_a_proposs_input"></label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-hover table-stripped">
                                <tr>
                                    <td style="width: 95%"></td>
                                    <td class="align_center"><i class="bi bi-eye"></i></td>
                                    <td class="align_center"><i class="bi bi-pencil"</td>
                                </tr>
                                <tr>
                                    <td>A propos</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input habilitations_a_propos" type="checkbox" role="switch" id="affichage_a_propos_input" value="AFF_APRP;" <?= in_array('AFF_APRP', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_APRPS', $habilitations_modules, true) ? 'disabled': null;?>>
                                            <label class="form-check-label" for="affichage_a_propos_input"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input habilitations_a_propos" type="checkbox" role="switch" id="edition_a_propos_input" value="EDT_APRP;" <?= in_array('EDT_APRP', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_APRPS', $habilitations_modules, true) ? 'disabled': null;?>>
                                            <label class="form-check-label" for="edition_a_propos_input"></label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <?php
                foreach ($services as $service) {
                    if (in_array('ADMI', $service, true)) {
                        ?>
                        <div class="col-sm-12" style="margin-bottom: 10px">
                            <div class="card border-dark">
                                <div class="card-header bg-indigo text-white h6">
                                    <table style="width: 100%">
                                        <tr>
                                            <td style="width: 95%"><strong><i class="bi bi-view-list"></i> Admissions</strong></td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" id="affichage_admissions_input" value="AFF_ADMIS;" <?= in_array('AFF_ADMIS', $habilitations_modules, true) ? 'checked': null;?>>
                                                    <label class="form-check-label" for="affichage_admissions_input"></label>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm table-hover table-stripped">
                                        <tr>
                                            <td style="width: 95%"></td>
                                            <td class="align_center"><i class="bi bi-eye"></i></td>
                                            <td class="align_center"><i class="bi bi-pencil"</td>
                                        </tr>
                                        <tr>
                                            <td>Admission patients</td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input habilitations_admissions" type="checkbox" role="switch" id="affichage_admission_patients_input" value="AFF_ADMI_PTS;" <?= in_array('AFF_ADMI_PTS', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_ADMIS', $habilitations_modules, true) ? 'disabled': null;?>>
                                                    <label class="form-check-label" for="affichage_admission_patients_input"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input habilitations_admissions" type="checkbox" role="switch" id="edition_admission_patients_input" value="EDT_ADMI_PTS;" <?= in_array('EDT_ADMI_PTS', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_ADMIS', $habilitations_modules, true) ? 'disabled': null;?>>
                                                    <label class="form-check-label" for="edition_admission_patients_input"></label>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
        <div class="col">
            <div class="row">
                <div class="col-sm-12" style="margin-bottom: 10px">
                    <div class="card border-dark">
                        <div class="card-header bg-indigo text-white h6">
                            <table style="width: 100%">
                                <tr>
                                    <td style="width: 95%"><strong><i class="bi bi-cash-coin"></i> Comptabilité</strong></td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="affichage_comptabilites_input" value="AFF_CPTS;" <?= in_array('AFF_CPTS', $habilitations_modules, true) ? 'checked': null;?>>
                                            <label class="form-check-label" for="affichage_comptabilites_input"></label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-hover table-stripped">
                                <tr>
                                    <td style="width: 95%"></td>
                                    <td class="align_center"><i class="bi bi-eye"></i></td>
                                    <td class="align_center"><i class="bi bi-pencil"</td>
                                </tr>
                                <tr>
                                    <td>Comptabilité</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input habilitations_comptabilite" type="checkbox" role="switch" id="affichage_comptabilite_input" value="AFF_CPT;" <?= in_array('AFF_CPT', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_CPTS', $habilitations_modules, true) ? 'disabled': null;?>>
                                            <label class="form-check-label" for="affichage_comptabilite_input"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input habilitations_comptabilite" type="checkbox" role="switch" id="edition_comptabilite_input" value="EDT_CPT;" <?= in_array('EDT_CPT', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_CPTS', $habilitations_modules, true) ? 'disabled': null;?>>
                                            <label class="form-check-label" for="edition_comptabilite_input"></label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12" style="margin-bottom: 10px">
                    <div class="card border-dark">
                        <div class="card-header bg-indigo text-white h6">
                            <table style="width: 100%">
                                <tr>
                                    <td style="width: 95%"><strong><i class="bi bi-calendar2-week"></i> Rendez-vous</strong></td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="affichage_rendez_vouss_input" value="AFF_RDVS;" <?= in_array('AFF_RDVS', $habilitations_modules, true) ? 'checked': null;?>>
                                            <label class="form-check-label" for="affichage_rendez_vouss_input"></label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-hover table-stripped">
                                <tr>
                                    <td style="width: 95%"></td>
                                    <td class="align_center"><i class="bi bi-eye"></i></td>
                                    <td class="align_center"><i class="bi bi-pencil"</td>
                                </tr>
                                <tr>
                                    <td>Rendez-vous</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input habilitations_rendez_vous" type="checkbox" role="switch" id="affichage_rendez_vous_input" value="AFF_RDV;" <?= in_array('AFF_RDV', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_RDVS', $habilitations_modules, true) ? 'disabled': null;?>>
                                            <label class="form-check-label" for="affichage_rendez_vous_input"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input habilitations_rendez_vous" type="checkbox" role="switch" id="edition_rendez_vous_input" value="EDT_RDV;" <?= in_array('EDT_RDV', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_RDVS', $habilitations_modules, true) ? 'disabled': null;?>>
                                            <label class="form-check-label" for="edition_rendez_vous_input"></label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <?php
                foreach ($services as $service) {
                    if (in_array('LABO', $service, true)) {
                        ?>
                        <div class="col-sm-12" style="margin-bottom: 10px">
                            <div class="card border-dark">
                                <div class="card-header bg-indigo text-white h6">
                                    <table style="width: 100%">
                                        <tr>
                                            <td style="width: 95%"><strong><i class="bi bi-gear-wide-connected"></i> Laboratoire</strong></td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" id="affichage_laboratoires_input" value="AFF_LABOS;" <?= in_array('AFF_LABOS', $habilitations_modules, true) ? 'checked': null;?>>
                                                    <label class="form-check-label" for="affichage_laboratoires_input"></label>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm table-hover table-stripped">
                                        <tr>
                                            <td style="width: 95%"></td>
                                            <td class="align_center"><i class="bi bi-eye"></i></td>
                                            <td class="align_center"><i class="bi bi-pencil"</td>
                                        </tr>
                                        <tr>
                                            <td>Examens</td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input habilitations_laboratoire" type="checkbox" role="switch" id="affichage_examens_input" value="AFF_EXAM;" <?= in_array('AFF_EXAM', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_LABOS', $habilitations_modules, true) ? 'disabled': null;?>>
                                                    <label class="form-check-label" for="affichage_examens_input"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input habilitations_laboratoire" type="checkbox" role="switch" id="edition_examens_input" value="EDT_EXAM;" <?= in_array('EDT_EXAM', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_LABOS', $habilitations_modules, true) ? 'disabled': null;?>>
                                                    <label class="form-check-label" for="edition_examens_input"></label>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
                <div class="col-sm-12" style="margin-bottom: 10px">
                    <div class="card border-dark">
                        <div class="card-header bg-indigo text-white h6">
                            <table style="width: 100%">
                                <tr>
                                    <td style="width: 95%"><strong><i class="bi bi-gear-wide-connected"></i> Paramètres</strong></td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="affichage_parametres_input" value="AFF_PRMTRS;" <?= in_array('AFF_PRMTRS', $habilitations_modules, true) ? 'checked': null;?>>
                                            <label class="form-check-label" for="affichage_parametres_input"></label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-hover table-stripped">
                                <tr>
                                    <td style="width: 95%"></td>
                                    <td class="align_center"><i class="bi bi-eye"></i></td>
                                    <td class="align_center"><i class="bi bi-pencil"</td>
                                </tr>
                                <tr>
                                    <td>Panier de soins</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input habilitations_parametres" type="checkbox" role="switch" id="affichage_parametres_panier_soins_input" value="AFF_PRMTRS_PNS;" <?= in_array('AFF_PRMTRS_PNS', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_PRMTRS', $habilitations_modules, true) ? 'disabled': null;?>>
                                            <label class="form-check-label" for="affichage_parametres_panier_soins_input"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input habilitations_parametres" type="checkbox" role="switch" id="edition_parametres_panier_soins_input" value="EDT_PRMTRS_PNS;" <?= in_array('EDT_PRMTRS_PNS', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_PRMTRS', $habilitations_modules, true) ? 'disabled': null;?>>
                                            <label class="form-check-label" for="edition_parametres_panier_soins_input"></label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Profils utilisateurs</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input habilitations_parametres" type="checkbox" role="switch" id="affichage_parametres_profils_utilisateurs_input" value="AFF_PRMTRS_PRFUT;" <?= in_array('AFF_PRMTRS_PRFUT', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_PRMTRS', $habilitations_modules, true) ? 'disabled': null;?>>
                                            <label class="form-check-label" for="affichage_parametres_profils_utilisateurs_input"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input habilitations_parametres" type="checkbox" role="switch" id="edition_parametres_profils_utilisateurs_input" value="EDT_PRMTRS_PRFUT;" <?= in_array('EDT_PRMTRS_PRFUT', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_PRMTRS', $habilitations_modules, true) ? 'disabled': null;?>>
                                            <label class="form-check-label" for="edition_parametres_profils_utilisateurs_input"></label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Utilisateurs</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input habilitations_parametres" type="checkbox" role="switch" id="affichage_parametres_utilisateurs_input" value="AFF_PRMTRS_UT;" <?= in_array('AFF_PRMTRS_UT', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_PRMTRS', $habilitations_modules, true) ? 'disabled': null;?>>
                                            <label class="form-check-label" for="affichage_parametres_utilisateurs_input"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input habilitations_parametres" type="checkbox" role="switch" id="edition_parametres_utilisateurs_input" value="EDT_PRMTRS_UT;" <?= in_array('EDT_PRMTRS_UT', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_PRMTRS', $habilitations_modules, true) ? 'disabled': null;?>>
                                            <label class="form-check-label" for="edition_parametres_utilisateurs_input"></label>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                foreach ($services as $service) {
                                    if (in_array('ADMI', $service, true)) {
                                        ?>
                                        <tr>
                                            <td style="width: 95%">Gestion des chambres</td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input habilitations_parametres" type="checkbox" role="switch" id="affichage_parametres_chambres_input" value="AFF_PRMTRS_CHBRS;" <?= in_array('AFF_PRMTRS_CHBRS', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_ADMIS', $habilitations_modules, true) ? 'disabled': null;?>>
                                                    <label class="form-check-label" for="affichage_parametres_chambres_input"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input habilitations_parametres" type="checkbox" role="switch" id="edition_parametres_chambres_input" value="EDT_PRMTRS_CHBRS;" <?= in_array('EDT_PRMTRS_CHBRS', $habilitations_sous_modules, true) ? 'checked': null;?> <?= !in_array('AFF_ADMIS', $habilitations_modules, true) ? 'disabled': null;?>>
                                                    <label class="form-check-label" for="edition_parametres_chambres_input"></label>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><hr />
    <div class="row">
        <div class="col-md-2 d-grid">
            <input type="hidden" id="code_profil_input" value="<?= $profil_utilisateur['code'];?>">
            <button type="submit" id="button_habilitations_enregistrer" class="btn btn-primary btn-sm btn-block"><i class="bi bi-save"></i> Enregistrer</button>
        </div>
        <div class="col-md-2 d-grid">
            <button type="button" id="button_habilitations_retourner" class="btn btn-dark btn-sm btn-block"><i class="bi bi-arrow-left-square"></i> Retourner</button>
        </div>
    </div>
</form>
