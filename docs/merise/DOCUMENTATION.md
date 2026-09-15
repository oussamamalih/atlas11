# TalentX11 — Documentation du modèle de données

> Documentation d'accompagnement des livrables MCD / MLD (conception Merise) pour **TalentX11**, plateforme de détection de talents footballistique.

---

## 1. Architecture de la base de données

La base de données contient **18 tables** réparties en trois catégories :

| Catégorie | Nombre | Tables |
|---|---|---|
| Tables métier TalentX11 | 6 | `users`, `player_profiles`, `scout_profiles`, `scouting_interests`, `favorites`, `notifications` |
| Tables Spatie (instalées, inutilisées) | 5 | `roles`, `permissions`, `model_has_roles`, `model_has_permissions`, `role_has_permissions` |
| Tables framework Laravel | 7 | `password_reset_tokens`, `sessions`, `cache`, `cache_locks`, `jobs`, `job_batches`, `failed_jobs` |

**Total : 18 tables.**

Les diagrammes de présentation (MCD / MLD) couvrent **uniquement les 6 tables métier**. Les tables framework et Spatie sont exclues.

---

## 2. Périmètre des livrables

| Livrable | Fichier | Contenu |
|---|---|---|
| MCD | `MCD.md` | 6 entités métier, attributs, identifiants, 7 relations et cardinalités Merise |
| MLD | `MLD.md` | 6 tables relationnelles réelles, PK/FK/UNIQUE, tables d'association |
| Légende | `LEGEND.md` | Symboles, cardinalités, référence polymorphique |
| Documentation | `DOCUMENTATION.md` | Ce document |

---

## 3. Décisions de conception MCD

1. **6 entités métier uniquement.** `UTILISATEUR` est l'entité pivot portant le **discriminant `role`** (`player`, `scout`, `admin`). Les rôles ne forment **pas** une entité : le paquet Spatie installé est inutilisé (aucun trait `HasRoles` sur le modèle, aucune donnée seedée, autorisation réalisée par middleware sur la colonne `role`).
2. **Profil joueur / profil scout = relations 1:1 optionnelles** `(0,1)–(1,1)`. Un utilisateur joueur possède au plus un profil joueur, un utilisateur scout au plus un profil scout. En base, l'unicité est garantie par `UNIQUE(user_id)`.
3. **Entités-associations** : les relations N:N conceptuelles *scout ⇄ joueur* sont transformées en **`INTERET_DE_SCOUT`** (association **riche** : `status`, `message`) et **`FAVORI`** (association **simple** : timestamps). Chacune porte son identifiant et ses clés étrangères.
4. **NOTIFICATION relation polymorphe `(0,N)–(1,1)`** : rattachement applicatif par `notifiable_type` + `notifiable_id`, **sans contrainte de clé étrangère** en base.
5. **Cycle de vie `status`** de l'intérêt : `pending` → `viewed` → `contacted` → `closed` (contrôle applicatif via constantes du modèle `ScoutingInterest`).

---

## 4. Explications des relations importantes

### R1 / R2 — Utilisateur ⇄ Profils (1:1, optionnelle côté utilisateur)
- `user_id` en contrainte **UNIQUE + FK + CASCADE**.
- La suppression d'un utilisateur supprime son profil.
- Un utilisateur `admin` ne possède aucun profil.

### R3 / R4 — Utilisateur(scout) ⇄ Intérêt de scout ⇄ Profil joueur (N:N riche)
- Un scout émet 0 à N intérêts ; un joueur reçoit 0 à N intérêts.
- `UNIQUE(scout_id, player_profile_id)` interdit le doublon.
- Cascade : suppression du scout ou du profil → suppression de l'intérêt.
- Une notification `ScoutingInterestReceived` est émise vers le joueur lors de l'intérêt.

