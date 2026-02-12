@php \Carbon\Carbon::setLocale('fr'); @endphp
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificat d'Habitation - {{ $certificat->habitant->nom }} {{ $certificat->habitant->prenom }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Times+New+Roman&family=Noto+Serif:wght@400;700&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background: #D5D5D5;
            font-family: 'Noto Serif', 'Times New Roman', Georgia, serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 30px 15px;
            min-height: 100vh;
            color: #000;
        }

        /* ===== BOUTONS D'ACTION (non imprimés) ===== */
        .actions-bar {
            display: flex;
            gap: 12px;
            margin-bottom: 25px;
            flex-wrap: wrap;
            justify-content: center;
        }
        .actions-bar .btn {
            padding: 10px 24px;
            border: none;
            border-radius: 6px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
            color: #fff;
        }
        .btn-back { background: #333; }
        .btn-back:hover { background: #111; }
        .btn-download { background: #1a6b1a; }
        .btn-download:hover { background: #145214; }
        .btn-print { background: #555; }
        .btn-print:hover { background: #333; }

        /* ===== PAGE DU CERTIFICAT ===== */
        .certificat-page {
            width: 210mm;
            min-height: 297mm;
            background: #fff;
            position: relative;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
            padding: 15mm 20mm 20mm 20mm;
            display: flex;
            flex-direction: column;
        }

        /* Bordure double noire formelle */
        .certificat-page::before {
            content: '';
            position: absolute;
            top: 8mm; left: 8mm; right: 8mm; bottom: 8mm;
            border: 2px solid #000;
            pointer-events: none;
        }
        .certificat-page::after {
            content: '';
            position: absolute;
            top: 10mm; left: 10mm; right: 10mm; bottom: 10mm;
            border: 0.5px solid #000;
            pointer-events: none;
        }

        /* ===== DRAPEAU DU SÉNÉGAL ===== */
        .drapeau {
            display: flex;
            width: 72px;
            height: 48px;
            margin: 0 auto 6px auto;
            border: 1px solid #ccc;
            overflow: hidden;
        }
        .drapeau-vert {
            width: 33.33%;
            background: #00853F;
            position: relative;
        }
        .drapeau-jaune {
            width: 33.33%;
            background: #FDEF42;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .drapeau-jaune .etoile {
            color: #00853F;
            font-size: 22px;
            line-height: 1;
        }
        .drapeau-rouge {
            width: 33.34%;
            background: #E31B23;
        }

        /* ===== EN-TÊTE OFFICIEL ===== */
        .entete {
            text-align: center;
            margin-bottom: 6mm;
        }
        .entete .republique {
            font-size: 18px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: #000;
            margin-bottom: 2px;
        }
        .entete .devise {
            font-size: 12px;
            font-style: italic;
            color: #000;
            margin-bottom: 1mm;
        }
        .entete .tirets {
            font-size: 11px;
            color: #000;
            letter-spacing: 4px;
        }

        /* Ligne de séparation */
        .ligne-sep {
            border: none;
            border-top: 1.5px solid #000;
            width: 50%;
            margin: 4mm auto;
        }

        /* Sous-en-tête (Ministère / Mairie) */
        .sous-entete {
            text-align: center;
            margin-bottom: 5mm;
        }
        .sous-entete .ministere {
            font-size: 11px;
            color: #000;
        }
        .sous-entete .direction {
            font-size: 10px;
            color: #333;
            margin-top: 1px;
        }
        .sous-entete .commune {
            font-size: 13px;
            font-weight: 700;
            color: #000;
            margin-top: 3px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* ===== TITRE DU CERTIFICAT ===== */
        .titre-certificat {
            text-align: center;
            margin: 8mm 0;
        }
        .titre-certificat h1 {
            font-size: 24px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 5px;
            color: #000;
            border-top: 2px solid #000;
            border-bottom: 2px solid #000;
            display: inline-block;
            padding: 3mm 8mm;
            margin: 0;
        }

        /* Numéro */
        .numero {
            text-align: center;
            font-size: 11px;
            color: #000;
            margin-bottom: 8mm;
        }

        /* ===== CORPS DU CERTIFICAT ===== */
        .corps {
            flex: 1;
            font-size: 13px;
            line-height: 2.2;
            color: #000;
            text-align: justify;
        }

        .corps p {
            margin-bottom: 5mm;
            text-indent: 10mm;
        }

        .corps .soussigne {
            text-indent: 10mm;
        }

        .corps .certification {
            margin-top: 6mm;
            text-indent: 10mm;
        }

        .corps .usage {
            text-indent: 10mm;
        }

        .corps strong {
            text-decoration: underline;
        }

        /* ===== SIGNATURE ===== */
        .signature-zone {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-top: 12mm;
            padding-top: 5mm;
        }

        .signature-gauche {
            font-size: 12px;
            color: #000;
        }

        .signature-droite {
            text-align: center;
            font-size: 12px;
            color: #000;
        }

        .signature-droite .titre-sign {
            font-weight: 700;
            font-size: 13px;
            margin-bottom: 25mm;
        }

        .signature-droite .ligne-sign {
            width: 160px;
            border-bottom: 1px solid #000;
            margin: 0 auto 2mm auto;
        }

        .signature-droite .mention-sign {
            font-size: 10px;
            font-style: italic;
        }

        /* Cachet */
        .cachet-zone {
            position: absolute;
            bottom: 50mm;
            left: 50%;
            transform: translateX(-50%);
            width: 70px;
            height: 70px;
            border: 2px solid rgba(0,0,0,0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
            color: rgba(0,0,0,0.2);
            font-weight: 700;
            text-transform: uppercase;
            text-align: center;
            letter-spacing: 1px;
        }

        /* Pied de page */
        .pied-page {
            position: absolute;
            bottom: 10mm;
            left: 22mm;
            right: 22mm;
            text-align: center;
            font-size: 8px;
            color: #666;
            border-top: 1px solid #000;
            padding-top: 2mm;
        }

        /* ===== IMPRESSION ===== */
        @media print {
            body {
                background: white;
                padding: 0;
                margin: 0;
            }
            .actions-bar {
                display: none !important;
            }
            .certificat-page {
                box-shadow: none;
                width: 100%;
                margin: 0;
            }
            @page {
                size: A4;
                margin: 0;
            }
        }

        /* Responsive */
        @media (max-width: 800px) {
            .certificat-page {
                width: 100%;
                min-height: auto;
                padding: 10mm 12mm;
            }
            .corps .identite-ligne {
                flex-direction: column;
            }
            .corps .identite-label {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <!-- Barre d'actions -->
    <div class="actions-bar">
        <a href="{{ isset($isHabitantView) && $isHabitantView ? route('habitant.dashboard') : route('certificats.index') }}" class="btn btn-back">
            <i class="bi bi-arrow-left"></i> Retour {{ isset($isHabitantView) && $isHabitantView ? 'au tableau de bord' : 'à la liste' }}
        </a>
        <button onclick="window.print()" class="btn btn-download">
            <i class="bi bi-download"></i> Télécharger PDF
        </button>
        <button onclick="window.print()" class="btn btn-print">
            <i class="bi bi-printer"></i> Imprimer
        </button>
    </div>

    <!-- ===== CERTIFICAT ===== -->
    <div class="certificat-page">

        <!-- Drapeau du Sénégal -->
        <div class="drapeau">
            <div class="drapeau-vert"></div>
            <div class="drapeau-jaune"><span class="etoile">★</span></div>
            <div class="drapeau-rouge"></div>
        </div>

        <!-- En-tête officiel -->
        <div class="entete">
            <div class="republique">République du Sénégal</div>
            <div class="devise">Un Peuple – Un But – Une Foi</div>
            <div class="tirets">- - - - - - - - -</div>
        </div>

        <hr class="ligne-sep">

        <!-- Sous-en-tête -->
        <div class="sous-entete">
            <div class="ministere">Ministère de l'Intérieur et de la Sécurité publique</div>
            <div class="direction">Direction des Collectivités territoriales</div>
            <div class="commune">Mairie de la Commune</div>
        </div>

        <hr class="ligne-sep">

        <!-- Titre -->
        <div class="titre-certificat">
            <h1>Certificat d'Habitation</h1>
        </div>

        <!-- Numéro -->
        <div class="numero">
            N° CH-{{ str_pad($certificat->id, 5, '0', STR_PAD_LEFT) }}/{{ \Carbon\Carbon::parse($certificat->date_certificat)->format('Y') }}
        </div>

        <!-- Corps du certificat -->
        <div class="corps">

            <p class="soussigne">
                Le Maire de la Commune, Officier de l'État civil,
            </p>

            <p>
                Certifie que le (la) nommé(e) <strong>{{ strtoupper($certificat->habitant->nom) }} {{ ucfirst($certificat->habitant->prenom) }}</strong>,
                né(e) le <strong>{{ \Carbon\Carbon::parse($certificat->habitant->date_naissance)->translatedFormat('d F Y') }}</strong>,
                demeurant au quartier <strong>{{ $certificat->habitant->quartier }}</strong>,
                joignable au <strong>{{ $certificat->habitant->telephone }}</strong>,
                réside effectivement à l'adresse ci-dessus indiquée sur le territoire de la commune.
            </p>

            <p class="certification">
                En foi de quoi, le présent <strong>Certificat d'Habitation</strong> lui est délivré
                pour servir et valoir ce que de droit.
            </p>

        </div>

        <!-- Zone de signature -->
        <div class="signature-zone">
            <div class="signature-gauche">
                Fait à ________________, le <strong>{{ \Carbon\Carbon::parse($certificat->date_certificat)->translatedFormat('d F Y') }}</strong>
            </div>
            <div class="signature-droite">
                <div class="titre-sign">Le Maire</div>
                <div class="ligne-sign"></div>
                <div class="mention-sign">Signature et cachet</div>
            </div>
        </div>

        <!-- Cachet -->
        <div class="cachet-zone">Cachet<br>officiel</div>

        <!-- Pied de page -->
        <div class="pied-page">
            Document administratif officiel — Certificat N° CH-{{ str_pad($certificat->id, 5, '0', STR_PAD_LEFT) }}/{{ \Carbon\Carbon::parse($certificat->date_certificat)->format('Y') }}
            — Délivré le {{ \Carbon\Carbon::parse($certificat->date_certificat)->translatedFormat('d F Y') }} — République du Sénégal
        </div>

    </div>

</body>
</html>
