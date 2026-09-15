# TalentX11 — Légende des diagrammes MCD & MLD

> Légende des notations utilisées dans `MCD.md` et `MLD.md`. Les symboles sont rendus par le moteur Mermaid (`erDiagram`).

---

## 1. Symboles communs (entités)

| Symbole | Signification |
|---|---|
| Nom d'entité en **MAJUSCULES** | Entité conceptuelle du MCD (ex. `UTILISATEUR`) |
| Nom en **minuscules snake_case** | Table relationnelle réelle du MLD (ex. `users`) |
| `id` souligné | **Clé primaire / identifiant** de l'entité |
| `xxx_id` souligné (trait `FK`) | **Clé étrangère** vers une autre entité/table |
| `UUID` | Identifiant primaire universel (table `notifications`) |

---

## 2. Cardinalités (notation Merise ↔ notation Mermaid)

### 2.1 Notation Merise `(min, max)`

La cardinalité est écrite **à côté de chaque entité** et indique **combien d'occurrences de l'ENTITÉ OPPOSÉE** sont rattachées à une occurrence de cette entité.

| Valeur | Sens |
|---|---|
| `(0,1)` | zéro ou une occurrence (optionnel, au plus 1) |
| `(1,1)` | exactement une occurrence (obligatoire) |
| `(0,N)` | zéro ou plusieurs occurrences (optionnel, illimité) |
| `(1,N)` | une ou plusieurs occurrences (obligatoire, illimité) |

### 2.2 Correspondance avec les symboles Mermaid (pied-de-poule)

| Merise | Symbole Mermaid | Lecture du trait |
|---|---|---|
| (0,1) | `o\|` | zéro ou un |
| (1,1) | `\|\|` | exactement un |
| (0,N) | `o{` | zéro ou plusieurs |
| (1,N) | `\|{` | un ou plusieurs |

Exemple : `UTILISATEUR ||--o| PROFIL_JOUEUR` se lit : *un UTILISATEUR possède **au plus un** PROFIL_JOUEUR, et chaque PROFIL_JOUEUR appartient à **exactement un** UTILISATEUR*.

### 2.3 Lecture correcte d'un trait

```
UTILISATEUR (0,1) ───────── (1,1) PROFIL_JOUEUR
   (max 1 profil joueur)     (1 utilisateur obligatoire)
```

---

## 3. Type de relations

| Représentation / libellé | Signification |
|---|---|
| `R1`, `R2`, … | Nom de la relation dans le MCD |
| Lien 1:1 (`\|\|--o\|`) | Relation un-à-un (profil joueur / profil scout) |
| Lien 1:N (`\|\|--o{`) | Relation un-à-plusieurs (intérêts, favoris, notifications) |
| **Entité-association** | Entité issue d'une relation N:N (porte son identifiant et ses propres attributs métier) |
| Lien étiqueté **POLYMORPHIQUE** | **Pas une contrainte de clé étrangère** — simple rattachement applicatif par la paire `notifiable_type` + `notifiable_id` |

---

## 4. Référence polymorphique (NOTIFICATION)

```
notifications.notifiable_id  ──(APPLICATIF)──►  users.id
```

- La liaison vers `users` est réalisée **par Laravel** grâce au couple `notifiable_type` + `notifiable_id`.
- **Aucune contrainte `FOREIGN KEY` n'existe en base** sur ces colonnes.
- Sur les diagrammes, elle est représentée comme une relation logique (trait plein) mais **explicitement étiquetée « POLYMORPHIQUE — aucune FK en base »**.
- Un index combiné `(notifiable_type, notifiable_id)` optimise les recherches.

---

## 5. Contraintes d'intégrité

| Symbole / badge | Signification |
|---|---|
| `UNIQUE` | Contrainte d'unicité (pas de doublon) |
| `UNIQUE(a, b)` | Unicité composite sur plusieurs colonnes |
| `FK → table.colonne` | Clé étrangère pointant vers une colonne |
| `ON DELETE CASCADE` | Suppression en cascade de la ligne liée |
| `INDEX` | Index simple (non unique) |

---

## 6. Code couleur (si l'outil de rendu le permet)

| Couleur | Entités |
|---|---|
| Bleu | Entités métier principales (utilisateur, profils) |
| Vert | Entités-associations (intérêts, favoris) |
| Orange / pointillés | Entité polymorphe (notifications) |
| Gris (non représenté) | Tables framework Laravel et Spatie inutilisées |

---

*Les tableaux détaillés par entité figurent dans `MCD.md` et `MLD.md`.*