### R5 / R6 — Utilisateur(scout) ⇄ Favori ⇄ Profil joueur (N:N simple)
- Cascade des deux côtés, `UNIQUE(scout_id, player_profile_id)` interdit le doublon.
- Exposé en Eloquent à la fois en modèle dédié (`Favorite`) et en `belongsToMany` (`favoritePlayers`).

### R7 — Utilisateur ⇄ Notification (1:N polymorphe)
- `notifiable_type` vaut toujours `App\Models\User` dans ce projet.
- Aucune FK en base ; index morph `(notifiable_type, notifiable_id)`.

---

## 5. Correspondance MLD / migrations réelles

| Table | Migration source |
|---|---|
| `users` | `0001_01_01_000000_create_users_table.php` |
| `player_profiles` | `2026_09_08_103203_create_player_profiles_table.php` |
| `scout_profiles` | `2026_09_08_103748_create_scout_profiles_table.php` |
| `scouting_interests` | `2026_09_08_104735_create_scouting_interests_table.php` |
| `notifications` | `2026_09_08_105500_create_notifications_table.php` |
| `favorites` | `2026_09_10_114500_create_favorites_table.php` |

---

## 6. Validation contre le schéma réel

- Chaque table, colonne, clé étrangère et contrainte présente dans les diagrammes a été **vérifiée** dans `database/migrations/*` ; aucune entité ou contrainte n'a été inventée.
- Contraintes FK réelles : `player_profiles.user_id`, `scout_profiles.user_id`, `scouting_interests.scout_id`, `scouting_interests.player_profile_id`, `favorites.scout_id`, `favorites.player_profile_id` — toutes en `ON DELETE CASCADE`.
- Unicités réelles : `users.email`, `player_profiles.user_id`, `scout_profiles.user_id`, `UNIQUE(scout_id, player_profile_id)` sur `scouting_interests` et `favorites`.
- Index additionnels réels : `favorites.player_profile_id`, morph index sur `notifications`.
- Les horodatages `created_at` / `updated_at` sont omis des diagrammes MCD (conceptuel) mais présents dans le MLD.

---

## 7. Écarts constatés entre migrations et modèles

1. **Spatie laravel-permission installé mais jamais utilisé** : 5 tables `roles` / `permissions` / pivots, `config/permission.php` publié, mais le modèle `User` n'utilise ni `HasRoles` ni `HasPermissions` ; aucun rôle ni permission seedé ; l'autorisation repose sur `users.role` + middlewares custom.
2. **Double représentation de `favorites`** : modèle dédié ET pivot implicite `belongsToMany` (sans `->using()`), le seeder insère en `DB::table('favorites')`.
3. **Aucune relation inverse « intérêts reçus »** sur `User` : les joueurs y accèdent via `playerProfile→scoutingInterests` (accesseur `player_user` de secours).
4. **`ScoutProfile` sans relations métier** : conteneur d'attributs pur, rattaché uniquement à `user()`.
5. **Valeurs `position` et `status`** validées côté applicatif (constantes des modèles), sans `CHECK` en base.
6. **`sessions.user_id`** indicé mais sans contrainte FK (scaffolding Laravel standard).

---

## 8. Rendu des diagrammes

Les diagrammes sont écrits en **Mermaid** (`erDiagram`) et livrés **pré-générés en SVG**
(`MCD.svg`, `MLD.svg` — rendus via `@mermaid-js/mermaid-cli`) pour une utilisation
directe en présentation (PowerPoint, Keynote, LibreOffice, documentation web).

Régénération / conversion en PNG (optionnel) :

```sh
npx -y @mermaid-js/mermaid-cli -i docs/merise/mcd-source.mmd -o docs/merise/MCD.svg -b white -w 2000
npx -y @mermaid-js/mermaid-cli -i docs/merise/mld-source.mmd -o docs/merise/MLD.svg -b white -w 2000
npx -y @mermaid-js/mermaid-cli -i docs/merise/mcd-source.mmd -o docs/merise/MCD.png -b white -s 2
```