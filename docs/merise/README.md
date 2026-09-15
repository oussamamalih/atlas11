# TalentX11 — Conception Merise (MCD / MLD)

Documentation officielle de conception de la base de données **TalentX11** (plateforme de détection de talents footballistique).

## Livrables

| # | Livrable | Fichier |
|---|---|---|
| 1 | **MCD** — modèle conceptuel de données (6 entités métier) | [`MCD.md`](MCD.md) · diagramme [`MCD.svg`](MCD.svg) |
| 2 | **MLD** — modèle logique de données (6 tables relationnelles) | [`MLD.md`](MLD.md) · diagramme [`MLD.svg`](MLD.svg) |
| 3 | **Documentation** — explications et validation | [`DOCUMENTATION.md`](DOCUMENTATION.md) |
| 4 | **Légende** — symboles, cardinalités, polymorphisme | [`LEGEND.md`](LEGEND.md) |
| 5 | Sources Mermaid (régénération) | [`mcd-source.mmd`](mcd-source.mmd) · [`mld-source.mmd`](mld-source.mmd) |

## Périmètre

- Les diagrammes couvrent **les 6 tables métier uniquement** : `users`, `player_profiles`, `scout_profiles`, `scouting_interests`, `favorites`, `notifications`.
- **Exclues** : les 7 tables framework Laravel (`password_reset_tokens`, `sessions`, `cache`, `cache_locks`, `jobs`, `job_batches`, `failed_jobs`) et les 5 tables Spatie inutilisées (`roles`, `permissions`, `model_has_roles`, `model_has_permissions`, `role_has_permissions`). — **18 tables au total en base.**
- Aucune modification de migrations, modèles, contrôleurs, routes ou schéma n'est requise pour ce livrable.

## Aperçu des diagrammes

![MCD](MCD.svg)

![MLD](MLD.svg)

## Vue d'ensemble

```
UTILISATEUR
 ├── (0,1)──(1,1)  PROFIL_JOUEUR
 ├── (0,1)──(1,1)  PROFIL_SCOUT
 ├── (0,N)──(1,1)  INTERET_DE_SCOUT  ⟷  (0,N)──(1,1)  PROFIL_JOUEUR
 ├── (0,N)──(1,1)  FAVORI            ⟷  (0,N)──(1,1)  PROFIL_JOUEUR
 └── (0,N)──(1,1)  NOTIFICATION (polymorphique, aucune FK)
```