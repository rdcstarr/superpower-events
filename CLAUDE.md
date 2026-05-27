# superpower-events — Conventions

Personal Laravel package for model lifecycle events. Six generic events (`ModelCreating`/`Created`/`Updating`/`Updated`/`Deleting`/`Deleted`) dispatched automatically via the `DispatchesModelEvents` trait; listener traits filter by model type via reflection on `handleModel()`.

## PHP / Laravel Style (litera de lege)

- **Tabs** pentru indentare (1 tab).
- **Allman braces**: opening brace pe propria linie pentru clase, metode, `if`/`foreach`/`while`/`try`.
- **Blank lines**: una înainte de `if`, `foreach`, `return`; ZERO după `{` sau înainte de `}`.
- **PHPDoc obligatoriu** pe fiecare metodă (chiar și one-liners): summary imperativ în engleză ("Build", "Handle", "Dispatch"), `@param` per parametru, `@return` cu tipul complet (`void` când nu returnează).
- **Method visibility order** în clasă: `public` → `protected` → `private`. Niciodată un `private` deasupra unui `public`.
- **Laravel helpers** peste PHP native: `Str::*`, `Arr::*`, `filled()`/`blank()`, `abort_if`, `throw_if`, `tap`, `when`, `collect()->...`. Nu mix-uiește paradigme în același fișier.
- **Flat code (early returns)**: nicio `else` după `return`. Code citește top-to-bottom.

## Architecture: Model → Trait → Event → Listener → Action

Un singur trait pe model, un singur trait pe listener. Fără dispatch manual.

- **Model** primește `use Rdcstarr\SuperpowerEvents\Concerns\DispatchesModelEvents;`. Trait-ul fan-uiește automat cele 6 evente pe hook-uri Eloquent.
- **Listener** primește unul din cele 6 trait-uri (`Concerns\ModelCreating`, `ModelCreated`, etc.) și implementează `protected function handleModel(YourModel $model): void`. Trait-ul filtrează prin reflection pe parametrul `handleModel` — **NICIODATĂ `instanceof` într-un lifecycle listener**.
- **Action** = unde se face munca reală (DB writes, API calls, notifications). Listener-ul cheamă `SomeAction::run(...)`. Listener-ele sunt scurte: decide dacă rulează, apoi delegă.

## Synchronous by Default

- Pre-save listeners (`ModelCreating` / `ModelUpdating` / `ModelDeleting`) sunt **întotdeauna sincrone** — mutațiile pe `$model` persistă în același INSERT/UPDATE. **NICIODATĂ `implements ShouldQueue` pe pre-save**.
- Post-save listeners (`ModelCreated` / `ModelUpdated` / `ModelDeleted`) sincrone implicit; queueing e opt-in explicit (`implements ShouldQueue`), per listener, pe instrucțiune.

## Auto-Discovery (Laravel 11+)

Fiecare listener trait expune `public function handle(EventClass $event)` cu tip explicit. Laravel auto-discovers listenerul din această signature — fără `$listen` array, fără `EventServiceProvider` registration.

## External / Vendor Models

Dacă modelul e în Laravel core sau vendor și nu poate fi subclassed:
```php
// În AppServiceProvider::boot()
VendorModel::created(\Rdcstarr\SuperpowerEvents\Events\ModelCreated::dispatch(...));
```
Listener-ele rămân la fel: `handleModel(VendorModel $model)`.

## Contributing / Local Dev

- `composer install` apoi `composer test` (Pest + Orchestra Testbench).
- Smoke test confirmă dispatch end-to-end pentru `ModelCreating` + `ModelCreated`. Adaugă teste similare când adaugi feature-uri.
- Commit messages: `feat(events): ...`, `fix(events): ...`, `docs(events): ...`.

---

Personal toolkit — no support guarantees.
