<?php

return [
    "title" => "Note",
    "single" => "Nota",
    "group" => "",
    "pages" => [
        "groups" => "Gestisci Note Groups",
        "status" => "Gestisci Note Status"
    ],
    "columns" => [
        "title" => "Titolo",
        "body" => "Testo",
        "date" => "Data",
        "time" => "Ora",
        "is_pined" => "Importante",
        "is_public" => "Pubblica",
        "icon" => "Icona",
        "background" => "Sfondo",
        "border" => "Bordo",
        "color" => "Colore",
        "font_size" => "Dimensione Font",
        "font" => "Font",
        "group" => "Gruppo",
        "status" => "Stato",
        "user_id" => "ID Utente",
        "user_type" => "Tipo Utente",
        "model_id" => "ID Modello",
        "model_type" => "Tipo Modello",
        "created_at" => "Created At",
        "updated_at" => "Updated At"
    ],
    "tabs" => [
        "general" => "Generale",
        "style" => "Stile"
    ],
    "actions" => [
        "view" => "Vedi",
        "edit" => "Modifica",
        "delete" => "Elimina",
        "notify" => [
            "label" => "Notifica Utente",
            "notification" => [
                "title" => "Notifica Inviata",
                "body" => "La notifica è stata inviata."
            ]
        ],
        "share" => [
            "label" => "Condividi Nota",
            "notification" => [
                "title" => "Link Creato",
                "body" => "Il link alla nota condivisa è stato creato e copiato negli appunti."
            ]
        ],
        "user_access" => [
            "label" => "Accesso Utente",
            "form" => [
                "model_id" => "Utente",
                "model_type" => "Tipo Utente",
            ],
            "notification" => [
                "title" => "User Access Updated",
                "body" => "The user access has been updated."
            ]
        ],
        "checklist"=> [
            "label" => "Add Checklist",
            "form" => [
                "checklist"=> "Checklist"
            ],
            "state" => [
                "done" => "Done",
                "pending" => "Pending"
            ],
            "notification" => [
                "title" => "Checklist Updated",
                "body" => "The checklist has been updated.",
                "updated" => [
                    "title" => "Checklist Item Updated",
                    "body" => "The checklist item has been updated."
                ],
            ]
        ]
    ],
    "notifications" => [
        "edit" => [
            "title" => "Note Updated",
            "body" => "The note has been updated."
        ],
        "delete" => [
            "title" => "Note Deleted",
            "body" => "The note has been deleted."
        ]
    ]
];
